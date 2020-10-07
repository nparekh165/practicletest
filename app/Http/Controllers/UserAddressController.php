<?php

namespace App\Http\Controllers;

use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:useraddress-list|useraddress-create|useraddress-edit|useraddress-delete', ['only' => ['index','show']]);
        $this->middleware('permission:useraddress-create', ['only' => ['create','store']]);
        $this->middleware('permission:useraddress-adminlisting', ['only' => ['index','adminlisting']]);
        $this->middleware('permission:useraddress-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:useraddress-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
        $id = auth()->user()->id; 
        $useraddresss = UserAddress::where('user_id', '=', $id)
        ->latest()
        ->paginate(5);

        return view('useraddress.index',compact('useraddresss'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminlisting()
    {   
        $useraddresss = UserAddress::latest()->paginate(5);
        return view('useraddress.adminlisting',compact('useraddresss'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = auth()->user()->id;
        return view('useraddress.create', ['user_id' => $id]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'address' => 'required',
        ]);

        $id = auth()->user()->id;

        if(!empty($request->isprimary))
        {
            DB::table('useraddress')
            ->where("user_id", '=', $id)
            ->update(['isprimary'=> '0']);
        }

        UserAddress::create($request->all());


        return redirect()->route('useraddress.index')
                        ->with('success','UserAddress created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $useraddress)
    {
        return view('useraddress.show',compact('useraddress'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $useraddress)
    {
        $id = auth()->user()->id;
        return view('useraddress.edit',compact('useraddress'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $useraddress)
    {
        request()->validate([
            'address' => 'required',
        ]);

        $id = auth()->user()->id;

        if(!empty($request->isprimary))
        {
            DB::table('useraddress')
            ->where("user_id", '=', $id)
            ->update(['isprimary'=> '0']);
        }

        
        $useraddress->update($request->all());


        return redirect()->route('useraddress.index')
                        ->with('success','UserAddress updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $useraddress)
    {
        $useraddress->delete();


        return redirect()->route('useraddress.index')
                        ->with('success','UserAddress deleted successfully');
    }
}
