<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Employees Detailed Report</h4>
        </div>
        <div class="col-md-12 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
                <a href="<?php echo $url;?>admin/add-employee">
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                </a>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filters</h4>

                    <div class="col-md-4 " style="margin-bottom: 25px;">

<!--                        <span class="card-title">Employee:</span>-->

                        <?php

                        $recurrent_holidays = recurrent_holidays();
                        $employees = $this->db->where("is_deleted",0)->where("status",1)->get("employees")->result_object();
                        ?>

                        <div class="row">
                            <div class="col-12">
                                <label for="filterEmployeeSelect">Select Employees from the following list</label>
                                <select
                                        id="filterEmployeeSelect"
                                        class="select2 m-b-10 filterEmployee" name="employee_id" style="width: 100%" >
                                    <?php foreach($employees as $employee){
                                        $site = $this->db->where("id",$employee->site)->get("sites")->result_object()[0];
                                        ?>
                                        <option <?php if($_GET["employee_id"]==$employee->id){ echo 'selected="selected"';}?> value="<?php echo $employee->id; ?>"><?php echo $employee->first_name.' ' .$employee->last_name. ' | '.$site->title;;?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                        <script src="../resources/backend/jquery/jquery-3.2.1.min.js"></script>
                        <script>
                            $( document ).ready(function() {
                                // console.log( "ready!" );

                                $('.filterEmployee').select2();

                                $('.filterEmployee').on('select2:select', function(e) {
                                    var data = e.params.data;
                                    window.location = base_url + "admin/report-employee?employee_id="+data.id;
                                    //showBarChart(data.id);
                                });
                            });
                        </script>

                    </div>





                    <div class="col-12" style="text-align: left;">

                        <a href="<?php echo base_url()."admin/report-employee?employee_id=".$_GET["employee_id"]."&this_month=1"; ?>"><button type="button" class="btn btn-sm btn-<?php echo $selected_type=="this_month"?"primary":"secondary"; ?>">This month</button></a>


                        <a href="<?php echo base_url()."admin/report-employee?employee_id=".$_GET["employee_id"]."&last_month=1"; ?>"><button type="button" class="btn btn-sm btn-<?php echo $selected_type=="last_month"?"primary":"secondary"; ?>">Last month</button></a>


                        <a href="<?php echo base_url()."admin/report-employee?employee_id=".$_GET["employee_id"]."&this_year=1"; ?>"><button type="button" class="btn btn-sm btn-<?php echo $selected_type=="this_year"?"primary":"secondary"; ?>">This Year</button></a>
                    </div>

                    <div class="col-12" style="margin:10px 0; text-align: left;">
                        OR
                    </div>
                    <div class="col-12" style="margin:10px 0; text-align: left;">
                        <form method="post" action="<?php echo base_url()."admin/report-employee?employee_id=".$_GET["employee_id"]; ?>">
                            From: <input class="start_date" type="date" name="start_date" value="<?php echo $start_date; ?>">
                            To: <input class="end_date" type="date" name="end_date"  value="<?php echo $end_date; ?>">
                            <button  class="btn btn-sm btn-<?php echo $selected_type=="custom"?"primary":"secondary"; ?>">Custom Range Filter</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Report</h4>





                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th data-field="day">Day</th>
                                <th>Site</th>
                                <th>Status</th>
                                <th>Check In</th>
                                <th>Tea Break In</th>
                                <th>Tea Break Out</th>
                                <th>Lunch In</th>
                                <th>Lunch Out</th>
                                <th>Tea Break In</th>
                                <th>Tea Break Out</th>
                                <th>Check Out</th>
                                <th>Overtime</th>
                                <th>Late In</th>
                                <th>Early Out</th>
                                <th>Total Worked</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Day</th>
                                <th>Site</th>
                                <th>Status</th>
                                <th>Check In</th>
                                <th>Tea Break In</th>
                                <th>Tea Break Out</th>
                                <th>Lunch In</th>
                                <th>Lunch Out</th>
                                <th>Tea Break In</th>
                                <th>Tea Break Out</th>
                                <th>Check Out</th>
                                <th>Overtime</th>
                                <th>Late In</th>
                                <th>Early Out</th>
                                <th>Total Worked</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
//                            echo "<pre>";
                            //                            var_dump(php_ini_loaded_file(), php_ini_scanned_files());

                            $total_days = 0;

//                            echo "Start date: ".$start_date. " / End date: ".$end_date;

                            $diff = strtotime($end_date) - strtotime($start_date);

                            $total_days = round($diff / (60 * 60 * 24));

//                            echo "<br>Difference: ".$diff;
//                            echo "<br>Total days: ".$total_days;

                            for($i=0; $i<=$total_days; $i++){

//                                echo date( 'Y-m-d' )." -".$i." days";
                                $filter_date =  date("Y-m-d", strtotime( $end_date." -".$i." days"));

//                                echo "<br>The date: ".$filter_date;
                                $checks = $this->db->where("employee_id",$_GET["employee_id"])->where("DATE(date)",$filter_date)->get("checks")->result_object();
//                                echo "<pre>";
//                                echo $filter_date." : ".date("l",strtotime($filter_date))." : ". count($checks);
                                $check_in = "--";
                                $lunch_in = "--";
                                $lunch_out = "--";
                                $check_out = "--";

                                $lunch_in2 = "--";
                                $lunch_out2 = "--";
                                $lunch_in3 = "--";
                                $lunch_out3 = "--";

                                $check_in_stamp = 0;
                                $lunch_in_stamp = 0;
                                $lunch_out_stamp = 0;
                                $check_out_stamp = 0;

                                $lunch_in_stamp2 = 0;
                                $lunch_out_stamp2 = 0;
                                $lunch_in_stamp3 = 0;
                                $lunch_out_stamp3 = 0;

                                $total_worked = "--";

                                $started_at=0;
                                $ended_at=0;


                                $check_in_reason = "";
                                $check_out_reason = "";
                                $lunch_in_reason = "";
                                $lunch_out_reason = "";
                                $lunch_in2_reason = "";
                                $lunch_out2_reason = "";
                                $lunch_in3_reason = "";
                                $lunch_out3_reason = "";

                                foreach($checks as $check)
                                {


                                    $site = $this->db->where("id",$check->site)->get("sites")->result_object()[0];


                                    $today_day = date("l",strtotime($filter_date));

                                    $this_opens = 0;
                                    $this_closes = 0;

                                    $day = strtolower($today_day);


                                    if($site->$day==1)
                                    {
                                        $site->open=1;


                                        $column = $day."_opens";
                                        $columnc = $day."_closes";

                                        $this_site_column  =$site->$column;
                                        $this_site_columnc  =$site->$columnc;
                                        $this_opens = strtotime( date("Y-m-d H:i:s", strtotime($site->$column)) );
                                        $this_closes = strtotime( date("Y-m-d H:i:s", strtotime($site->$columnc)) );
                                    }





                                    if($check->type==1)
                                    {
                                        // var_dump($check);
                                        $check_in = date("h:i A",$check->stamp);
                                        $check_in_reason = $check->reason;
                                        // echo $check_in_reason;
                                        $started_at=$check->stamp;
                                        $check_in_stamp = $check->stamp;
                                    }

                                    if($check->type==2)
                                    {
                                        $check_out = date("h:i A",$check->stamp);
                                        $check_out_reason = $check->reason;
                                        $ended_at=$check->stamp;
                                        $check_out_stamp = $check->stamp;

                                    }

                                    if($check->type==3)
                                    {
                                        $lunch_in = date("h:i A",$check->stamp);
                                        $lunch_in_reason = $check->reason;
                                        $lunch_in_stamp = $check->stamp;

                                    }

                                    if($check->type==4)
                                    {
                                        $lunch_out = date("h:i A",$check->stamp);
                                        $lunch_out_reason = $check->reason;
                                        $lunch_out_stamp = $check->stamp;

                                    }


                                    // 2
                                    if($check->type==7)
                                    {
                                        $lunch_in2 = date("h:i A",$check->stamp);
                                        $lunch_in2_reason = $check->reason;

                                        $lunch_in_stamp2 = $check->stamp;
                                    }

                                    if($check->type==8)
                                    {
                                        $lunch_out2 = date("h:i A",$check->stamp);
                                        $lunch_out2_reason = $check->reason;

                                        $lunch_out_stamp2 = $check->stamp;
                                    }


                                    // 3
                                    if($check->type==9)
                                    {
                                        $lunch_in3 = date("h:i A",$check->stamp);
                                        $lunch_in3_reason = $check->reason;

                                        $lunch_in_stamp3 = $check->stamp;

                                    }

                                    if($check->type==10)
                                    {
                                        $lunch_out3 = date("h:i A",$check->stamp);
                                        $lunch_out3_reason = $check->reason;

                                        $lunch_out_stamp3 = $check->stamp;

                                    }
                                }

                                $total_worked = $ended_at - $started_at;

                                // deducting lunch time 1
                                if($lunch_in!="--" && $lunch_out!="--")
                                {
                                    $total_worked -= ($lunch_out_stamp-$lunch_in_stamp);
                                }

                                // deducting lunch time 2
                                if($lunch_in2!="--" && $lunch_out2!="--")
                                {
                                    $total_worked -= ($lunch_out2_stamp-$lunch_in2_stamp);
                                }

                                // deducting lunch time 3
                                if($lunch_in3!="--" && $lunch_out3!="--")
                                {
                                    $total_worked -= ($lunch_out3_stamp-$lunch_in3_stamp);
                                }

                                $is_holiday = false;


                                $overtime  = ( $total_worked - ( $this_closes - $this_opens ) );
                                if($overtime<0) $overtime = 0;


                                $x = strtotime(date("Y-m-d",strtotime($check->date)).' '.$this_site_column);
                                $real_late_in = $x;
                                $late_in  = ( $check_in_stamp - ( $real_late_in ) );
                                if($late_in<0) $late_in = 0;

                                $early_real_close = strtotime(date("Y-m-d",strtotime($check->date)).' '.$this_site_columnc);
                                $early_out  = ( ( $early_real_close ) - $check_out_stamp  );
                                if($early_out<0) $early_out = 0;


                                // only approved leaves
                                $checkLeave = $this->db->where("user_id",$_GET["employee_id"])->where("DATE(start_date) <=",$filter_date)->where("DATE(end_date) >=",$filter_date)->where("status",1)->get("leaves")->result_object();
                                $onLeave = 0;
                                foreach($checkLeave as $leave)
                                {
                                    if($leave == 1)
                                    {
                                        $onLeave = 1;
                                    }
                                }
                                // if(in_array($today_day, $recurrent_holidays))
                                //     $is_holiday=true;



                                $is_holiday=is_holiday($filter_date,$site->id);
                                $leave_type_string = get_leave_type($checkLeave[0]->leave_type);

                                ?>
                                    <td data-sort="'. $filter_date .'">
                                        <?php echo date("d F Y",strtotime($filter_date)); ?>
                                        <?php echo ", ".date("l",strtotime($filter_date)); ?>

                                    </td>
                                    <td>
                                        <?php echo $site->title; ?>

                                    </td>
                                    <td>
                                        <?php

                                        if(count($checks)>0)
                                            {
//                                                echo "Present Leave: ".$onLeave;
                                                if($onLeave == 1)
                                                {
                                                    //echo $checkLeave->leave_duration;
                                                    echo "<span style='color:#7b0cbf;font-weight: bold'>".$leave_type_string."</span>";
                                                }
                                                else {
                                                    echo "<span style='color:green'>Present</span>";
                                                }
                                            }
                                        else if($is_holiday) {
                                            echo "<span style='color:orange'>Holiday</span>";
                                        }
                                        else
                                        {
//                                            echo "Absent Leave: ".$onLeave;
                                            if($onLeave == 1)
                                            {
                                                echo "<span style='color:#7b0cbf;font-weight: bold'>".$leave_type_string."</span>";
                                                //echo "<span style='color:#7b0cbf;font-weight: bold'>Leave</span>";
                                            }
                                            else {
                                                echo "<span style='color:red'>Absent</span>";
                                            }
                                        }


                                        ?>
                                    </td>

                                    <td>
                                        <?php

                                        if($is_holiday) echo "Holiday";
                                        else echo $check_in;
                                        if($check_in_reason!=""  && !$is_holiday )
                                        {
                                            echo "<br><b>Reason:</b> ".$check_in_reason;
                                        }
                                        ?>
                                    </td>


                                    <!--Tea Break 1-->

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        else echo $lunch_in2;
//                                        if($lunch_in2_reason!=""  && !$is_holiday )
//                                        {
//                                            echo "<br><b>Reason:</b> ".$lunch_in2_reason;
//                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        else echo $lunch_out2;
//                                        if($lunch_out2_reason!=""  && !$is_holiday )
//                                        {
//                                            echo "<br><b>Reason:</b> ".$lunch_out2_reason;
//                                        }
                                        ?>
                                    </td>

                                    <!--Lunch Break-->

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        else echo $lunch_in;
//                                        if($lunch_in_reason!=""  && !$is_holiday )
//                                        {
//                                            echo "<br><b>Reason:</b> ".$lunch_in_reason;
//                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        else echo $lunch_out;
//                                        if($lunch_out_reason!=""  && !$is_holiday )
//                                        {
//                                            echo "<br><b>Reason:</b> ".$lunch_out_reason;
//                                        }
                                        ?>
                                    </td>


                                    <!--Tea Break 2-->

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        else echo $lunch_in3;
//                                        if($lunch_in3_reason!=""  && !$is_holiday )
//                                        {
//                                            echo "<br><b>Reason:</b> ".$lunch_in3_reason;
//                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        else echo $lunch_out3;
//                                        if($lunch_out3_reason!=""  && !$is_holiday )
//                                        {
//                                            echo "<br><b>Reason:</b> ".$lunch_out3_reason;
//                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        else echo $check_out;
                                        if($check_out_reason!="" && !$is_holiday )
                                        {
                                            echo "<br><b>Reason:</b> ".$check_out_reason;
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        elseif(count($checks)==0) echo "--";
                                        else echo secs_to_mins($overtime); // overtime ?>
                                    </td>


                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        elseif(count($checks)==0) echo "--";
                                        else echo secs_to_mins($late_in); // late in
                                        ?>
                                    </td>

                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        elseif(count($checks)==0) echo "--";
                                        elseif($check_out=="--") echo "--";
                                        else echo secs_to_mins($early_out); // late out ?>
                                    </td>
                                    <td>
                                        <?php if($is_holiday) echo "Holiday";
                                        elseif(count($checks)==0) echo "--";
                                        elseif($check_out=="--") echo "--";
                                        else echo secs_to_mins($total_worked); // total worked ?>
                                    </td>



                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>

            </script>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->

    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<script>

</script>