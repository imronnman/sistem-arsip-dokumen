<?php

namespace App\Controllers;

use App\Models\ArchiveModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $archiveModel;
    protected $categoryModel;
    protected $userModel;

    public function __construct()
    {
        $this->archiveModel  = new ArchiveModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel     = new UserModel();
    }

    public function index()
    {
        $totalArchives   = $this->archiveModel->countAllResults();
        $totalCategories = $this->categoryModel->countAllResults();
        $totalUsers      = $this->userModel->countAllResults();
        
        $totalPdf = $this->archiveModel->like('file_type', 'pdf')->countAllResults();
        $totalImg = $this->archiveModel->groupStart()
                                       ->like('file_type', 'image')
                                       ->orLike('file_type', 'jpeg')
                                       ->orLike('file_type', 'jpg')
                                       ->orLike('file_type', 'png')
                                       ->groupEnd()
                                       ->countAllResults();

        $recentArchives = $this->archiveModel->getArchivesWithRelations();
        $recentArchives = array_slice($recentArchives, 0, 5);

        $data = [
            'title'           => 'Dashboard',
            'totalArchives'   => $totalArchives,
            'totalCategories' => $totalCategories,
            'totalUsers'      => $totalUsers,
            'totalPdf'        => $totalPdf,
            'totalImg'        => $totalImg,
            'recentArchives'  => $recentArchives,
        ];

        return view('dashboard/index', $data);
    }
}
