<!-- resources/views/customer/chat.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Customer Chat</h2>
    <!-- Your chat interface for customers goes here -->

    <form method="POST" action="{{ route('initiate-chat') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
        @method('POST')
        @csrf
        <textarea name="message" rows="4" cols="50" placeholder="Type your message..."></textarea>
        <button type="submit">Send Message</button>
    </form>

    @foreach($customer as $customers)
    <p>{{$customers->text}}</p>
    @endforeach
</div>
@endsection