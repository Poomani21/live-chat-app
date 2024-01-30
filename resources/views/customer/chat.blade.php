<!-- resources/views/customer/chat.blade.php -->
@extends('layouts.app')
<head>
    <style>
.sender {
    background-color: #DCF8C6; /* Set your sender background color */
    text-align: right;
}

.receiver {
    background-color: skyblue; /* Set your receiver background color to skyblue */
    text-align: left;
}

    </style>
</head>
@section('content')
<div class="container">
    <h2>chat with support agent</h2>
    <!-- Your chat interface for customers goes here -->

    <form method="POST" action="{{ route('initiate-chat') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
        @method('POST')
        @csrf
        <textarea name="message" rows="4" cols="50" placeholder="Type your message..."></textarea>
        <button type="submit">Send Message</button>
    </form>

    @foreach($customer as $customers)
        @if($customers->user_id == auth()->user()->id)
            <div class="sender">
                <p>{{$customers->text}}</p>
            </div>
        @else
            <div class="receiver">
                <p>{{$customers->text}}</p>
            </div>
        @endif
    @endforeach
</div>
@endsection