<?php

namespace App\Http\Controllers;
use App\Events\NewMessageEvent;
use App\Models\Message;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Event\MessageEvent;

class ChatController extends Controller
{

public function __construct()
{
    $this->middleware('auth');
    $this->middleware('role:customer', ['only' => ['customerMethod']]);
    $this->middleware('role:support_agent', ['only' => ['supportAgentMethod']]);
}
public function initiateChat()
    {
        // Logic for initiating a chat
        $customer= Message::where('user_id',auth()->user()->id)->get();
        return view('customer.chat',compact('customer'));
    }

    public function sendMessage(Request $request)
    {
        $user = auth()->user();
    
        // Validate the request
        $request->validate([
            'message' => 'required|string',
        ]);
    
        // Save the message to the database
        $message = new Message([
            'user_id' => $user->id,
            'text' => $request->input('message'),
            
        ]);
        $message->save();
    
        // Broadcast the new message
        broadcast(new NewMessageEvent($message,$user));
    
        return redirect('/initiate-chat');
    }

    public function viewChats()
    {
        // Logic for support agent to view incoming chats
$customer=Message::all();
        return view('support_agent.chat',compact('customer'));
    }

    public function respondToChat(Request $request)
    {
        // Logic for support agent to respond to a chat
        // Save the response to the database, broadcast it, etc.
        $user = auth()->user();

        $message = new Message([
            'user_id' => $user->id,
            'text' => $request->input('response'),
        ]);
    
        $message->save();
    
        event(new NewMessageEvent($message,$user));

       
        
        return redirect('/view-chats');
    }
}
