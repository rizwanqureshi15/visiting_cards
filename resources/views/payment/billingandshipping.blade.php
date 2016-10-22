@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      
        {{ Form::open(array('id' => 'myform','method' => 'post','url' => url('payment'), 'class' => "form-horizontal col-md-10")) }}

            <input type="hidden" name="_token" value="{{ csrf_token() }}" >    
                <div class="col-md-12">
                  <h2>Billing address</h2>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Adress Line-1</label>
                  <div class="col-sm-10">
                     {{ Form::text('address_1', null , $attributes= ['class' => 'form-control','placeholder' => 'Address Line - 1','id' => 'bill_address1']) }}
                     @if ($errors->first('address_1'))
                      <div class="alert alert-danger">
                        {{ $errors->first('address_1') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Adress Line-2</label>
                  <div class="col-sm-10">
                     {{ Form::text('address_2', null , $attributes= ['class' => 'form-control','placeholder' => 'Address Line - 2','id' => 'bill_address2']) }}
                     @if ($errors->first('address_2'))
                      <div class="alert alert-danger">
                        {{ $errors->first('address_2') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-10">
                     {{ Form::text('city', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter City Name','id' => 'bill_city']) }}
                     @if ($errors->first('city'))
                      <div class="alert alert-danger">
                        {{ $errors->first('city') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">State</label>
                  <div class="col-sm-10">
                     {{ Form::text('state', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter State Name','id' => 'bill_state']) }}
                     @if ($errors->first('state'))
                      <div class="alert alert-danger">
                        {{ $errors->first('state') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                     {{ Form::text('country', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter Country Name','id' => 'bill_country']) }}
                     @if ($errors->first('country'))
                      <div class="alert alert-danger">
                        {{ $errors->first('country') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Zip Code</label>
                  <div class="col-sm-10">
                     {{ Form::text('zipcode', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter City Name','id' => 'bill_zipcode']) }}
                     @if ($errors->first('zipcode'))
                      <div class="alert alert-danger">
                        {{ $errors->first('zipcode') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="col-md-12">
                  <h2>Shipping address</h2>
                </div>

                <div class="form-group">
                  <div class="col-sm-10 col-sm-offset-2">
                     {{ Form::checkbox('shipping', 'same' , False, ['id'=>'is_same']) }} Same as Billing Address
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Adress Line-1</label>
                  <div class="col-sm-10">
                     {{ Form::text('ship_address_1', null , $attributes= ['class' => 'form-control','placeholder' => 'Address Line - 1','id' => 'ship_address1']) }}
                     @if ($errors->first('ship_address_1'))
                      <div class="alert alert-danger">
                        {{ $errors->first('ship_address_1') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Adress Line-2</label>
                  <div class="col-sm-10">
                     {{ Form::text('ship_address_2', null , $attributes= ['class' => 'form-control','placeholder' => 'Address Line - 2','id' => 'ship_address2']) }}
                     @if ($errors->first('ship_address_2'))
                      <div class="alert alert-danger">
                        {{ $errors->first('ship_address_2') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-10">
                     {{ Form::text('ship_city', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter City Name','id' => 'ship_city']) }}
                     @if ($errors->first('ship_city'))
                      <div class="alert alert-danger">
                        {{ $errors->first('ship_city') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">State</label>
                  <div class="col-sm-10">
                     {{ Form::text('ship_state', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter State Name','id' => 'ship_state']) }}
                     @if ($errors->first('ship_state'))
                      <div class="alert alert-danger">
                        {{ $errors->first('ship_state') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                     {{ Form::text('ship_country', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter Country Name','id' => 'ship_country']) }}
                     @if ($errors->first('ship_country'))
                      <div class="alert alert-danger">
                        {{ $errors->first('ship_country') }}
                      </div>
                     @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Zip Code</label>
                  <div class="col-sm-10">
                     {{ Form::text('ship_zipcode', null , $attributes= ['class' => 'form-control','placeholder' => 'Enter City Name','id' => 'ship_zipcode']) }}
                     @if ($errors->first('ship_zipcode'))
                      <div class="alert alert-danger">
                        {{ $errors->first('ship_zipcode') }}
                      </div>
                     @endif
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    {{ Form::submit('PayNow',[ "class" => "btn btn-primary" ]) }}
                  </div>
                </div>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('js')
  <script type="text/javascript">
    $(document).ready(function(){
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
