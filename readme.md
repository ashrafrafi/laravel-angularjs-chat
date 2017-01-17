# Laravel AngularJS Chat

A basic chat app on [Laravel](https://laravel.com) and [AngularJS](https://angularjs.org) using polling, long-polling and push techniques.

## Features

* Sends and receives messages to and from other users using **polling**, **long-polling** and **push** techniques.
* Powered by [Laravel](https://laravel.com) and [AngularJS](https://angularjs.org) for server-side and client-side processing.

## Why?

Because when you create real-time web applications, such as instant messaging and notifications, you have 3 options to make them work and each has their pros and cons.
This app serves as example using the 3 techniques to help you get started and decide your best approach on creating wonderful real-time web apps!

### Polling

Regular polling is a technique that implements the regular checking of data from the server. In any messaging app, the faster the rate at which data is checked, the more real-time the chat app feels, but the more bandwidth and unneccessary network requests are wasted. Although it is very effective and stable, it is not efficient.

To know more, please read about `'polling in computing'` online.

### Long-Polling

Long-polling is a technique that...

To know more, please read about `'long polling in computing'` online.

### Push

Push is a technique that...

To know more, please read about `'push technology in computing'` online.

## Setup

Open Terminal or Command Prompt and run the following commands:

* Cnone/download then open the app:

	`git clone git@github.com:doncadavona/laravel-angularjs-chat.git`

	`cd laravel-angularjs-chat`

* Install dependencies:

	`npm install`

* Compile assets:

	`gulp`

* Setup database:

	`php artisan db:migrate --seed`

* Serve and enjoy

	`php artisan serve`

## Usage

Upon successful setup, open your web browser and go to the URL from where it is served (eg. [http://localhost:8000]).

* Login with any sample account from the source code: `database/seeds/UsersTableSeeder.php`
* Send messages to other people.
* To observe the app's activities, open your browser's Development Tool `Ctrl + Shift + I` in Windows and `Command + Shift + I` in Mac and in the Development Tool, see the Network and Console tabs.

**To be continued... Check other branches for works in progress. Pull requests are welcomed!**