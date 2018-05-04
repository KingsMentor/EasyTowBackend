<?php

namespace App\Http\Controllers;

use App\Driver;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;

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
        $drivers = Driver::where('agent_id',auth()->user()->id)->count();
        $trucks = Vehicle::where('agent_id',auth()->user()->id)->count();
        return view('index')->with(compact('drivers','trucks'));
    }

    public function registration()
    {
        return view('home');
    }

    public function p_registration(Request $request){
        $request_data = $request->all();
        unset($request_data['_token']);
        User::where('id',auth()->user()->id)->update($request_data);

        return redirect()->to('/home');
    }

    public function truck(){
        if(auth()->user()->type != "1"){
            return back();
        }
        $trucks = Vehicle::where('agent_id',auth()->user()->id)->paginate(25);

        return view('home.truck')->with(compact('trucks'));
    }

    public function add_truck(){
        return view('home.add_truck')->with(compact('trucks'));
    }

    public function p_add_truck(Request $request){
        if(auth()->user()->type != "1"){
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
        ]);

        $data = $request->all();
        unset($data["_token"]);
        $data['agent_id'] = auth()->user()->id;

        $vehicle = Vehicle::create($data);

        session()->flash('alert-info',"Truck has been successfully added");

        return redirect()->to('/truck/'.encrypt_decrypt('encrypt',$vehicle->id));

    }

    public function view_truck($id){
        $id = encrypt_decrypt('decrypt',$id);
        $truck = Vehicle::where('id',$id)->first();
        $drivers = Driver::where('agent_id',auth()->user()->id)->pluck('name','id')->toArray();
        return view('home.v_truck')->with(compact('truck','drivers'));
    }

    public function logout(){
        auth()->logout();
        session()->flush();

        return redirect()->to('/');
    }

    public function driver(){
        if(auth()->user()->type != "1"){
            return back();
        }
        $drivers = Driver::where('agent_id',auth()->user()->id)->paginate(25);
        return view('home.driver')->with(compact('drivers'));
    }

    public function add_driver(){
        $trucks = Vehicle::where('agent_id',auth()->user()->id)->pluck('manufacturer','id')->toArray();
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
            'license' => 'required|mimes:pdf,docx,doc'
        ]);

        $photoName = time() . '.' . $request->profile_pic->getClientOriginalExtension();
        $request->profile_pic->move(public_path('storage'), $photoName);
        $photoName2 = time() . '.' . $request->license->getClientOriginalExtension();
        $request->license->move(public_path('storage'), $photoName2);

        $request_data = $request->all();

        $request_data['profile_pic'] = '/storage/'.$photoName;
        $request_data['license'] = '/storage/'.$photoName2;
        $request_data['agent_id'] = auth()->user()->id;
        $truck_id = $request_data['truck_id'];
        unset($request_data['_token']);
        unset($request_data['truck_id']);
        $driver = Driver::create($request_data);

        Vehicle::where('id',$truck_id)->update([
            'driver_id' => $driver->id
        ]);

        session()->flash('alert-success',"Driver has been successfully added");


        return redirect()->to('/driver');


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
}
