@extends('layouts.app')

@section('content')
<div ng-controller="AppController as app" ng-init="app.index()">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-3">
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                Settings
                            </div>
                            <div class="col-xs-6 text-right">
                                <button class="btn btn-default btn-sm" ng-click="app.updateSettings()">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        Method: <select ng-model="app.method" ng-options="method as method for method in app.methods" class="form-control"></select>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="panel panel-default full-height">
                    <div class="panel-heading">
                        Messages (@{{ app.messages.length }})
                    </div>
                    <div class="panel-body scrollable max-height" scroll-glue>
                        <div ng-repeat="message in app.messages track by $index" class="media">
                            <div ng-if="app.me.id != message.sender.id" class="media-left">
                                <a href="#">
                                    <img class="media-object img-circle" src="https://placehold.it/32x32" alt="@{{ message.sender.name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <p ng-class="{
                                    'text-primary': app.me.id != message.sender.id,
                                    'text-right':   app.me.id == message.sender.id,
                                }">
                                    @{{ message.text }}
                                    <br>
                                    <small ng-if="app.me.id != message.sender.id">@{{ message.sender.name }} - @{{ message.created_at }}</small>
                                    <small ng-if="app.me.id == message.sender.id">Me - @{{ message.created_at }}</small>
                                </p>
                            </div>
                            <div ng-if="app.me.id == message.sender.id" class="media-right">
                                <a href="#">
                                    <img class="media-object img-circle" src="https://placehold.it/32x32" alt="@{{ message.sender.name }}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <form name="messageForm" ng-submit="app.sendMessage(messageForm)">
                            <div class="input-group">
                                    <input ng-model="app.message" type="text" class="form-control" placeholder="Type message..." autofocus="" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" ng-disabled="messageForm.$invalid">Send</button>
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
