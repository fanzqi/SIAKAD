<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalkuliahController extends Controller
{
    public function index()
    {
        return view('jadwalkuliah.jadwalkuliah');
    }
    
}
