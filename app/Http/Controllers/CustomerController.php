<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Country;
use App\CustomersField;
class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
    public function create()
    {
        $countries = Country::all();
        return view('customers.create',compact('countries'));
    }
    public function store(Request $request)
    {
        $customer = Customer::create($request->all());
        for ($i=0; $i < count($request->customer_fields); $i++) {
            if (isset($request->customer_fields[$i]['field_key']) && isset($request->customer_fields[$i]['field_value'])) {
                CustomersField::create([
                    'customer_id' => $customer->id,
                    'field_key' => $request->customer_fields[$i]['field_key'],
                    'field_value' => $request->customer_fields[$i]['field_value']
                ]);
            }
        }
        return redirect()->route('customers.index');
    }

}
