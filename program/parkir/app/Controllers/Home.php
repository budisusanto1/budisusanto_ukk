<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktivitas;

class Home extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitas();
    }
    public function index()
    {
        // Jika user sudah login, redirect ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        // Log aktivitas akses welcome page (guest)
        $this->logModel->logActivity(
            null, // NULL untuk guest
            'Mengakses halaman welcome (guest)'
        );
        
        return view('welcome_message');
    }
}
