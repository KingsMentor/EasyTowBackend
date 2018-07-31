<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Company;
use App\Driver;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::where('user_id',auth()->user()->id);
        $trucks = Vehicle::where('user_id',auth()->user()->id);

        if(auth()->user()->type == "0"){
            $drivers = $drivers->count();
            $trucks = $trucks->count();
        }else{
            $company = get_session();
            $drivers = $drivers->where('company_id',$company->id)->count();
            $trucks = $trucks->where('company_id',$company->id)->count();
        }
        return view('index')->with(compact('drivers','trucks'));
    }

    public function registration()
    {
        $banks = Bank::pluck('name','id')->toArray();
        return view('home')->with(compact('banks'));
    }

    public function p_registration(Request $request){
        $request_data = $request->all();
        unset($request_data['_token']);

        //time to sort
        $data = [
            "first_name" => $request_data['first_name'],
            "last_name" => $request_data['last_name'],
              "phone_no" => $request_data['phone_no'],
              "type" =>  $request_data['type']
        ];


        //If a company add the relationship
        if($request_data['type'] == 1 || $request_data['type'] == 2){
            $company_data = [
                'name' => $request_data['company_name'],
                'address' => $request_data['address'],
                'account_name' => $request_data['account_name'],
                'account_no' => $request_data['account_no'],
                'bank_id' => $request_data['bank_id'],
                'user_id' => auth()->user()->id
            ];
        }else{
            $data = $request_data;
            unset($data['company_name']);
        }


        User::where('id',auth()->user()->id)->update($data);
        if($request_data['type'] == 1 || $request_data['type'] == 2) {
            Company::create($company_data);
        }
        return redirect()->to('/home');
    }

    public function truck(){
        if(auth()->user()->type < 1){
            return back();
        }
        $trucks = Vehicle::where('user_id',auth()->user()->id)->where('company_id',get_session()->id)->paginate(25);

        return view('home.truck')->with(compact('trucks'));
    }

    public function add_truck(){
        return view('home.add_truck')->with(compact('trucks'));
    }

    public function p_add_truck(Request $request){
        if(auth()->user()->type < 1){
            if(auth()->user()->trucks->count() > 0){
                session()->flash('alert-info',"You cannot add more than one truck");
                return back();
            }
        }
        $this->validate($request,[
            'manufacturer' => 'required',
            'model' => 'required',
            'year' => 'required',
            'plate_no' => 'required',
            'chasis_no' => 'required',
            'engine_no' => 'required'
        ]);

        $data = $request->all();
        unset($data["_token"]);
        $data['user_id'] = auth()->user()->id;
        if(auth()->user()->type != "0") {
            $data['company_id'] = get_session()->id;
        }

        $vehicle = Vehicle::create($data);

        session()->flash('alert-info',"Truck has been successfully added");

        return redirect()->to('/truck/'.encrypt_decrypt('encrypt',$vehicle->id));

    }

    public function view_truck($id){
        $id = encrypt_decrypt('decrypt',$id);
        $truck = Vehicle::where('id',$id)->first();
        if(auth()->user()->type == "0") {
            $drivers = Driver::where('user_id',auth()->user()->id)->pluck('name','id')->toArray();
        }else{
            $drivers = Driver::where('user_id',auth()->user()->id)->where('company_id',get_session()->id)->pluck('name','id')->toArray();
        }
        return view('home.v_truck')->with(compact('truck','drivers'));
    }

    public function logout(){
        auth()->logout();
        session()->flush();

        return redirect()->to('/');
    }

    public function driver(){
        if(auth()->user()->type < 1){
            return back();
        }
        $drivers = Driver::where('user_id',auth()->user()->id)->where('company_id',get_session()->id)->paginate(25);
        return view('home.driver')->with(compact('drivers'));
    }

    public function add_driver(){
        if(auth()->user()->type == "0") {
            $trucks = Vehicle::where('user_id',auth()->user()->id)->pluck('manufacturer','id')->toArray();
        }else{
            $trucks = Vehicle::where('user_id',auth()->user()->id)->where('company_id',get_session()->id)->pluck('manufacturer','id')->toArray();
        }
        return view('home.add_driver')->with(compact('trucks'));
    }

    public function p_add_driver(Request $request){
        if(auth()->user()->type != "1"){
            if(auth()->user()->drivers->count() > 0){
                session()->flash('alert-info',"You cannot add more than one driver");
                return back();
            }
        }
        $this->validate($request, [
            'name' => 'required',
            'profile_pic' => 'required|image|mimes:jpg,png,jpeg',
            'email' => 'required|unique:drivers',
            'password' => 'required',
            'license' => 'required|mimes:pdf,docx,doc',
            'phone_no' => 'required'
        ]);

        $photoName = time() . '.' . $request->profile_pic->getClientOriginalExtension();
        $request->profile_pic->move(public_path('storage'), $photoName);
        $photoName2 = time() . '.' . $request->license->getClientOriginalExtension();
        $request->license->move(public_path('storage'), $photoName2);

        $request_data = $request->all();

        $request_data['profile_pic'] = '/storage/'.$photoName;
        $request_data['license'] = '/storage/'.$photoName2;
        $request_data['user_id'] = auth()->user()->id;
        $truck_id = $request_data['truck_id'];
        unset($request_data['_token']);
        unset($request_data['truck_id']);
        if(auth()->user()->type != "0") {
            $request_data['company_id'] = get_session()->id;
        }
        $request_data['password'] = Hash::make($request_data['password']);
        $driver = Driver::create($request_data);

        Vehicle::where('id',$truck_id)->update([
            'driver_id' => $driver->id
        ]);

        session()->flash('alert-success',"Driver has been successfully added");

        if(auth()->user()->type == "0"){
            return redirect()->to('/driver/'.encrypt_decrypt('encrypt',$driver->id));
        }else {
            return redirect()->to('/driver');
        }

    }

    public function view_driver($id){
        $id = encrypt_decrypt('decrypt',$id);
        $driver = Driver::where('id',$id)->first();
        return view('home.view_driver')->with(compact('driver'));
    }

    public function pt_add_driver(Request $request){

        Vehicle::where('id',$request->id)->update([
            'driver_id' => $request->driver_id
        ]);

        return back();
    }

    public function account_settings(){
        return view('home.account_settings');
    }

    public function update_account(Request $request){
        $request_data = $request->all();
        unset($request_data['_token']);
        User::where('id',auth()->user()->id)->update($request_data);
        session()->flash('alert-success',"Profile has been updated");
        return back();
    }

    public function companies(){
        $companies = Company::where('user_id',auth()->user()->id)->paginate(25);
        return view('home.company')->with(compact('companies'));
    }

    public function add_company(){
        $banks = Bank::pluck('name','id')->toArray();

        return view('home.add_company')->with(compact('banks'));
    }

    public function p_add_company(Request $request){
       $request_data = $request->all();
       $request_data['user_id'] = auth()->user()->id;
       Company::create($request_data);
       session()->flash('alert-success',"Company has been added.");
       return redirect()->to('/companies');
    }

    public function company_delete($id){
        $id = encrypt_decrypt('decrypt',$id);
        $company = Company::where('id',$id)->delete();
        session()->flash('alert-success',"Company has been deleted");
        return back();
    }
}
