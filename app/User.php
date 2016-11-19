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
     *
     * Work in progress...
     */
    public function conversations()
    {
        /**
         * Got this voted up on StackOverflow:
         * http://stackoverflow.com/questions/29751859/laravel-5-hasmany-relationship-on-two-columns
         * But fails with error:
         * "LogicException with message 'Relationship method must return an object of type Illuminate\Database\Eloquent\Relations\Relation"
         */
        return $this->conversationsInitiated->merge($this->conversationsNotInitiated);
        
        // kinda works but problematic with chaining:
        // return $this->conversationsInitiated()->union($this->conversationsNotInitiated());
        
        // works but also loads the user
        // https://laracasts.com/discuss/channels/eloquent/merge-two-relationships-returns-method-addeagerconstraints-does-not-exist
        // return $this->with('conversationsInitiated', 'conversationsNotInitiated');
    }

    /**
     * Get conversation with specified user.
     */
    public function conversationWith($user_id)
    {
        // return $this->conversations()->where('respondent_id', $user_id)->first();

        // Get whether the user is the initiator or respondent.

        $conversationNotInitiatedWith = $this->conversations()->where('respondent_id', $user_id)->first();

        $conversationInitiatedWith = $this->conversations()->where('initiator_id', $user_id)->first();

        return $conversationInitiatedWith ?: $conversationNotInitiatedWith ?: null;

        // return $this->conversations()->where('respondent_id', $user_id)->first();
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
