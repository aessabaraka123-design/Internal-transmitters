<?php

namespace Modules\Messaging\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Messaging\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * نظام المراسلات الداخلية
 * يعمل داخل قاعدة بيانات كل شركة منفصلة
 */
class MessageController extends Controller
{
    /**
     * صندوق الوارد
     */
    public function inbox()
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->with('sender')
            ->latest()
            ->paginate(20);

        $unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('messaging::messages.inbox', compact('messages', 'unreadCount'));
    }

    /**
     * الرسائل المُرسَلة
     */
    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())
            ->with('receiver')
            ->latest()
            ->paginate(20);

        return view('messaging::messages.sent', compact('messages'));
    }

    /**
     * عرض محادثة مع مستخدم معين
     */
    public function conversation(User $user)
    {
        $messages = Message::conversation(Auth::id(), $user->id)
            ->with(['sender', 'receiver'])
            ->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->get()
            ->each(fn($msg) => $msg->markAsRead());

        $users = User::where('id', '!=', Auth::id())
                      ->where('is_active', true)
                      ->get();

        return view('messaging::messages.conversation', compact('messages', 'user', 'users'));
    }

    /**
     * نموذج إرسال رسالة جديدة
     */
    public function compose()
    {
        $users = User::where('id', '!=', Auth::id())
                      ->where('is_active', true)
                      ->get();

        return view('messaging::messages.compose', compact('users'));
    }

    /**
     * إرسال رسالة
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id|different:' . Auth::id(),
            'body'        => 'required|string|max:5000',
            'attachment'  => 'nullable|file|max:5120',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')
                ->store('attachments', 'tenant');
        }

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'body'        => $validated['body'],
            'attachment'  => $validated['attachment'] ?? null,
        ]);

        return redirect()->route('messaging.sent')
                         ->with('success', 'تم إرسال رسالتك بنجاح ✓');
    }

    /**
     * حذف رسالة
     */
    public function destroy(Message $message)
    {
        abort_if(
            $message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id(),
            403, 'غير مصرح بهذا الإجراء'
        );

        $message->delete();

        return back()->with('success', 'تم حذف الرسالة');
    }
}