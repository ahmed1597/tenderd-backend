<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
class Document extends Model
{
    use HasFactory;

    /**
     * create new Document
     * @param $REQUEST
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
            $this->ticket_id = $request->ticket_id;
            $this->file_url = $request->file_url;
            $this->save();
            return ["status"=>"success","message"=>"Document created successfully"];
        }
    }

    /**
     * validate new document request
     * @param $REQUEST
     * @return $validator
     */
    public function validate_create_request(Request $request)
    {
        $rules = array(
            "file_url" =>"required|string",
            "ticket_id" => "required|integer|exists:tickets,id"
        );
        $validator = Validator::make($request->all(),$rules);
        return $validator;
    }
}
