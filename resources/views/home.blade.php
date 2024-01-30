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
                    <a href="{{ route('initiateChat') }}" title="Cutomer Chat" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Click here to Cutomer Chat</a>
                    @endif
                    @if(auth()->user()->role == "support_agent")
                    <a href="{{ route('view-chats') }}" title="Support Agent" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Click here to Support Agent</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection