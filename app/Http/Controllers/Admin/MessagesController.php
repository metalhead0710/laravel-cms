<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\Http\Controllers\ControllerBase;
use PyroMans\Message;

class MessagesController extends ControllerBase
{
    public function index()
    {
        $newMessages = Message::where('isNew', true)->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.messages.index', [
            'newMessages' => $newMessages
        ]);
    }
    public function view($id)
    {
        $message = Message::find($id);
        if($message->isNew)
        {
            $message->isNew = false;
            $message->save();
        }
        return $message;
    }
    public function read()
    {
        $readMessages = Message::where('isNew', false)->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.messages.read', [
            'readMessages' => $readMessages
        ]);
    }
    public function all()
    {
        $messages = Message::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.messages.all', [
            'messages' => $messages
        ]);
    }
    public function markasread(Request $request)
    {
        $ids = $request->input('ids');
        $markAsRead = Message::whereIn('id', $ids)
            ->update(['isNew' => false]);
        if ($markAsRead) {
            return redirect()->route('admin.messages')->with('success', 'Повідомлення позначено як прочитані');
        }
        return redirect()->route('admin.messages')->with('error', 'Помилка, спробуйте пізніше');
}

    public function delete(Request $request)
    {
        $ids = $request->input('ids');
        $delete = Message::whereIn('id', $ids)
            ->delete();
        if ($delete) {
            return redirect()->back()->with('success', 'Повідомлення видалено');
        }
        return redirect()->back()->with('error', 'Помилка, спробуйте пізніше');

    }

}
