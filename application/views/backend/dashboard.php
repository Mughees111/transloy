<?php 
if(isEmployee())
        {
            $the_employee = getEmployee();



            $my_deparment = $this->db->where("id",$the_employee->department)->get("departments")->result_object()[0];


            if($my_deparment)
            {
                $arr = array($my_deparment->id);



                for($i=0;$i<=20;$i++)
                {

                    $my_deparment = $this->db->where("parent",$my_deparment->id)->get("departments")->result_object()[0];

                    if(!$my_deparment) break;

                    $arr[] = $my_deparment->id;
                }


            }
            else{
                $leaves= [];
            }


            $this->db->where("id !=",$the_employee->id);
            $this->db->where_in("department",$arr);
            $this->db->where("is_deleted",0);
            $employees=$this->db->get("employees")->result_object();
            $the_arr = array(-1);


            foreach($employees as $employee)
            {
                $the_arr[] = $employee->id;
            }

            $do_where_in = 1;

        }
        else $do_where_in=0;
        


?>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Dashboard</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
               <!--  <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button> -->
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Info box -->
    <!-- ============================================================== -->
   
    <!-- ============================================================== -->
    <!-- End Info box -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Over Visitor, Our income , slaes different and  sales prediction -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Comment - table -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- End Comment - chats -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Over Visitor, Our income , slaes different and  sales prediction -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Todo, chat, notification -->
    <!-- ============================================================== -->
     <div class="card-group">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Good Day!</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                $today = date("Y-m-d");
                                $today_day = date("l",strtotime($today));

                                echo $today_day;


                                echo is_holiday($today) ? ", Enjoy Holiday!"  : "";

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <?php if(!is_holiday($today)){ ?>
    <div class="card-group">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Check Ins</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                
                                if($do_where_in==1) $this->db->where_in("employee_id",$the_arr);
                                $count = $this->db->where("DATE(date)",$today)->where("type",1)->count_all_results("checks");

                                echo $count;

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">


            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Lunch Ins</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                
                                if($do_where_in==1) $this->db->where_in("employee_id",$the_arr);
                                $count = $this->db->where("DATE(date)",$today)->where("type",3)->count_all_results("checks");

                                echo $count;

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">


        <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Lunch Outs</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                
                                if($do_where_in==1) $this->db->where_in("employee_id",$the_arr);
                                $count = $this->db->where("DATE(date)",$today)->where("type",4)->count_all_results("checks");

                                echo $count;

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Check Outs</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                    if($do_where_in==1) $this->db->where_in("employee_id",$the_arr);

                                $count = $this->db->where("DATE(date)",$today)->where("type",2)->count_all_results("checks");

                                echo $count;

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

        <?php


        $users_on_this_site = $this->db->where("site",0)->where("status",1)->where("is_deleted",0)->get("employees")->result_object();

        $users_on_this_site_arr = array(-1);

        foreach($users_on_this_site as $users_on_this_sit)
        {
            $users_on_this_site_arr[] = $users_on_this_sit->id;
        }



        $attends = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",1)->get("checks")->result_object();


        ?>

    <div class="row">
        <div class="col-12">
            <h4>Employees at office</h4>
        </div>
    </div>
    <div class="card-group">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Check Ins</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php

                                    $count = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",1)->count_all_results("checks");

                                    echo $count  ."/".count($users_on_this_site_arr);

                                    echo  " (".percent($count,count($users_on_this_site_arr)).")";

                                    ?>




                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

    $sites = $this->db->where("status",1)->where("is_deleted",0)->get("sites")->result_object();

    foreach($sites as $site)
    {

        $users_on_this_site = $this->db->where("site",$site->id)->where("status",1)->where("is_deleted",0)->get("employees")->result_object();

        $users_on_this_site_arr = array(-1);

        foreach($users_on_this_site as $users_on_this_sit)
        {
            $users_on_this_site_arr[] = $users_on_this_sit->id;
        }



     ?>
  

    <div class="row">
        <div class="col-12">
            <h4>Site: <?php echo $site->title; ?></h4>
        </div>
    </div>
    <div class="card-group">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Check Ins</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                
                                $count = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",1)->count_all_results("checks");

                                echo $count  ."/".count($users_on_this_site_arr);

                                echo  " (".percent($count,count($users_on_this_site_arr)).")";

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php /* ?>
        <div class="card">


            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Lunch Ins</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                

                                $count = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",3)->count_all_results("checks");

                                echo $count  ."/".count($users_on_this_site_arr);

                                echo  " (".percent($count,count($users_on_this_site_arr)).")";

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">


        <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Lunch Outs</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                

                                $count = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",4)->count_all_results("checks");


                                echo $count  ."/".count($users_on_this_site_arr);

                                echo  " (".percent($count,count($users_on_this_site_arr)).")";

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">Today Check Outs</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary"><?php 
                                

                                $count = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",2)->count_all_results("checks");

                                echo $count  ."/".count($users_on_this_site_arr);

                                echo  " (".percent($count,count($users_on_this_site_arr)).")";

                                 ?>
                                     



                                 </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php */ ?>

    </div>


    <?php } ?>



    <div class="row">
        <div class="col-12">
            <h4>Realtime Attendance</h4>
        </div>
    </div>

    <div class="row">
        <?php


        $users_on_this_site = $this->db->where("site",0)->where("status",1)->where("is_deleted",0)->get("employees")->result_object();

        $users_on_this_site_arr = array(-1);

        foreach($users_on_this_site as $users_on_this_sit)
        {
            $users_on_this_site_arr[] = $users_on_this_sit->id;
        }



        $attends = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",1)->get("checks")->result_object();


        ?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body" style="padding: 1.25rem 0 !important;">
                    <h5 class="card-title" style="margin-left: 1.25rem">Employees at Office</h5>
                    <div class="message-box ps ps--theme_default ps--active-y" id="msg" style="height: 430px;position: relative;" data-ps-id="5a120e08-1e0b-615e-7a3e-c528399cbd55">
                        <div class="message-widget message-scroll siteToKeepUp" data-site-id="0" data-reload-time="<?php echo time(); ?>">
                            <!-- Message -->

                            <?php foreach($attends as $atten){

                                $employee = $this->db->where("id",$atten->employee_id)->get("employees")->result_object()[0];

                                echo print_atten($atten,$employee);
                            } ?>

                        </div>
                        <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__scrollbar-y-rail" style="top: 0px; height: 430px; right: 0px;"><div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 349px;"></div></div></div>
                </div>
            </div>
        </div>

    <?php

        $sites = $this->db->where("status",1)->where("is_deleted",0)->get("sites")->result_object();

        foreach($sites as $site)
        {

            $users_on_this_site = $this->db->where("site",$site->id)->where("status",1)->where("is_deleted",0)->get("employees")->result_object();

            $users_on_this_site_arr = array(-1);

            foreach($users_on_this_site as $users_on_this_sit)
            {
                $users_on_this_site_arr[] = $users_on_this_sit->id;
            }


            
            $attends = $this->db->where_in("employee_id",$users_on_this_site_arr)->where("DATE(date)",$today)->where("type",1)->get("checks")->result_object();




     ?>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body" style="padding: 1.25rem 0 !important;">
                    <h5 class="card-title" style="margin-left: 1.25rem">Site: <?php echo $site->title;  ?></h5>
                    <div class="message-box ps ps--theme_default ps--active-y" id="msg" style="height: 430px;position: relative;" data-ps-id="5a120e08-1e0b-615e-7a3e-c528399cbd55">
                        <div class="message-widget message-scroll siteToKeepUp" data-site-id="<?php echo $site->id; ?>" data-reload-time="<?php echo time(); ?>">
                            <!-- Message -->

                            <?php foreach($attends as $atten){ 

                                $employee = $this->db->where("id",$atten->employee_id)->get("employees")->result_object()[0];
                                
                                echo print_atten($atten,$employee);
                                 } ?>
                           
                        </div>
                    <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__scrollbar-y-rail" style="top: 0px; height: 430px; right: 0px;"><div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 349px;"></div></div></div>
                </div>
            </div>
        </div>

    <?php } ?>


    </div>


    

    <?php } ?>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<audio id="myAudio">
  <source src="<?php echo base_url()."resources/backend/"; ?>tone.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>