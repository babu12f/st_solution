@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Products <a href="{{ url('/purchase/create') }}" class="pull-right">Add Purchase</a></div>

                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Supplier Name</th>
                                <th>Date</th>
                                <th>Costing</th>
                                <th>Quantity</th>
                                <th>Selling Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $purchase)
                              <tr>
                                <td>{{ $purchase->product->name }}</td>
                                <td>{{ $purchase->supplier }}</td>
                                <td>{{ $purchase->created_at->format('d-m-Y ')}}</td>
                                <td>{{ $purchase->costing }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>{{ $purchase->price }}</td>
                                <td>
                                    <a href="{{ url('products/')}}/{{$purchase->product->id}}/show" class="btn btn-default">View Stock</a> | 
                                    <a href="{{ url('purchase/')}}/{{$purchase->id}}/delete" class="btn btn-danger delete">Delete</a>
                                </td>
                              </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7"></td>
                                </tr>
                            @endforelse
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function(){
        
       $('.delete').on('click', function(e){
           
           return confirm('Are You Sure to Delete This product');
           
       });
       
    });
</script>
@endsection