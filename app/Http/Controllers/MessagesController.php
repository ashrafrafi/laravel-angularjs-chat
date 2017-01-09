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

        $messages = $conversation->messages()->with('sender')->get()->sortBy('created_at')->values()->all();

        /**
         * Determine if client requests to poll or long-poll messages based on timestamp.
         * If the request has a timestamp, do a long-poll, else do regular polling.
         */
        if(!$request->has('timestamp')){
            
            /**
             * Regular polling.
             * 
             * Simply return the messages immidiately.
             */

            return response()->json($messages);

        } else {
            
            /**
             * Long polling. More complicated. We do the following:
             * 
             * To determine if there are any new messages on the conversation,
             * keep matching the request timestamp to the timestamp of the last message from the conversation until it is older.
             * Then send back the updated messages.
             *
             * Poll messages until there is a new one.
             * For stability, let's limit polling up to a certain minute.
             */

            // Poll interval in seconds
            $poll_interval = 1;

            // Poll count
            $poll_count = 30;

            $i = 0;

            while($i <= $poll_count) {
                
                // Check the date of the last message.
                $last_message = $conversation->messages()->with('sender')->get()->sortByDesc('created_at')->first();

                // Check for any new messages
                if($last_message->created_at > $request->get('timestamp')){

                    // get updated messages
                    $messages = $conversation->messages()->with('sender')->get()->sortBy('created_at')->values()->all();
                    
                    // exit the loop
                    break;

                } else {
                    // Wait for a few seconds then poll for new messages again. Ugly yes, as it blocks other PHP processes, but should do for now.
                    sleep($poll_interval);
                }

                $i++;
            }

            return response()->json($messages);
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
