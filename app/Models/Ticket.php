<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
use App\Models\StatusHistory;

class Ticket extends Model
{
    use HasFactory;


    /**
     * Inverse one to many relationship between Company and Tickets
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Inverse one to many relationship between User and Tickets
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * one to many relationship between Ticket and Status History 
     */
    public function status_histories()
    {
        return $this->hasMany(StatusHistory::class);
    }

    /**
     * get request status history 
     */
    public function history()
    {
        return $this->status_histories;
    }

    /**
     * one to many relationship between Request and Documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * get all request documents
     */
    public function request_all_documents()
    {
        return $this->documents;
    }

    /**
     * create new Ticket
     * @param \Illuminate\Http\REQUEST
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = $this->validate_create_request($request);
        if($validator->fails())
        {
            return ["status"=>"error","message"=>$validator->errors()];
        }
        else
        {
            if(!$this->validate_request_type($request->type)){
                return ["status"=>"error","message"=>"invalid request type value"];
            }
            $this->type = $request->type;
            $this->description = $request->description;
            $this->status = "created";
            $this->company_id = $request->company_id;
            $this->user_id = $request->user_id;
            $this->created_by_uid = $request->created_by_uid;
            $this->save();
            return ["status"=>"success","message"=>"Request created successfully","id" =>$this->id];
        }
    }

    /**
     * edit Ticket
     * @param \Illuminate\Http\REQUEST
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validator = $this->validate_create_request($request);
        if($validator->fails())
        {
            return ["status"=>"error","message"=>$validator->errors()];
        }
        else
        {
            if(!$this->validate_request_type($request->type)){
                return ["status"=>"error","message"=>"invalid request type value"];
            }
            if(!$this->validate_request_status($request->status)){
                return ["status"=>"error","message"=>"invalid request status value"];
            }
            $this->type = $request->type;
            if($this->status !== $request->status){
                $new_history = new StatusHistory;
                $add=$new_history->create(array("from_status" => $this->status,"to_status" => $request->status,"ticket_id" => $this->id,"description" => $this->description));
                if($add){
                    $this->status = $request->status;
                }
                else{
                    return $add;
                }
                
            }
            $this->description = $request->description;
            $this->company_id = $request->company_id;
            $this->user_id = $request->user_id;
            $this->created_by_uid = $request->created_by_uid;
            $this->save();
            return ["status"=>"success","message"=>"Request updated successfully"];
        }
    }

    /**
     * validate new Request request
     * @param \Illuminate\Http\REQUEST
     * @return $validator
     */
    public function validate_create_request(Request $request)
    {
        $rules = array(
            "type" =>"required|string",
            "description" =>"required|string",
            "company_id" => "required|integer|exists:companies,id",
            "user_id" => "required|string|exists:users,id",
            "created_by_uid" =>"required|string|exists:users,id"
        );
        $validator = Validator::make($request->all(),$rules);
        return $validator;
    }

    /**
     * validate request type value
     * @param request type
     * @return bool valid
     */
    public function validate_request_type($type)
    {
        $values = array("breakdown","replacement","maintenance","demobilisation");
        
        if (in_array(strtolower($type), $values))
        {
            return true;
        }
        return false;
    }

    /**
     * validate request Status value
     * @param request status
     * @return bool valid
     */
    public function validate_request_status($status)
    {
        $values = array("created","in progress","completed","cancelled");
        
        if (in_array(strtolower($status), $values))
        {
            return true;
        }
        return false;
    }

    /**
     * validate update Request request
     * @param $REQUEST
     * @return $validator
     */
    public function validate_update_request(Request $request)
    {
        $rules = array(
            "id" => "required|integer|exists:tickets,id",
            "type" =>"required|string",
            "description" =>"required|string",
            "status" => "required|string",
            "company_id" => "required|integer|exists:companies,id",
            "user_id" => "required|string|exists:users,id",
            "created_by_uid" =>"required|string|exists:users,id"
        );
        $validator = Validator::make($request->all(),$rules);
        return $validator;
    }
    
}
