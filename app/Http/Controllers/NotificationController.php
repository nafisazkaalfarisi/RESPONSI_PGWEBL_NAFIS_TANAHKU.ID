<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua notifikasi (dengan pagination)
        $notifications = $user->notifications()->latest()->paginate(10);

        // Tandai semua notifikasi sebagai sudah dibaca
        $user->unreadNotifications->markAsRead();

        return view('notifications', compact('notifications'));
    }
}
