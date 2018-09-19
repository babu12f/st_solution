@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Stocks
                </div>

                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Lot NO</th>
                            <th>Product Name</th>
                            <th>Selling Price</th>
                            <th>Quantity</th>
                            <th>
                                Date
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $stock)
                              <tr>
                                <td>{{ $stock->lot_no }}</td>
                                <td>{{ $stock->product->name }}</td>
                                <td>{{ $stock->price }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>{{ $stock->created_at->format('d-m-Y ')}}</td>
                              </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4"></td>
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