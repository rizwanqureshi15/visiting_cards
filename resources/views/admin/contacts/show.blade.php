@extends('master')
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Contacts</h3>
  </div>
  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <ol class="breadcrumb">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Contacts</li>
          <li class="active">Show</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
            	<h2>{{ $contact->name }}</h2>
             	<ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
         	<div class="x_content form-horizontal">
         		<div class="form-group">
              		<label class="col-sm-2 control-label">Email Address : </label>
              		<div class="col-sm-10" style="padding-top: 8px;color: black;font-weight: 600;">
                		{{ $contact->email}}
              		</div>
            	</div>
            	<div class="form-group">
              		<label class="col-sm-2 control-label">Subject : </label>
              		<div class="col-sm-10" style="padding-top: 8px;color: black;font-weight: 600;">
                		{{ $contact->subject }}
              		</div>
            	</div>
            	<div class="form-group">
              		<label class="col-sm-2 control-label">Content : </label>
              		<div class="col-sm-10" style="padding-top: 8px;color: black;font-weight: 600;">
                		 {{ $contact->content }} 
              		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
	<script type="text/javascript">
	</script>
@endsection
