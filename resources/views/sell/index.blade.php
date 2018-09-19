@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Sells <a href="{{ url('/sells/create') }}" class="pull-right">Add Sells</a></div>

                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sells as $sell)
                              <tr>
                                <td>{{ $sell->product->name }}</td>
                                <td>{{ $sell->customer }}</td>
                                <td>{{ $sell->created_at->format('d-m-Y ')}}</td>
                                <td>{{ $sell->price }}</td>
                                <td>{{ $sell->quantity }}</td>
                                <td>
                                    <a href="{{ url('sells/')}}/{{$sell->id}}/delete" class="btn btn-danger delete">Delete</a>
                                </td>
                              </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Not Sell Found</td>
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