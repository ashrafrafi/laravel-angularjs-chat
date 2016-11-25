@extends('layouts.app')

@section('content')
<div ng-controller="AppController as app" ng-init="app.index()">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Conversations (@{{ app.conversations.length }})</div>
                    <div class="list-group">
                      <a ng-repeat="conversation in app.conversations" ng-click="app.getMessages(conversation)" href="#" class="list-group-item" ng-class="{'active': app.conversation.id == conversation.id}">
                        <h4 class="list-group-item-heading">
                            {{-- Display with whom the conversation with. --}}
                            <span ng-if="app.me.id == conversation.initiator.id">
                                @{{ conversation.respondent.name }}
                            </span>
                            <span ng-if="app.me.id != conversation.initiator.id">
                                @{{ conversation.initiator.name }}
                            </span>
                        </h4>
                        <p class="list-group-item-text">Since: @{{ conversation.created_at }}</p>
                      </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default full-height">
                    <div class="panel-heading">Messages (@{{ app.messages.length }})</div>
                    <div class="panel-body scrollable max-height" scroll-glue>
                        <div ng-repeat="message in app.messages track by $index" class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-circle" src="https://placehold.it/32x32" alt="@{{ message.sender.name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <p>
                                    @{{ message.text }}
                                    <br>
                                    <small>@{{ message.sender.name }} - @{{ message.created_at }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <form ng-submit="app.sendMessage(message)">
                            <div class="input-group">
                                    <input ng-model="message" type="text" class="form-control" placeholder="Type message..." autofocus="">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Send</button>
                                    </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
