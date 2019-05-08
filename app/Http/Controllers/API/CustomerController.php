<?php

namespace App\Http\Controllers\API;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'br_no'=>'required',
            'website'=>'required',
            'address'=>'required',
            'contact_no'=>'required'
        ]);


        return Customer::create([
            'customer_name' => $request['customer_name'],
            'email' => $request['email'],
            'br_no' => $request['br_no'],
            'website' => $request['website'],
            'address' => $request['address'],
            'contact_no' => $request['contact_no'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Customer::findOrFail($id);
        $this->validate($request, [
            'customer_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'br_no'=>'required',
            'website'=>'required',
            'address'=>'required',
            'contact_no'=>'required'
        ]);

        $user->update($request->all());

        return ['message' => 'Customer Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Customer::findOrFail($id);
        $user->delete();
        return ['message' => 'Customer Deleted'];
    }
}
