<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get initiated and non-initiated conversations.
     */
    public function conversations()
    {
        return $this->conversationsInitiated->merge($this->conversationsNotInitiated);
    }

    /**
     * Get conversation with specified user.
     */
    public function conversationWith($user_id)
    {
        $conversationNotInitiatedWith = $this->conversations()->where('respondent_id', $user_id)->first();

        $conversationInitiatedWith = $this->conversations()->where('initiator_id', $user_id)->first();

        return $conversationInitiatedWith ?: $conversationNotInitiatedWith ?: null;
    }

    /**
     * Get conversations the user started.
     */
    public function conversationsInitiated()
    {
        return $this->hasMany('App\Conversation', 'initiator_id');
    }

    /**
     * Get conversations other users initiated to the user.
     */
    public function conversationsNotInitiated()
    {
        return $this->hasMany('App\Conversation', 'respondent_id');
    }
}
