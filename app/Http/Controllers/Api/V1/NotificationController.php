<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GetNotificationsCollection;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $user = auth('api')->user();

        $type = ["App\\Notifications\\PostLiked", "App\\Notifications\\UserFollowed"];

        $notifications = DatabaseNotification::where('notifiable_id', $user->id)
            ->whereIn('type', $type)
            ->orderBy('created_at', 'desc')
            ->where('created_at', '>', Carbon::now()->subDays(30))
            ->paginate(50);

        return new GetNotificationsCollection($notifications);
    }

    public function markNotificationAsRead(Request $request)
    {
        DatabaseNotification::where('id', $request->notification_id)->update(['read_at' => Carbon::now()]);

        return response(['success' => true], 200);
    }
}
