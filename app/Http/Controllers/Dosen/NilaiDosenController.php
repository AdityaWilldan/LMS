<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;

class NilaiDosenController extends Controller
{
    public function index()
    {
        return view('dosen.nilai.index');
    }
}