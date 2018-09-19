@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}" type="text/css" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Purchase</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('purchase.create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('supplier') ? ' has-error' : '' }}">
                            <label for="supplier" class="col-md-4 control-label">Supplier Name</label>

                            <div class="col-md-6">
                                <input id="supplier" type="text" class="form-control" name="supplier" value="{{ old('supplier') }}" autofocus>

                                @if ($errors->has('supplier'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('supplier') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('costing') ? ' has-error' : '' }}">
                            <label for="costing" class="col-md-4 control-label">Costing</label>

                            <div class="col-md-6">
                                <input id="costing" type="text" class="form-control" name="costing" value="{{ old('costing') }}" />

                                @if ($errors->has('costing'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('costing') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            <label for="quantity" class="col-md-4 control-label">Quantity</label>

                            <div class="col-md-6">
                                <input id="quantity" type="text" class="form-control" name="quantity" value="{{old('quantity')}}" />

                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Selling Price</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control" name="price" value="{{old('price')}}" />

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="product_id" class="col-md-4 control-label">Product ID</label>

                            <div class="col-md-2">
                                <input id="product_id" type="text" class="form-control" name="product_id" value="{{old('product_id')}}" />

                                @if ($errors->has('product_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-4">
                                <input id="product_name" type="text" class="form-control" 
                                name="product_name" value="{{old('product_name')}}"
                                placeholder="Type Product Name to Find Product ID " />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add Purchase
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
<script>
    
    $(function(){
        
        $('#product_name').on('focus', function(){
            $(this).select();
        });
        
        /*
        * Autocomplete suggestion for product
        */
        var find_product_url = "{{url('/products/searchstockandprice')}}";
        $("#product_name").autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{url('/products/search')}}",
                    dataType: "json",
                    data: {
                        productName: request.term
                    },
                    success: function (data) {
                        //console.log(data);
                        response(data);
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                //console.log("Selected: " + ui.item.Name + " aka " + ui.item.Id);
                //console.log(ui);
                var p_id = ui.item.id;
                $('#product_id').val(p_id);
            }
        });

        //=================== End autocomplete Products ===============================


        
    });
    
</script>>
@endsection