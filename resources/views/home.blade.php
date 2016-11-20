@extends('layouts.app')

@section('content')
<div ng-controller="ConversationsController as conversations">

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Conversations</div>

                    <div class="panel-body">
                        @{{ conversations.conversations }}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Messages</div>

                    <div class="panel-body">
                        <p>
                            @{{ conversations.messages }}
                        </p>
                        <p>@{{ conversations.message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
