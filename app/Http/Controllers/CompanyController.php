<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * list all companies
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function list($id=null)
    {
        return $id?Company::find($id):Company::all();
    }

    /**
     * Update Company name
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if(!$request->has("id")){
            return ["status"=>"error","message"=>"Missing ID field"];
        }
        else{
            $company = Company::find($request->id);
            if($company){
                return $company->edit($request);
            }
            return ["status"=>"error","message"=>"ID not exists"];
            
        }
        
    }

    /**
     * list all company users
     * @param companyID
     * @return \Illuminate\Http\Response
     */
    public function users($id)
    {
        $company = Company::find($id);
        if($company){
            return $company->company_all_users();
        }
        return ["status"=>"error","message"=>"ID not exists"];
    }

    /* list all company requests
    * @param companyID
    * @return \Illuminate\Http\Response
    */
   public function requests($id)
   {
       $company = Company::find($id);
       if($company){
           return $company->company_all_requests();
       }
       return ["status"=>"error","message"=>"ID not exists"];
   }
}
