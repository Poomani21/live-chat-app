<!-- resources/views/support_agent/chats.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Support Agent Chats</h2>
    <!-- List of incoming chats for support agents goes here -->
    @foreach($customer as $customers)
    <ul>
        <li>
            {{$customers->text}}
        </li>
        <!-- ... -->
    </ul>
    @endforeach
    <!-- Chat response form -->

    <form method="POST" action="{{ route('respond-to-chat') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
        @method('POST')
        @csrf
        <textarea name="response" rows="4" cols="50" placeholder="Type your response..."></textarea>
        <button type="submit">Send Response</button>
    </form>
</div>
@endsection