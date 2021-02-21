<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class StatusHistory extends Model
{
    use HasFactory;

    /**
     * create new history
     * @param data array
     */
    public function create($data)
    {
        $validator = $this->validate_create_request($data);
        if($validator->fails())
        {
            return ["status"=>"error","message"=>$validator->errors()];
        }
        else
        {
            if(!$this->validate_request_status($data["from_status"])){
                return ["status"=>"error","message"=>"invalid request from status value"];
            }
            if(!$this->validate_request_status($data["to_status"])){
                return ["status"=>"error","message"=>"invalid request to status value"];
            }
            $this->description = $data["description"];
            $this->from_status = $data["from_status"];
            $this->to_status = $data["to_status"];
            $this->ticket_id = $data["ticket_id"];
            $this->save();
            return true;
        }
    }

    /**
     * validate new history request
     * @param data array
     * @return $validator
     */
    public function validate_create_request($data)
    {
        $rules = array(
            "ticket_id" =>"required|integer|exists:tickets,id",
            "from_status" =>"required|string",
            "to_status" => "required|string",
            "description" => "required|string"
        );
        $validator = Validator::make($data,$rules);
        return $validator;
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
}
