<?php

namespace App\Http\Controllers;
use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\User;
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
        $usersWithSupportAgentRole = User::where('role', 'support_agent')->first();
        $customer_id = $usersWithSupportAgentRole->id;
        $customer = Message::where(function ($query) use ($customer_id) {
            $query->where('user_id', auth()->user()->id) // Messages sent by the agent
                ->where('receiver_id', $customer_id);
        })->orWhere(function ($query) use ($customer_id) {
            $query->where('user_id', $customer_id) // Messages sent by the customer
                ->where('receiver_id', auth()->user()->id);
        })->get();
        return view('customer.chat',compact('customer'));
    }

    public function sendMessage(Request $request)
    {
        $user = auth()->user();
    
        // Validate the request
        $request->validate([
            'message' => 'required|string',
        ]);
        $usersWithSupportAgentRole = User::where('role', 'support_agent')->first();
    
        // Save the message to the database
        $message = new Message([
            'user_id' => $user->id,
            'text' => $request->input('message'),
            'receiver_id'=>$usersWithSupportAgentRole->id
        ]);
        $message->save();
    
        // Broadcast the new message
        broadcast(new NewMessageEvent($message,$user));
    
        return redirect('/initiate-chat');
    }

    public function viewChats($selectedCustomerId)
    {
        // Logic for support agent to view incoming chats
        $usersWithSupportAgentRole = User::where('role', 'support_agent')->first();
        $userId = auth()->user()->id;
        $customer_id = $selectedCustomerId; // Replace this with the ID of the customer you're selecting

        $customer = Message::where(function ($query) use ($customer_id) {
            $query->where('user_id', auth()->user()->id) // Messages sent by the agent
                ->where('receiver_id', $customer_id);
        })->orWhere(function ($query) use ($customer_id) {
            $query->where('user_id', $customer_id) // Messages sent by the customer
                ->where('receiver_id', auth()->user()->id);
        })->get();

        

        return view('support_agent.chat',compact('customer','customer_id'));
    }

    public function respondToChat(Request $request)
    {
        // Logic for support agent to respond to a chat
        // Save the response to the database, broadcast it, etc.
        $user = auth()->user();

        $message = new Message([
            'user_id' => $user->id,
            'text' => $request->input('response'),
            'receiver_id'=>$request->user_id
        ]);
    
        $message->save();
    
        event(new NewMessageEvent($message,$user));

       
        
        return redirect()->route('view-chats', ['id' => $request->user_id]);
    }
}
