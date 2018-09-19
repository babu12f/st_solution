@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Products</div>

                <div class="panel-body">
                    <div>
                        <b>Name: </b><p>{{$product->name}}</p>
                        <b>Model: </b><p>{{$product->model}}</p>
                        <b>Description: </b><p>{{$product->description}}</p>
                    </div>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Lot NO</th>
                            <th>Price</th>
                            <th>Quantity</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse($product->stocks as $stock)
                              <tr>
                                <td>{{ $stock->lot_no }}</td>
                                <td>{{ $stock->price }}</td>
                                <td>{{ $stock->quantity }}</td>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Stock Found</td>
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
