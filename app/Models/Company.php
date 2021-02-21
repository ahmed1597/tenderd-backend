<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Company extends Model
{
    use HasFactory;

    /**
     * one to many relationship between Company and Users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * list all Users under specific Company
     */
    public function company_all_users()
    {
        return $this->users;
    }

    /**
     * one to many relationship between Company and Requests
     */
    public function requests()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * list all Requests under specific Company
     */
    public function company_all_requests()
    {
        return $this->requests;
    }

    /**
     * Update Company name 
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validator = $this->validate_update_request($request);
        if($validator->fails())
        {
            return ["status"=>"error","message"=>$validator->errors()];
        }
        else
        {
            $this->name = $request->name;
            $this->save();
            return ["status"=>"success","message"=>"Company updated successfully"];
        }
    }

    /**
     * validate update company request
     * @param $REQUEST
     * @return $validator
     */
    public function validate_update_request(Request $request)
    {
        $rules = array(
            "id" => "required|integer|exists:companies,id",
            "name" =>"required|string"
        );
        $validator = Validator::make($request->all(),$rules);
        return $validator;
    }


}
