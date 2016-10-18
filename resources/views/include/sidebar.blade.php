<div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-heart"></i> <span>Identity Cards</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="{{ url('assets/images/admin.png') }}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>Admin</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  
                  @if(Auth::guard('employee')->user()->is_admin == 1)
                  <li><a><i class="fa fa-user"></i> Employees <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin/employees_list') }}">List</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin/users_list') }}">List</a></li>
                    </ul>
                  </li> 
                  <li><a><i class="fa fa-star"></i> Templates <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin/templates') }}">List</a></li>
                      <li><a href="{{ url('admin/categories/list') }}">Categories</a></li>
                    </ul>
                  </li> 
                  <li><a><i class="fa fa-heart"></i> Card Materials <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin/materials/list') }}">List</a></li>
                    </ul>
                  </li>
                  @endif 
                  
                  <li><a><i class="fa fa-pencil-square-o "></i> Orders <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('new_orders/list') }}">New</a></li>
                      <li><a href="{{ url('orders/list') }}">Confirmed</a></li>
                      <li><a href="{{ url('cancel_orders/list') }}">Cancelled</a></li>
                      <li><a href="{{ url('orders/history/list') }}">History</a></li>
                    </ul>
                  </li>

                  @if(Auth::guard('employee')->user()->is_admin == 1)
                  <li><a><i class="fa fa-question-circle "></i> FAQs <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin/faqs/list') }}">list</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-phone-square"></i> Contacts <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin/contacts') }}">List</a></li>
                    </ul>
                  </li>  
                  @endif
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small" >
              <a href="{{ url('admin/logout') }}" style="width:100%;" data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>