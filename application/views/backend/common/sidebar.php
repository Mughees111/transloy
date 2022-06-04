
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User Profile-->
                <div class="user-profile">
                    <div class="user-pro-body">
                        <div><img src="<?php echo base_url(); ?>resources/uploads/profiles/<?php echo $this->session->userdata("admin_profile_pic"); ?>" alt="user-img" class="img-circle"></div>
                        <div class="dropdown">
                            <a  href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata("admin_name")?$this->session->userdata("admin_name"):"Admin"; ?> <span class="caret"></span></a>
                            <div class="dropdown-menu animated flipInY">
                                <!-- text-->
                                <a href="<?php echo base_url()."admin/my-profile"; ?>" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                                <!-- text-->
                                <?php /* ?>
                                <div class="dropdown-divider"></div>

                                <a href="<?php echo $url."admin/";?>company-details" class="dropdown-item"><i class="ti-user"></i> Manage Company</a>
                                <?php 
                                */ ?>

                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <?php if(check_role(2)){ ?>
                                <a href="<?php echo base_url()."admin/settings"; ?>" class="dropdown-item"><i class="ti-settings"></i> Settings</a>
                                <?php } ?>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="<?php echo base_url().'admin/logout'; ?>" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                                <!-- text-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
						<li class="<?=($active == 'dashboard')?'active':'';?>"> <a class="waves-effect waves-dark" href="<?php echo base_url().'admin/dashboard';?>" aria-expanded="false"><i class="fa fa-dashboard"></i><span class="hide-menu">Dashboard</span></a>
						</li>
                       
                    <?php if(check_role(1)){ ?>

                        <li class="<?=($active == 'push')?'active':'';?>"> 
                            <a class="
                            waves-effect waves-dark" 
                            href="<?php
                            echo base_url()."admin/push-notifications";
                             ?>"
                            >
                            <span>
                             <i class="fa fa-paper-plane"></i>   Send Push
                            </span>
                        </a>
                        </li>

                    <?php } ?>

					<?php if(check_role(4) && 2==3){ ?>
                        <li class="<?=($active == 'brands')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-bars"></i><span class="hide-menu">Brands</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'brands')?'active':'';?>"><a class="<?=($sub == 'brands')?'active':'';?>" href="<?php echo $url."admin/";?>brands">Brands <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("brands",false); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-brand')?'active':'';?>"><a class="<?=($sub == 'add-brand')?'active':'';?>" href="<?php echo $url."admin/";?>add-brand">Add New Brand</a></li>
                                <li class="<?=($sub == 'trash')?'active':'';?>"><a class="<?=($sub == 'trash')?'active':'';?>" href="<?php echo $url."admin/";?>trash-brands">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("brands",true); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if(check_role(10)){ ?>
                        <li class="<?=($active == 'departments')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Departments</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'departments')?'active':'';?>"><a class="<?=($sub == 'departments')?'active':'';?>" href="<?php echo $url."admin/";?>departments">Departments <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("departments",false); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-department')?'active':'';?>"><a class="<?=($sub == 'add-department')?'active':'';?>" href="<?php echo $url."admin/";?>add-department">Add New Department</a></li>
                                <li class="<?=($sub == 'trash')?'active':'';?>"><a class="<?=($sub == 'trash')?'active':'';?>" href="<?php echo $url."admin/";?>trash-departments">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("departments",true); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>

                     <?php if(check_role(11)){ ?>
                        <li class="<?=($active == 'teams')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Teams</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'teams')?'active':'';?>"><a class="<?=($sub == 'teams')?'active':'';?>" href="<?php echo $url."admin/";?>teams">Teams <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("teams",false); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-team')?'active':'';?>"><a class="<?=($sub == 'add-team')?'active':'';?>" href="<?php echo $url."admin/";?>add-team">Add New Team</a></li>
                                <li class="<?=($sub == 'trash')?'active':'';?>"><a class="<?=($sub == 'trash')?'active':'';?>" href="<?php echo $url."admin/";?>trash-teams">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("teams",true); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if(check_role(4)){ ?>
                        <li class="<?=($active == 'sites')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Construction Sites</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'sites')?'active':'';?>"><a class="<?=($sub == 'sites')?'active':'';?>" href="<?php echo $url."admin/";?>sites">Construction Sites <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("sites",false); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-site')?'active':'';?>"><a class="<?=($sub == 'add-site')?'active':'';?>" href="<?php echo $url."admin/";?>add-site">Add New Construction Site</a></li>
                                <li class="<?=($sub == 'trash')?'active':'';?>"><a class="<?=($sub == 'trash')?'active':'';?>" href="<?php echo $url."admin/";?>trash-sites">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("sites",true); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>



                    <?php if(check_role(5)){ ?>
                        <li class="<?=($active == 'holidays')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-sun-o"></i><span class="hide-menu">Holidays</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'holidays')?'active':'';?>"><a class="<?=($sub == 'holidays')?'active':'';?>" href="<?php echo $url."admin/";?>holidays">Holidays <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("holidays",false); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-holiday')?'active':'';?>"><a class="<?=($sub == 'add-holiday')?'active':'';?>" href="<?php echo $url."admin/";?>add-holiday">Add New Holiday</a></li>
                               
                            </ul>
                        </li>
                    <?php } ?>

                   
                    <?php if(check_role(6)){ ?>
                        <li class="<?=($active == 'pages')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-file-o"></i><span class="hide-menu">Pages</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'pages')?'active':'';?>"><a class="<?=($sub == 'pages')?'active':'';?>" href="<?php echo $url."admin/";?>pages">Pages <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("pages",false); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-page')?'active':'';?>"><a class="<?=($sub == 'add-page')?'active':'';?>" href="<?php echo $url."admin/";?>add-page">Add New Page</a></li>
                                <li class="<?=($sub == 'trash')?'active':'';?>"><a class="<?=($sub == 'trash')?'active':'';?>" href="<?php echo $url."admin/";?>trash-pages">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("pages",true); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(check_role(7)){ ?>
                        <li class="<?=($active == 'employees')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Employees</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'employees')?'active':'';?>"><a class="<?=($sub == 'employees')?'active':'';?>" href="<?php echo $url."admin/";?>employees">Employees <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo $this->db->where("type",1)->where("is_deleted",0)->count_all_results("employees"); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-employee')?'active':'';?>"><a class="<?=($sub == 'add-employee')?'active':'';?>" href="<?php echo $url."admin/";?>add-employee">Add New Employee</a></li>
                                <li class="<?=($sub == 'trash')?'active':'';?>"><a class="<?=($sub == 'trash')?'active':'';?>" href="<?php echo $url."admin/";?>trash-employees">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo $this->db->where("type",1)->where("is_deleted",1)->count_all_results("employees"); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>


                     <?php if(check_role(-1)){ ?>
                        <li class="<?=($active == 'admins')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-lock"></i><span class="hide-menu">Admins & Managers</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'admins')?'active':'';?>"><a class="<?=($sub == 'admins')?'active':'';?>" href="<?php echo $url."admin/";?>admins">Admins <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("admin",false); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-admin')?'active':'';?>"><a class="<?=($sub == 'add-admin')?'active':'';?>" href="<?php echo $url."admin/";?>add-admin">Add New Admin</a></li>
                                <li class="<?=($sub == 'trash-admins')?'active':'';?>"><a class="<?=($sub == 'trash-admins')?'active':'';?>" href="<?php echo $url."admin/";?>trash-admins">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo count_listing("admin",true); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if( 2==3 &&  check_role(9)){ ?>
                        <li class="<?=($active == 'managers')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-lock"></i><span class="hide-menu">Managers</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'managers')?'active':'';?>"><a class="<?=($sub == 'managers')?'active':'';?>" href="<?php echo $url."admin/";?>managers">Managers <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo $this->db->where("type",2)->where("is_deleted",0)->count_all_results("admins"); ?>
                                </span></a></li>
                                <li class="<?=($sub == 'add-admin')?'active':'';?>"><a class="<?=($sub == 'add-admin')?'active':'';?>" href="<?php echo $url."admin/";?>add-manager">Add New Manager</a></li>
                                <li class="<?=($sub == 'trash-managers')?'active':'';?>"><a class="<?=($sub == 'trash-managers')?'active':'';?>" href="<?php echo $url."admin/";?>trash-managers">Trash <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo $this->db->where("type",2)->where("is_deleted",1)->count_all_results("admins"); ?>
                                </span></a></li>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if(check_role(8)){ ?>
                        <li class="<?=($active == 'leaves')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-calendar-times-o"></i><span class="hide-menu">Leaves</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'leaves')?'active':'';?>"><a class="<?=($sub == 'leaves')?'active':'';?>" href="<?php echo $url."admin/";?>leaves">Leaves <span class="badge badge-pill badge-cyan ml-auto">
                                    <?php echo $this->db->count_all_results("leaves"); ?>
                                </span></a></li>
                                
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(check_role(-1)){ ?>
                        <li class="<?=($active == 'reports')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-file-text"></i><span class="hide-menu">Reports</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li class="<?=($sub == 'reports')?'active':'';?>"><a class="<?=($sub == 'attendance_rep')?'active':'';?>" href="<?php echo $url."admin/";?>reports">Attendance Reports</a></li>

                                <li class="<?=($sub == 'reports')?'active':'';?>"><a class="<?=($sub == 'presence_trends')?'active':'';?>" href="<?php echo $url."admin/";?>presence_trends">Presence Trends</a></li>

                                <li class="<?=($sub == 'reports')?'active':'';?>"><a class="<?=($sub == 'employee_report')?'active':'';?>" href="<?php echo $url."admin/";?>report-employee">Employees Report</a></li>
                                
                            </ul>
                        </li>
                    <?php } ?>

                        <?php if(check_role(-1)){ ?>
                            <li class="<?=($active == 'petty_cash')?'active':'';?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Allowances</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class="<?=($sub == 'petty_cash')?'active':'';?>"><a class="<?=($sub == 'petty_cash_inside')?'active':'';?>" href="<?php echo $url."admin/";?>pettycash">Applications</a></li>

                                </ul>
                            </li>
                        <?php } ?>

                    


                    <!--<li class="nav-small-cap">--- Other</li>
                    
                    <li> <a class="waves-effect waves-dark" href="<?php //echo $url.'admin/logout'; ?>" aria-expanded="false"><i class="fa fa-circle-o text-success"></i><span class="hide-menu">Log Out</span></a></li>-->
                       
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ==============================================================