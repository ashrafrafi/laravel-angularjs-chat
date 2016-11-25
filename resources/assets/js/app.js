/**
 * Angular
 */
(function() {
	
	'use strict';

	angular
		.module('app', ['ngResource', 'luegg.directives'])
		.controller('AppController', AppController);

	AppController.$inject = ['$resource'];

	function AppController($resource) {
		/**
		 * Resources
		 */
		var User = $resource(
				'/users/:user_id',
				{user_id: '@user_id'},
				{
					'me': {
				      url: '/users/me',
				      method: 'GET'
				    }
				}
			);
		var Conversation = $resource('/conversations/:conversation_id', {conversation_id: '@conversation_id'});
		var Message = $resource('/conversations/:conversation_id/messages', {conversation_id: '@conversation_id', message_id: '@message_id'});

		/**
		 * View Model
		 */
		var vm = this;
		vm.message = 'hello world!';
		
		vm.users = null;
		vm.user = null;
		vm.me = null; // The currently authenticated user.

		vm.conversations = null;
		vm.conversation = null;
		vm.messages = null;

		vm.index = function(){
			vm.getConversations();

			vm.getMe();
		}

		vm.getMe = function(){
			User.me(
				{},
				function(response){
					vm.me = response;

					console.log('Got me:');
					console.log(vm.me);
				},
				function(error){
					console.log('Could not load authenticated user.');
				}
			);
		}

		vm.getConversations = function(){
			console.log('Getting conversations...');

			Conversation.query(
				{},
				function(response){
					console.log('Got conversations:');
					console.log(response);
					vm.conversations = response;

					// set first conversation as active
					vm.conversation = response[0];
					console.log('Conversation:');
					console.log(vm.conversation);

					// get messages of the conversation
					vm.getMessages(vm.conversation);
				},
				function(error){
					console.log(error)
				}
			);
		}

		vm.getMessages = function(conversation){
			
			console.log('Getting conversation messages: ' + conversation);

			vm.conversation = conversation;

			Message.query(
				{ conversation_id: conversation.id },
				function(response){
					console.log('Got messages:');
					console.log(response);
					vm.messages = response;
				},
				function(error){
					console.log(error);
				}
			);
		}

		vm.sendMessage = function(text){
			
			console.log('Sending message...');

			Message.save(
				{
					conversation_id: vm.conversation.id,
					text: text
				},
				function(response){
					vm.messages.push(response);

					console.log('Message sent:');
					console.log(response);
					console.log(vm.messages);
				},
				function(error){
					console.log(error);
				}
			);
		}
	} // AppController

})();