<!-- resources/views/support_agent/chats.blade.php -->
@extends('layouts.app')
<head>
<style>
        .sender {
            background-color: #DCF8C6; /* Set your sender background color */
            text-align: right;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .receiver {
            background-color: skyblue; /* Set your receiver background color to skyblue */
            text-align: left;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .chat-container {
            max-width: 600px; /* Adjust the maximum width as per your layout */
            margin: auto;
            margin-top: 20px;
        }

        .response-form {
            margin-top: 20px;
        }
    </style>
</head>
@section('content')
<div class="container">
    <h2>Chat with customer</h2>
    <!-- List of incoming chats for support agents goes here -->
   
    <!-- Chat response form -->

    <form method="POST" action="{{ route('respond-to-chat') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
        @method('POST')
        @csrf
        <textarea name="response" rows="4" cols="50" placeholder="Type your response..."></textarea>
        <input type="hidden" name="user_id" value="{{$customer_id}}">
        <button type="submit" class="btn btn-primary">Send Response</button>
    </form>
    @foreach($customer as $customers)
        @if($customers->user_id == auth()->user()->id)
            <div class="sender">
                <p>{{$customers->text}} </p>
            </div>
        @else
            <div class="receiver">
                <p>{{$customers->text}}</p>
            </div>
        @endif
    @endforeach
</div>
@endsection