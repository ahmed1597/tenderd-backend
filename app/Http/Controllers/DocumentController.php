<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * create new Document
     * @param $REQUEST
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $document = new Document;
        return $document->create($request);
    }
}
