<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top" style="background-color:#2874a0">
            <div class="container">
                <div class="navbar-header">
                    <a href="{{url('/dashboard')}}" class="navbar-brand"><b>Medi</b>SOFT</a>
                </div>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>

                            <ul class="dropdown-menu">

                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the messages -->
                                    <ul class="menu">
                                        <li>
                                            <!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <img src="{{URL::to('public/assets/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <h4>
                                                  Support Team
                                                    <small>
                                                        <i class="fa fa-clock-o"></i>
                                                       5 mins
                                                    </small>
                                                 </h4>
                                                <!-- The message -->
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                    </ul>
                                    <!-- /.menu -->
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>

                            </ul>
                        </li>
                        <!-- /.messages-menu -->

                        <!-- Notifications Menu -->
                        <!-- User Account Menu -->

                        <li class="dropdown user user-menu">

                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{URL::to('public/assets/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">Admin</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{URL::to('public/assets/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                                    <p>
                                        Admin
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{url('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>

                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-custom-menu -->
            </div>
            <!-- /.container-fluid -->

            <!-- /.container-fluid -->
        </nav>
        <nav class="navbar navbar-top" style="background-color:#0a5077">
            <div class="container">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a class="btn btn-app" href="{{route('hr.employee')}}">
                                <i class="fa fa-user"></i>
                                Employee
                            </a>
                        </li>
                        <li class="active">
                            <a class="btn btn-app" href="{{route('hr.doctor')}}">
                                <i class="fa fa-user-md"></i>
                                Doctor
                            </a>
                        </li>
                        <li class="">
                            <a class="btn btn-app" href="{{route('settings.setup')}}">
                                <i class="fa fa-gears"></i>
                                Setup
                            </a>
                        </li>

                        <li class="">
                            <a class="btn btn-app" href="{{route('hr.schedule')}}">
                                <i class="fa fa-gears"></i>
                                Schedule
                            </a>
                        </li>

                        <li class="">
                            <a class="btn btn-app" href="{{route('diagnostic-test')}}">
                                <i class="fa fa-stethoscope"></i>
                                Diagnostic
                            </a>
                        </li>

                        <li class="">
                            <a class="btn btn-app" href="{{route('outdoor.patient')}}">
                                <i class="fa fa-gear"></i>
                                Patient
                            </a>
                        </li>
                        
                        <li class="">
                            <a class="btn btn-app" href="{{route('reports.index')}}">
                                <i class="fa fa-gear"></i>
                                Reports
                            </a>
                        </li>

                    </ul>

                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>
    </header>
