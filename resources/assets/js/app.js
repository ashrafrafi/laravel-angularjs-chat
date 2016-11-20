/**
 * Angular
 */
(function() {
	
	'use strict';

	angular
		.module('app', ['ngResource'])
		.controller('ConversationsController', ConversationsController);

	ConversationsController.$inject = ['$resource'];

	function ConversationsController($resource) {
		/**
		 * Resources
		 */
		var Conversation = $resource('/conversations/:conversation_id', {conversation_id: '@conversation_id'});
		var Message = $resource('/conversations/:conversation_id/messages', {conversation_id: '@conversation_id', message_id: '@message_id'});

		/**
		 * View Model
		 */
		var vm = this;
		vm.message = 'hello world!';
		
		vm.conversations = null
		vm.conversation = null
		vm.messages = null

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
			)
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
			)
		}
	}

})();