<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('id', 'desc')->limit(5)->get();
        return view('dosen.dashboard.index', compact('notifications'));
    }
}
