<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Conversation;

use Carbon\Carbon;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $conversation_id)
    {
        $conversation = Conversation::find($conversation_id);

        /**
         * Determine if client requests to poll or long-poll messages based on timestamp.
         * If the request has a timestamp, do a long-poll, else do regular polling.
         */
        if(!$request->has('timestamp')){
            // Regular polling. Simply return the requested resources.
            return $conversation->messages()->with('sender')->get()->sortBy('created_at');
        }
        else{
            /**
             * Long polling. More complicated. We do the following:
             * To determine if there are any new messages on the conversation,
             * keep matching the request timestamp to the timestamp of the last message from the conversation until it is older.
             * Then send back the updated messages.
             */
            
            $messages = $conversation->messages()->with('sender')->get()->sortBy('created_at');

            $started_at = Carbon::now();

            // echo '<br>Last message: '.$request->get('timestamp');
            // echo '<br>Started at: '.$started_at;
            // echo '<br>Now: '.Carbon::now();
            // echo '<br>Now + 10 seconds: '.Carbon::now()->addSeconds(10);

            // echo '<br>Test 1: ';
            // echo $started_at < Carbon::now()->addSeconds(10);

            // // Check date of last message.
            // $last_message = $conversation->messages()->with('sender')->get()->sortByDesc('created_at')->first();

            // echo '<br>Test 2: ';
            // echo $last_message->created_at > $request->get('timestamp');

            // echo '<br>Test 3: ';
            // echo $started_at->addSeconds(3) > Carbon::now();

            // echo '<br>Started at + 10 seconds: '.$started_at->addSeconds(10);

            // if($last_message->created_at > $request->get('timestamp')){
            //     echo '<br>New message at: '.$last_message->created_at;
            // }
            // else{
            //     echo '<br>Old message at: '.$last_message->created_at;
            // }

            /**
             * We can poll messages forever or until theres a new one.
             * But we'll limit it to certain minute.
             */

            while(true){
                // Check date of last message.
                $last_message = $conversation->messages()->with('sender')->get()->sortByDesc('created_at')->first();

                if($last_message->created_at > $request->get('timestamp')){
                    // Detected a new message. Return updated messages.

                    $messages = $conversation->messages()->with('sender')->get()->sortBy('created_at');
                    break;
                }
                else{
                    // Wait for a few seconds then poll the database again. Ugly as it blocks other PHP processes, but should do for now.
                    sleep(1);
                    continue;
                }
            }

            return $messages;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conversation = Conversation::findOrFail($request->get('conversation_id'));

        $message = $conversation->messages()->create([
                    'sender_id' => $request->user()->id,
                    'text' => $request->get('text')
                ]);

        return $message->with('sender')->orderBy('created_at', 'desc')->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
