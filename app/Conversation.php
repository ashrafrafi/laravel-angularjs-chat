<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'initiator_id', 'respondent_id',
    ];

    /**
     * Get the user who started the conversation.
     */
    public function initiator()
    {
        return $this->belongsTo('App\User', 'initiator_id');
    }

    /**
     * Get the user who did not initiate the conversation.
     */
    public function respondent()
    {
        return $this->belongsTo('App\User', 'respondent_id');
    }

    /**
     * Get the messages of the conversation.
     */
    public function messages()
    {
    	return $this->hasMany('App\Message');
    }

    /**
     * Scope conversations with specified user.
     */
    public function withUser($query, $user_id)
    {
        return $query->where('respondent_id', $user_id);
    }
}
