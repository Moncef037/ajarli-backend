<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // get all notifications of the authenticated user
    public function getNotifications(Request $request)
    {
        $user = $request->user();

        $notifications = $user->notifications;

        return response()->json($notifications);
    }

    // get unread notifications of the authenticated user
    public function getUnreadNotifications(Request $request)
    {
        $user = $request->user();

        $unreadNotifications = $user->unreadNotifications;

        return response()->json($unreadNotifications);
    }

    // mark a notification as read
    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();

        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            return response()->json(['message' => 'Notification marked as read']);
        }

        return response()->json(['message' => 'Notification not found'], 404);
    }

    // mark all notifications as read
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();

        $user->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
