<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hasMessages = Schema::hasTable('messages');

        $stats = [
            'unread'         => $hasMessages ? \Modules\Messaging\Models\Message::where('receiver_id', $user->id)->where('is_read', false)->count() : 0,
            'sent_today'     => $hasMessages ? \Modules\Messaging\Models\Message::where('sender_id', $user->id)->whereDate('created_at', today())->count() : 0,
            'total_users'    => User::where('is_active', true)->count(),
            'total_messages' => $hasMessages ? \Modules\Messaging\Models\Message::where('receiver_id', $user->id)->orWhere('sender_id', $user->id)->count() : 0,
        ];

        $recentMessages = $hasMessages
            ? \Modules\Messaging\Models\Message::where('receiver_id', $user->id)->with('sender')->latest()->take(5)->get()
            : collect();

        return view('tenants.dashboard', compact('stats', 'recentMessages'));
    }
}