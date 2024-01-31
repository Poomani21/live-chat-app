@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(auth()->user()->role == "customer")
                        <a href="{{ route('initiateChat') }}" title="Customer Chat" class="btn btn-warning btn-sm">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Click here to Chat with Support
                        </a>
                    @endif

                    @if(auth()->user()->role == "support_agent")
                        <ul class="chat-list">
                            @forelse ($customers as $user)
                                <li class="chat-list-item">
                                    <a href="{{ route('view-chats', ['id' => $user->user_id]) }}" title="Support Agent"
                                       class="btn btn-warning btn-sm chat-list-link">
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i>{{$user->user->name}}
                                    </a>
                                </li>
                            @empty
                                <p>No customers</p>
                            @endforelse
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
