<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id', 'sender_id', 'text',
    ];

    /**
     * Get which conversation the message belongs to.
     */
    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }

    /**
     * Get user who created the message.
     */
    public function sender()
    {
    	return $this->belongsTo('App\User', 'sender_id');
    }
}
