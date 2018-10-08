<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('home.home');
    }

    public function driver_index(){
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

    public function driver_(){
        return view('home.index');
    }
    public function partner(){
        return view('home.partner');
    }

    public function contact(){
        return view('home.contact');
    }

    public function terms(){
        return view('home.terms');
    }

    public function privacy(){
        return view('home.privacy');
    }
}
