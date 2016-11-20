@extends('layouts.app')

@section('content')
<div ng-controller="ConversationsController as ctrl" ng-init="ctrl.getConversations()">

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Conversations (@{{ ctrl.conversations.length }})</div>
                    <div class="list-group">
                      <a ng-repeat="conversation in ctrl.conversations" ng-click="ctrl.getMessages(conversation)" href="#" class="list-group-item" ng-class="{'active': ctrl.conversation.id == conversation.id}">
                        <h4 class="list-group-item-heading">@{{ conversation.initiator.name }}, @{{ conversation.respondent.name }}</h4>
                        <p class="list-group-item-text">Since: @{{ conversation.created_at }}</p>
                      </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Messages (@{{ ctrl.messages.length }})</div>
                    <div class="panel-body">
                        <div ng-repeat="message in ctrl.messages track by $index" class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-circle" src="https://placehold.it/32x32">
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
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type message..." autofocus="">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Send</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
