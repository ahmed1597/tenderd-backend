<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
class TicketController extends Controller
{
    /**
     * list all requests
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function list($id=null)
    {
        return $id?Ticket::find($id):Ticket::all();
    }

    /**
     * create new Request
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $ticket = new Ticket;
        return $ticket->create($request);
    }

    /**
     * Update Request
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if(!$request->has("id")){
            return ["status"=>"error","message"=>"Missing ID field"];
        }
        else{
            $ticket = Ticket::find($request->id);
            if($ticket){
                return $ticket->edit($request);
            }
            return ["status"=>"error","message"=>"ID not exists"];
            
        }
        
    }

    /* list all request history
    * @param TicketID
    * @return \Illuminate\Http\Response
    */
   public function history($id)
   {
       $ticket = Ticket::find($id);
       if($ticket){
           return $ticket->history();
       }
       return ["status"=>"error","message"=>"ID not exists"];
   }

    /* list all request documents
    * @param ticketID
    * @return \Illuminate\Http\Response
    */
    public function documents($id)
    {
        $ticket = Ticket::find($id);
        if($ticket){
            return $ticket->request_all_documents();
        }
        return ["status"=>"error","message"=>"ID not exists"];
    }
}
