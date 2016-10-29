@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-12 innerWrapper">
        <div class="col-md-12">
              <h4 class="title text-transform">Material
                <span class="title-rupee">Payment to pay : <i class="fa fa-inr"></i> <span id="final_price"> {{ $template_price * $order->quantity * $material_price }}</span></span>
              </h4>

        </div>

        {{ Form::open(array('id' => 'myform','method' => 'post','url' => url('payment'), 'class' => "form-horizontal")) }}
               <div class="col-xs-12">  
                  <div class="form-group col-sm-6 col-xs-12">
                  <input type="hidden" name="final_price" id="price" value="{{ $template_price * $order->quantity * $material_price }}" > 
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" > 
                  <input type="hidden" name="order_id" value="{{ $order_id }}" >
                    <label for="inputEmail3" class="control-label form-lable-payment ">Material</label>
                    <select id="material_id" class="form-control textbox-controll" name="material_id">
                        @foreach($materials as $material)
                          @if($order->material_id == $material->id)
                            <option value="{{ $material->id }}" class="textbox-controll" selected="selected">{{ $material->name }}</option>
                          @else
                            <option value="{{ $material->id }}" class="textbox-controll">{{ $material->name }}</option>
                          @endif  
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-xs-12">
                      <label for="inputEmail3" class="form-lable-payment control-label">Phone No.<span class="error-lable">(Required for payUmoney)</span></label>
                      
                         {{ Form::text('phone_no', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter Phone No.','id' => 'bill_phone_no']) }}
                         @if ($errors->first('phone_no'))
                          <div class="alert alert-danger">
                            {{ $errors->first('phone_no') }}
                          </div>
                         @endif

                  </div>
          </div>

        <div class="col-md-12">
              <h4 class="title text-transform">Billing address</h4>
        </div>   
                <div class="col-xs-12">
                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment ">Adress Line-1</label>

                       {{ Form::text('address_1', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Address Line - 1','id' => 'bill_address1']) }}
                       @if ($errors->first('address_1'))
                        <div class="alert alert-danger">
                          {{ $errors->first('address_1') }}
                        </div>
                       @endif

                  </div>
               
                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">Adress Line-2</label>
                   
                       {{ Form::text('address_2', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Address Line - 2','id' => 'bill_address2']) }}
                       @if ($errors->first('address_2'))
                        <div class="alert alert-danger">
                          {{ $errors->first('address_2') }}
                        </div>
                       @endif

                  </div>
                </div>

                <div class="col-xs-12">
                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">City</label>
                    
                       {{ Form::text('city', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter City Name','id' => 'bill_city']) }}
                       @if ($errors->first('city'))
                        <div class="alert alert-danger">
                          {{ $errors->first('city') }}
                        </div>
                       @endif

                  </div>

                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">State</label>
                    
                       {{ Form::text('state', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter State Name','id' => 'bill_state']) }}
                       @if ($errors->first('state'))
                        <div class="alert alert-danger">
                          {{ $errors->first('state') }}
                        </div>
                       @endif

                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="form-lable-payment control-label">Country</label>
                    
                       {{ Form::text('country', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter Country Name','id' => 'bill_country']) }}
                       @if ($errors->first('country'))
                        <div class="alert alert-danger">
                          {{ $errors->first('country') }}
                        </div>
                       @endif

                  </div>

                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="form-lable-payment control-label">Zip Code</label>
                    
                       {{ Form::text('zipcode', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter City Name','id' => 'bill_zipcode']) }}
                       @if ($errors->first('zipcode'))
                        <div class="alert alert-danger">
                          {{ $errors->first('zipcode') }}
                        </div>
                       @endif

                  </div>
                </div>

                <div class="col-md-12">
                  <h4 class="title text-transform">Shipping address</h4>
                </div>

                <div class="col-md-12" style="margin-top:20px;">
                  <div class="form-group col-sm-6 col-xs-12">
                    <div class="form-lable-payment">
                       {{ Form::checkbox('shipping', 'same' , False, ['id'=>'is_same']) }} Same as Billing Address
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">Adress Line-1</label>
                    
                       {{ Form::text('ship_address_1', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Address Line - 1','id' => 'ship_address1']) }}
                       @if ($errors->first('ship_address_1'))
                        <div class="alert alert-danger">
                          {{ $errors->first('ship_address_1') }}
                        </div>
                       @endif

                  </div>
                

                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">Adress Line-2</label>
                    
                       {{ Form::text('ship_address_2', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Address Line - 2','id' => 'ship_address2']) }}
                       @if ($errors->first('ship_address_2'))
                        <div class="alert alert-danger">
                          {{ $errors->first('ship_address_2') }}
                        </div>
                       @endif

                  </div>
                </div>


                <div class="col-md-12">

                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">City</label>
                    
                       {{ Form::text('ship_city', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter City Name','id' => 'ship_city']) }}
                       @if ($errors->first('ship_city'))
                        <div class="alert alert-danger">
                          {{ $errors->first('ship_city') }}
                        </div>
                       @endif

                  </div>

                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">State</label>
                    
                       {{ Form::text('ship_state', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter State Name','id' => 'ship_state']) }}
                       @if ($errors->first('ship_state'))
                        <div class="alert alert-danger">
                          {{ $errors->first('ship_state') }}
                        </div>
                       @endif

                  </div>

                </div>

                <div class="col-md-12">
                  <div class="form-group  col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">Country</label>
                    
                       {{ Form::text('ship_country', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter Country Name','id' => 'ship_country']) }}
                       @if ($errors->first('ship_country'))
                        <div class="alert alert-danger">
                          {{ $errors->first('ship_country') }}
                        </div>
                       @endif

                  </div>

                  <div class="form-group col-sm-6 col-xs-12">
                    <label for="inputEmail3" class="control-label form-lable-payment">Zip Code</label>
                    
                       {{ Form::text('ship_zipcode', null , $attributes= ['class' => 'form-control textbox-controll','placeholder' => 'Enter City Name','id' => 'ship_zipcode']) }}
                       @if ($errors->first('ship_zipcode'))
                        <div class="alert alert-danger">
                          {{ $errors->first('ship_zipcode') }}
                        </div>
                       @endif

                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-11">
                    {{ Form::submit('PayNow',[ "class" => "btn-blog" ]) }}
                  </div>
                </div>
        {{ Form::close() }}
      </div>
    </div>
</div>
@endsection

@section('js')
  <script type="text/javascript">

    $(document).ready(function(){
     
      var site_url = "{{ url('') }}";
      var materials = {!! $material_id_and_price !!};
      var price;


      $('#material_id').click(function()
      {
          var material_id = $("#material_id").val();
          var template_price = "{{ $template_price }}";
          var order_quantity = "{{ $order_quantity }}";

          $.each(materials,function(key,value)
          {
              if(key == material_id)
              {
                  price = value;
              }
          });

          var final_price = price * template_price * order_quantity;

          $("#final_price").html(final_price);
          $("#price").val(final_price);
      });

      
 
      $('#is_same').click(function(){
        if($(this). prop("checked") == true)
        {
          $('#ship_address1').val($('#bill_address1').val());
          $('#ship_address2').val($('#bill_address2').val());
          $('#ship_city').val($('#bill_city').val());
          $('#ship_state').val($('#bill_state').val());
          $('#ship_country').val($('#bill_country').val());
          $('#ship_zipcode').val($('#bill_zipcode').val());
        }
        else
        {
          $('#ship_address1').val("");
          $('#ship_address2').val("");
          $('#ship_city').val("");
          $('#ship_state').val("");
          $('#ship_country').val("");
          $('#ship_zipcode').val("");
        }
      });
    });
  </script>
@endsection
