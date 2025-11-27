<?php

namespace App\Http\Controllers\Dekan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('id', 'desc')->limit(5)->get();
        return view('dekan.dashboard.index', compact('notifications'));
    }
}