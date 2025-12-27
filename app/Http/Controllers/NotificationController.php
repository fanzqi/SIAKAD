<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Ambil 5 notifikasi terbaru untuk user yang belum dibaca
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        // Mapping: tiap role hanya lihat tipe notifikasi khusus
        $roleNotifications = [
            'warek1'    => ['pengajuan', 'revisi_selesai'],
            'akademik'  => ['revisi', 'disetujui'],
            'dosen'     => ['distribusi'],
            'kaprodi'   => ['distribusi'],
            'dekan'     => ['distribusi'],
            'mahasiswa' => ['distribusi'],
        ];

        $query = $user->notifications()
            ->wherePivot('is_read', 0)
            ->orderByPivot('created_at', 'desc');

        // Filter berdasarkan role
        $userRole = $user->role;
        if(array_key_exists($userRole, $roleNotifications)) {
            $query->whereIn('notifications.type', $roleNotifications[$userRole]);
        } else {
            $query->whereRaw('1=0');
        }

        $notifications = $query->limit(5)->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Tandai notifikasi tertentu sebagai dibaca
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        $notification = Notification::findOrFail($id);

        $user->notifications()->syncWithoutDetaching([
            $notification->id => ['is_read' => 1]
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Hapus notifikasi dari user
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        $notification = Notification::findOrFail($id);

        $user->notifications()->detach($notification->id);

        return response()->json(['success' => true]);
    }

    /**
     * Tandai semua notifikasi user sebagai dibaca
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        $notifications = $user->notifications()->pluck('notifications.id')->toArray();
        $syncData = [];

        foreach ($notifications as $id) {
            $syncData[$id] = ['is_read' => 1];
        }

        $user->notifications()->syncWithoutDetaching($syncData);

        return response()->json(['success' => true]);
    }

    /**
     * Buat notifikasi global dan attach ke semua user (kecuali Auth::id())
     */
    public function createGlobalNotification(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string',
            'type' => 'required|string',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'author_name' => $request->author_name,
            'type' => $request->type,
            'message' => $request->message
        ]);

        $currentUserId = Auth::id();

        // Attach ke semua user tanpa duplikasi dan tanpa creator
        User::where('id', '!=', $currentUserId)->each(function ($user) use ($notification) {
            $user->notifications()->syncWithoutDetaching([
                $notification->id => ['is_read' => 0]
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi global berhasil dikirim ke semua user.',
            'notification_id' => $notification->id
        ]);
    }
}
