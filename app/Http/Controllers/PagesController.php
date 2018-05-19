<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('home.index');
    }

    public function api_doc(){
        $swagger = \Swagger\scan(app_path() . "/Http/Controllers/");
        header('Content-Type: application/json');
        echo json_encode($swagger);
        exit;
    }

    public function select_session($session_id){
        $id = encrypt_decrypt('decrypt',$session_id);

        $session = Company::where('id',$id)->first();

        session(['company' => json_encode($session)]);

        return back();
    }
}
