<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Company;

class User extends Model
{
    use HasFactory;

    /**
     * Indicates if the user's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Inverse one to many relationship between Company and Users
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * one to many relationship between User and Requests
     */
    public function requests()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * list all Requests assigned to specific User
     */
    public function user_all_requests()
    {
        return $this->requests;
    }

    /**
     * create new User
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
            $this->id = $request->id;
            $this->name = $request->name;
            $this->email = $request->email;
            $this->password = Hash::make($request->password);
            $this->company_id = $request->company_id;
            $this->api_token = $this->email.$this->password;
            $this->save();
            return ["status"=>"success","message"=>"User created successfully"];
        }
    }

    /**
     * Update User name and company
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
            if($request->has('name')){
                $this->name = $request->name;
            }
            if($request->has('company_id')){
                $this->company_id = $request->company_id;
            }
            $this->save();
            return ["status"=>"success","message"=>"User updated successfully"];
        }
    }


    /**
     * validate new user request
     * @param $REQUEST
     * @return $validator
     */
    public function validate_create_request(Request $request)
    {
        $rules = array(
            "id" => "required|string|unique:users",
            "name" =>"required|string",
            "email" =>"required|unique:users",
            "password" => "required|string",
            "company_id" => "required|integer|exists:companies,id"
        );
        $validator = Validator::make($request->all(),$rules);
        return $validator;
    }

    /**
     * validate update user name and company request
     * @param $REQUEST
     * @return $validator
     */
    public function validate_update_request(Request $request)
    {
        $rules = array(
            "id" => "required|string|exists:users,id",
            "name" =>"string",
            "company_id" =>"integer|nullable|exists:companies,id"
        );
        $validator = Validator::make($request->all(),$rules);
        return $validator;
    }


}
