<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * list all users
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function list($id=null)
    {
        return $id?User::find($id):User::all();
    }

    /**
     * create new User
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $user = new User;
        return $user->create($request);
    }

    /**
     * Update User
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if(!$request->has("id")){
            return ["status"=>"error","message"=>"Missing ID field"];
        }
        else{
            $user = User::find($request->id);
            if($user){
                return $user->edit($request);
            }
            return ["status"=>"error","message"=>"ID not exists"];
            
        }
        
    }

    /* list all user requests
    * @param userID
    * @return \Illuminate\Http\Response
    */
   public function requests($id)
   {
       $user = User::find($id);
       if($user){
           return $user->user_all_requests();
       }
       return ["status"=>"error","message"=>"ID not exists"];
   }
}
