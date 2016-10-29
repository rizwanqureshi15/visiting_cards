@extends('master')
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Orders</h3>
  </div>
  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <ol class="breadcrumb">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Orders</li>
          <li class="active">New Orders</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @if(Session::get('succ_msg'))
            <div class="alert alert-success" role="alert">
              <a class="alert-link">{{ Session::get('succ_msg') }}</a>
            </div>
        @endif
        <div class="x_panel">
            <div class="x_title">
                <h2>New Orders</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="order_table" class="table table-condensed datatable" style="width:100%;">
                    <thead>
                        <tr>
                            <th> Order No. </th>
                            <th> Username </th>
                            <th> Quantity </th>
                            <th> Amount </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="onDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{ Form::open(array('method' => 'post', 'url' => url('cancel_order'), 'class' =>"form-horizontal")) }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Cancel Order</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-6 control-label">Are you sure want to cancel this Order ?</label>
            <div class="col-sm-6">
              {{ Form::hidden('cancel_id', null, ['id' => 'cancel_order_id']) }}
            </div>
          </div>        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" value="Delete">    
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection

@section('js')
	<script>
    $(document).ready(function(){
        var site_url = "{{ url('') }}";
    	var token = "{{ csrf_token() }}";
      $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("admin/new-order-datatable") }}',
            columns:[
            	{data: 'order_no', name: 'order_no' , orderable: true, searchable: true},
            	{data: 'user_id', name: 'user_id', orderable: true, searchable: true},
            	{data: 'quantity', name: 'quantity', orderable: true, searchable: false},
            	{data: 'amount', name: 'amount', orderable: true, searchable: false},
            	{data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-center", "aTargets": [ 0,1,2,3,4 ] },
              ]
        });
      var table = $('#order_table').DataTable();
    $('#order_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
    $(document).on('click','.cancel_order', function(){

                var cancel_id = $(this).data('id');
                $('#cancel_order_id').val(cancel_id);

            });
    });
  </script>
	
@endsection
