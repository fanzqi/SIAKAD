<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tandai notifikasi tertentu sebagai dibaca
     */
    public function markAsRead($id)
    {
        // Ambil notifikasi user yang login
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ], 404);
        }

        $notification->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    /**
     * Hapus notifikasi milik user
     */
    public function destroy($id)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ], 404);
        }

        $notification->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Buat notifikasi global untuk semua user
     */
    public function createGlobalNotification(string $author, string $type, string $message)
    {
        // Opsional: notifikasi master (arsip global)
        Notification::create([
            'user_id' => null,
            'author_name' => $author,
            'type' => $type,
            'message' => $message,
            'is_read' => 0,
        ]);

        // Duplikasi ke semua user
        $users = User::all();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'author_name' => $author,
                'type' => $type,
                'message' => $message,
                'is_read' => 0,
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Tandai semua notifikasi user sebagai dibaca
     */
    public function markAllAsRead()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        Notification::where('user_id', $user->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }
}