<?php

namespace App\Controllers;

use App\Models\ArchiveModel;
use App\Models\CategoryModel;

class Archives extends BaseController
{
    protected $archiveModel;
    protected $categoryModel;
    protected $uploadPath;

    public function __construct()
    {
        $this->archiveModel  = new ArchiveModel();
        $this->categoryModel = new CategoryModel();
        $this->uploadPath    = FCPATH . 'uploads/archives/';

        // Pastikan folder uploads/archives selalu ada
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    public function index()
    {
        $categoryId = $this->request->getGet('category_id');

        $data = [
            'title'           => 'Manajemen Arsip Dokumen',
            'archives'        => $this->archiveModel->getArchivesWithRelations($categoryId),
            'categories'      => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'selectedCategory'=> $categoryId,
        ];

        return view('archives/index', $data);
    }

    public function create()
    {
        $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();
        if (empty($categories)) {
            return redirect()->to('/kategori')->with('warning', 'Harap buat minimal 1 kategori terlebih dahulu sebelum menambah arsip.');
        }

        $data = [
            'title'      => 'Tambah Arsip Dokumen Baru',
            'categories' => $categories,
        ];

        return view('archives/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required|is_not_unique[categories.id]',
            'description' => 'permit_empty|max_length[1000]',
            'document'    => [
                'rules'  => 'uploaded[document]|max_size[document,5120]|ext_in[document,pdf,jpg,jpeg,png]|mime_in[document,application/pdf,image/jpeg,image/png,image/pjpeg]',
                'errors' => [
                    'uploaded' => 'File dokumen wajib diunggah.',
                    'max_size' => 'Ukuran file dokumen maksimal 5 MB.',
                    'ext_in'   => 'Format dokumen hanya boleh PDF, JPG, JPEG, atau PNG.',
                    'mime_in'  => 'Tipe MIME file tidak diizinkan.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('document');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName      = $file->getRandomName();
            $originalName = $file->getClientName();
            $fileType     = $file->getClientMimeType();
            $fileSize     = round($file->getSize('kb')); // Simpan dalam KB

            $file->move($this->uploadPath, $newName);

            $this->archiveModel->save([
                'category_id'        => $this->request->getPost('category_id'),
                'user_id'            => session()->get('id') ?? 1,
                'title'              => $this->request->getPost('title'),
                'description'        => $this->request->getPost('description'),
                'file_name'          => $newName,
                'original_file_name' => $originalName,
                'file_type'          => $fileType,
                'file_size'          => $fileSize,
            ]);

            return redirect()->to('/arsip')->with('success', 'Dokumen arsip berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file dokumen.');
    }

    public function edit($id)
    {
        $archive = $this->archiveModel->find($id);
        if (!$archive) {
            return redirect()->to('/arsip')->with('error', 'Dokumen arsip tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Arsip Dokumen',
            'archive'    => $archive,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('archives/edit', $data);
    }

    public function update($id)
    {
        $archive = $this->archiveModel->find($id);
        if (!$archive) {
            return redirect()->to('/arsip')->with('error', 'Dokumen arsip tidak ditemukan.');
        }

        $rules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required|is_not_unique[categories.id]',
            'description' => 'permit_empty|max_length[1000]',
        ];

        $file = $this->request->getFile('document');
        $hasNewFile = $file && $file->isValid() && !$file->hasMoved();

        if ($hasNewFile) {
            $rules['document'] = [
                'rules'  => 'max_size[document,5120]|ext_in[document,pdf,jpg,jpeg,png]|mime_in[document,application/pdf,image/jpeg,image/png,image/pjpeg]',
                'errors' => [
                    'max_size' => 'Ukuran file dokumen maksimal 5 MB.',
                    'ext_in'   => 'Format dokumen hanya boleh PDF, JPG, JPEG, atau PNG.',
                    'mime_in'  => 'Tipe MIME file tidak diizinkan.',
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'category_id' => $this->request->getPost('category_id'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];

        if ($hasNewFile) {
            // Hapus file lama jika ada
            $oldFilePath = $this->uploadPath . $archive['file_name'];
            if (is_file($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Simpan file baru
            $newName      = $file->getRandomName();
            $originalName = $file->getClientName();
            $fileType     = $file->getClientMimeType();
            $fileSize     = round($file->getSize('kb'));

            $file->move($this->uploadPath, $newName);

            $updateData['file_name']          = $newName;
            $updateData['original_file_name'] = $originalName;
            $updateData['file_type']          = $fileType;
            $updateData['file_size']          = $fileSize;
        }

        $this->archiveModel->update($id, $updateData);

        return redirect()->to('/arsip')->with('success', 'Data arsip dokumen berhasil diperbarui.');
    }

    public function delete($id)
    {
        $archive = $this->archiveModel->find($id);
        if (!$archive) {
            return redirect()->to('/arsip')->with('error', 'Dokumen arsip tidak ditemukan.');
        }

        // Hapus fisik file
        $filePath = $this->uploadPath . $archive['file_name'];
        if (is_file($filePath)) {
            unlink($filePath);
        }

        $this->archiveModel->delete($id);

        return redirect()->to('/arsip')->with('success', 'Dokumen arsip beserta filenya berhasil dihapus.');
    }

    /**
     * Preview dokumen langsung di browser (PDF / Image)
     */
    public function preview($id)
    {
        $archive = $this->archiveModel->find($id);
        if (!$archive) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Dokumen tidak ditemukan.');
        }

        $filePath = $this->uploadPath . $archive['file_name'];
        if (!is_file($filePath)) {
            return redirect()->to('/arsip')->with('error', 'File dokumen fisik tidak ditemukan di server.');
        }

        return $this->response
                    ->setHeader('Content-Type', $archive['file_type'])
                    ->setHeader('Content-Disposition', 'inline; filename="' . $archive['original_file_name'] . '"')
                    ->setBody(file_get_contents($filePath));
    }

    /**
     * Download dokumen dengan nama file aslinya
     */
    public function download($id)
    {
        $archive = $this->archiveModel->find($id);
        if (!$archive) {
            return redirect()->to('/arsip')->with('error', 'Dokumen arsip tidak ditemukan.');
        }

        $filePath = $this->uploadPath . $archive['file_name'];
        if (!is_file($filePath)) {
            return redirect()->to('/arsip')->with('error', 'File dokumen fisik tidak ditemukan di server.');
        }

        return $this->response->download($filePath, null)->setFileName($archive['original_file_name']);
    }
}
