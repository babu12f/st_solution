@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Products <a href="{{ url('/products/create') }}" class="pull-right">Add Pdocut</a></div>

                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Model</th>
                            <th>Description</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                              <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->model }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <a href="{{ url('products/')}}/{{$product->id}}/show" class="btn btn-default">View Stock</a> | 
                                    <a href="{{ url('products/')}}/{{$product->id}}/edit" class="btn btn-info">Edit</a> | 
                                    <a href="{{ url('products/')}}/{{$product->id}}/delete" class="btn btn-danger delete">Delete</a>
                                </td>
                              </tr>
                            @endforeach
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