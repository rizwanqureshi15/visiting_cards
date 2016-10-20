@extends('layouts/app')

@section('content')
<section class="darkSection">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
			<div style="margin-top:30px;">	 
				 @if(Session::has('flash_message'))
	                    <div class="alert alert-success">
	                         <span class="glyphicon glyphicon-ok"></span>
	                            <em> {!! session('flash_message') !!}</em>
	                    </div>
	             @endif
	        </div>

				<h3>Contact Us</h3>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="thumbnail">
						<h5>Address</h5>
						<address>
							Tariq Complex,<br>
							Ashapura ring road,<br>
							Bhuj-Kutch.
						</address>
					</div>
				</div>

				<div class="col-md-9 col-sm-6 col-xs-12 ">
					<div class="contact-thumbnail">
						<form method="post" action="{{ url('submit_contact') }}">
							{{ csrf_field() }}
							<div class="form-group">
								<div class="col-sm-2">
									<lable  class="control-label form-lable" >Name </lable>
								</div>
								<div class="col-sm-10">
									<input type="text" class="contact-textbox-controll form-control " name="name" id="name" placeholder="Enter your name">
									@if ($errors->has('name'))
                                    <p class="error-msg">
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif
								</div>

								<div class="col-sm-2">
									<lable  class="control-label form-lable" >E-mail </lable>
								</div>
								<div class="col-sm-10">
									<input type="email" class="form-control contact-textbox-controll" name="email" id="email" placeholder="Enter email address">
									@if ($errors->has('email'))
                                    <p class="error-msg">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
								</div>

								<div class="col-sm-2">
									<lable  class="control-label form-lable" >Subject </lable>
								</div>
								<div class="col-sm-10">
									<input type="text" class="form-control contact-textbox-controll" name="subject" id="subject" placeholder="Enter subject">
									@if ($errors->has('subject'))
                                    <p class="error-msg">
                                        {{ $errors->first('subject') }}
                                    </p>
                                @endif
								</div>

								<div class="col-sm-2">
									<lable  class="control-label form-lable" >Content </lable>
								</div>
								<div class="col-sm-10">
									<textarea class="form-control textarea-controll" name="content"  id="content"> </textarea>
									@if ($errors->has('content'))
                                    <p class="error-msg">
                                        {{ $errors->first('content') }}
                                    </p>
                                @endif
								</div>

								<div class="col-sm-2">
									
								</div>
								<div class="col-sm-10">
									<input id="send_msg" type="submit" class="btn-default" value="SEND MESSAGE">
								</div>
							</div>
						</form>
					</div>
				</div>


			</div>
		</div>
	</div>
</section>
@endsection