<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchiveModel extends Model
{
    protected $table            = 'archives';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'user_id',
        'title',
        'description',
        'file_name',
        'original_file_name',
        'file_type',
        'file_size',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil daftar arsip beserta nama kategori dan nama uploader
     */
    public function getArchivesWithRelations($categoryId = null)
    {
        $builder = $this->select('archives.*, categories.name as category_name, users.name as user_name')
                        ->join('categories', 'categories.id = archives.category_id', 'left')
                        ->join('users', 'users.id = archives.user_id', 'left');

        if (!empty($categoryId)) {
            $builder->where('archives.category_id', $categoryId);
        }

        return $builder->orderBy('archives.created_at', 'DESC')->findAll();
    }

    /**
     * Mengambil 1 arsip detail dengan relasi
     */
    public function getArchiveDetail($id)
    {
        return $this->select('archives.*, categories.name as category_name, users.name as user_name')
                    ->join('categories', 'categories.id = archives.category_id', 'left')
                    ->join('users', 'users.id = archives.user_id', 'left')
                    ->where('archives.id', $id)
                    ->first();
    }
}
