
<div class="list-group col-md-12" style="margin-top:30px;" id="sidebar">
  
  @if(Auth::guard('employee')->user()->is_admin == 1)
  <a href="{{ url('admin/employees_list') }}" id="employee_list" class="list-group-item {{ Request::is('admin/employees_list') || Request::segment(2)=='employees' ? 'active' : ''}}">
  	Employees list
  </a>
  <a href="{{ url('admin/users_list') }}" id="user" class="list-group-item {{ Request::is('admin/users_list') ? 'active' : ''}}">
  	Users List
  </a>
   <a href="{{ url('admin/templates') }}" id="template" class="list-group-item {{ Request::is('admin/templates') || Request::segment(2)=='templates' ? 'active' : ''}}">
  	Template
  </a>
  <a href="{{ url('admin/categories/list') }}" id="template" class="list-group-item {{ Request::is('admin/categories') || Request::segment(2)=='categories' ? 'active' : ''}}">
    Template Categories
  </a>
  <a href="{{ url('admin/materials/list') }}" id="template" class="list-group-item {{ Request::is('admin/materials') || Request::segment(2)=='materials' ? 'active' : ''}}">
    Card Material
  </a>
  @endif
  <a href="{{ url('new_orders/list') }}" id="employee_list" class="list-group-item {{ Request::is('new_orders/list') || Request::segment(2)=='new_orders' ? 'active' : ''}}">
    New Orders
  </a>
  <a href="{{ url('orders/list') }}" id="employee_list" class="list-group-item {{ Request::is('orders/list') || Request::segment(2)=='orders' ? 'active' : ''}}">
    Confirmed Orders
  </a>
  <a href="{{ url('cancel_orders/list') }}" id="employee_list" class="list-group-item {{ Request::is('cancel_orders/list') || Request::segment(2)=='cancel_orders' ? 'active' : ''}}">
    Cancelled Orders
  </a>
  <a href="{{ url('admin/logout') }}" id="logout" class="list-group-item {{ Request::is('admin/logout') ? 'active' : ''}}">
  	Logout
  </a>
</div>