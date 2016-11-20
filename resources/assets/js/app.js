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
		var Conversation = $resource('api/conversations/:conversation_id', {conversation_id: '@conversation_id'});
		var Message = $resource('api/conversations/:conversation_id', {conversation_id: '@conversation_id', message_id: '@message_id'});

		/**
		 * View Model
		 */
		var vm = this;
		vm.message = 'hello world!';
		vm.conversations = getConversations();
		vm.messages = getMessages();

		function getConversations(){
			console.log('Getting conversations...');

			Conversation.query(
				{},
				function(response){
					console.log('Got conversations:');
					console.log(response);
				},
				function(error){
					console.log(error)
				}
			)
		}

		function getMessages(){
			return 'Some messages...'
		}
	}

})();