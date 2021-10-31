<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CustomersField;
use App\Invoice;
use App\Product;
use App\InvoicesItem;
class InvoicesController extends Controller
{
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('invoices.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $customer = Customer::create($request->customer);
        $invoice = Invoice::create($request->invoice + ['customer_id' => $customer->id]);
        for ($i=0; $i < count($request->product); $i++) {
            if (isset($request->qty[$i]) && isset($request->price[$i])) {
                InvoicesItem::create([
                    'invoice_id' => $invoice->id,
                    'name' => $request->product[$i],
                    'quantity' => $request->qty[$i],
                    'price' => $request->price[$i]
                ]);
            }
        }
        for ($i=0; $i < count($request->customer_fields); $i++) {
            if (isset($request->customer_fields[$i]['field_key']) && isset($request->customer_fields[$i]['field_value'])) {
                CustomersField::create([
                    'customer_id' => $customer->id,
                    'field_key' => $request->customer_fields[$i]['field_key'],
                    'field_value' => $request->customer_fields[$i]['field_value']
                ]);
            }
        }
        return 'To be continued';
    }
    public function show($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        return view('invoices.show',compact('invoice'));
    }
    public function download($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $pdf     = \PDF::loadView('invoices.pdf', compact('invoice'));

        return $pdf->stream('invoice.pdf');
    }
}
