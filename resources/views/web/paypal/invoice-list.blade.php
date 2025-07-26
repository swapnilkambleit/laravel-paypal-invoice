@extends('layouts.app')

@section('content')
    <div class="p-3 mb-4 bg-light rounded-3">
        <a href="{{url('/invoice-create');}}" class="btn btn-primary float-end"> Create Invoice </a>
        <h1 class="p-0 mb-0">Invoices</h1> 
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr class="sticky-top"> 
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($listInvoices['total_items'] > 0)
                
            @foreach ($listInvoices['items'] as $key => $item)
                
            <tr> 
                <td>&nbsp;&nbsp;&nbsp;{{ $item['detail']['invoice_number'] ?? ''; }}</td>
                <td>{{ $item['detail']['invoice_date'] ?? ''; }}</td>
                <td>{{ $item['primary_recipients'][0]['billing_info']['email_address'] ?? 'demo@gmail.com'; }}</td>
                <td>{{ $item['amount']['currency_code'] . ' ' .$item['amount']['value'] ?? ''; }}</td>
                <td>{{ $item['status'] ?? ''; }}</td>
                <td>
                    <a href="{{url('/invoice-show');}}/{{$item['id']}}" class="d-none btn btn-info">Show</a>
                    <a href="{{url('/invoice-delete');}}/{{$item['id']}}" class="btn btn-danger">Delete</a>
                </td>
            </tr> 

            @endforeach
            @endif
        </tbody>
    </table>


    
        @if ($listInvoices['total_pages'] > 0)

            <div class="container mt-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center"> 
            @for ($i = 1; $i <= $listInvoices['total_pages']; $i++)

                @if ($page_id == $i)
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="{{url('/')}}?page={{$i}}"> {{$i}} </a>
                    </li>
                @else 
                    <li class="page-item">
                        <a class="page-link" href="{{url('/')}}?page={{$i}}"> {{$i}} </a>
                    </li>
                @endif
 
            @endfor
            
                    </ul>
                </nav>
            </div>
        @endif

@endsection
