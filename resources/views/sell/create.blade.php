@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}" type="text/css" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Sell</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('sell.create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('customer') ? ' has-error' : '' }}">
                            <label for="customer" class="col-md-4 control-label">customer Name</label>

                            <div class="col-md-6">
                                <input id="customer" type="text" class="form-control" name="customer" value="{{ old('customer') }}" autofocus>

                                @if ($errors->has('customer'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('customer') }}</strong>
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
                            <label for="price" class="col-md-4 control-label">Price</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control" name="price" 
                                value="{{old('price')}}" readonly/>

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('stock') ? ' has-error' : '' }}">
                            <label for="stock" class="col-md-4 control-label">Stock</label>

                            <div class="col-md-6">
                                <input id="stock" type="text" class="form-control" name="stock" 
                                value="{{old('stock')}}" readonly/>

                                @if ($errors->has('stock'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stock') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('total') ? ' has-error' : '' }}">
                            <label for="total" class="col-md-4 control-label">Total</label>

                            <div class="col-md-6">
                                <input id="total" type="text" class="form-control" name="total" value="{{old('total')}}" readonly/>

                                @if ($errors->has('total'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('total') }}</strong>
                                    </span>
                                @endif
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
        
        $('#quantity').on('keyup', function(){
            $('#total').val( $('#quantity').val() * $('#price').val() )
        });
        
        $('#price').on('change', function(){
            $('#total').val( $('#quantity').val() * $('#price').val() )
        });
        
        $('#quantity').on('focus', function(){
            $(this).select();
        });
        
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
                console.log(ui);
                var p_id = ui.item.id;
                $('#product_id').val(p_id);
                
                 $.ajax({
                    url: find_product_url,
                    dataType: "json",
                    type:"GET",
                    data: {
                        id: p_id
                    },
                    success: function (data) {
                        var product = data[0];
                        var pr = Math.round(product.average);
                        $('#price').val(pr);
                        $('#stock').val(product.quantity)
                        $('#price').change();
                    },
                    error: function(data){
                        console.log("error in after select");
                    }
                });
            }
        });

        //=================== End autocomplete Products ===============================

        
    });
    
</script>>
@endsection