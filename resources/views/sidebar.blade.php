
<div class="list-group col-md-12" style="margin-top:30px;" id="div1">
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
  <a href="{{ url('admin/logout') }}" id="logout" class="list-group-item {{ Request::is('admin/logout') ? 'active' : ''}}">
  	Logout
  </a>
</div>