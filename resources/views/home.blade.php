@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="btn btn-primary" href="{{route('invoices.create')}}">Add new Invioce</a>
    <br>
    <br>
    <table id="student" border=1>
        <tr>
          <th>Invoice_date</th>
          <th>Invoice_number</th>
          <th>Customer</th>
          <th>Total Amount</th>
          <th></th>
        </tr>
    
        @foreach($invoice as $invoice)
        <tr>
          <th>{{$invoice->invoice_date}}</th>
          <th>{{$invoice->invoice_number}}</th>
          <th>{{$invoice->customer->name}}</th>
          <th>{{$invoice->total_amount}}</th>
          <th><a class="btn btn-sm btn-info" href="{{route('invoices.show',$invoice->id )}}">View Invoice</a></th>
          <th><a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-sm btn-warning">Download PDF</a></th>
        </tr>
        @endforeach
       
      </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
