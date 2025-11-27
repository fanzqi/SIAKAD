<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Tandai notifikasi dibaca
// app/Http/Controllers/Akademik/NotificationController.php
public function markAsRead($id)
{
    $user = auth()->user();

    $user->notifications()->syncWithoutDetaching([
        $id => ['is_read' => 1]
    ]);

    return response()->json(['success' => true]);
}


    // Hapus notifikasi (opsional)
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if(!$notification){
            return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan']);
        }

        $notification->delete();

        return response()->json(['success' => true]);
    }

    // Buat notifikasi global (duplikasi ke semua user)
    public function createGlobalNotification($author, $type, $message)
    {
        // Notifikasi master
        $master = Notification::create([
            'user_id' => null,
            'author_name' => $author,
            'type' => $type,
            'message' => $message,
            'is_read' => 0,
        ]);

        // Duplikasi untuk semua user
        $users = \App\Models\User::all();
        foreach($users as $user){
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


}
