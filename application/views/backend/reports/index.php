<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Employees Graphical Report</h4>
        </div>
        <div class="col-md-12 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
                <a href="<?php echo $url;?>#">
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

    <style type="text/css">
        #chart-container {
            width: 100%;
            height: auto;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filters</h4>

                    <div class="col-md-4 " style="margin-bottom: 25px;">

                        <!--                        <span class="card-title">Employees: </span>-->

                        <?php

                        $recurrent_holidays = recurrent_holidays();
                        $employees = $this->db->where("is_deleted",0)->where("status",1)->get("employees")->result_object();
                        //                        var_dump($employees);
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <label for="filterEmployeeSelect">Select Employees from the following list</label>
                                <select
                                        id="filterEmployeeSelect"
                                        class="select2 m-b-10 filterEmployee" name="employee_id[]" style="width: 100%" >
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
                                    window.location = base_url + "admin/reports?employee_id="+data.id;
                                    //showBarChart(data.id);
                                });
                            });

                        </script>

                    </div>





                    <div class="col-12" style="text-align: left;">

                        <a href="<?php echo base_url()."admin/reports?employee_id=".$_GET["employee_id"]."&this_month=1"; ?>"><button type="button" class="btn btn-sm btn-<?php echo $selected_type=="this_month"?"primary":"secondary"; ?>">This month</button></a>


                        <a href="<?php echo base_url()."admin/reports?employee_id=".$_GET["employee_id"]."&last_month=1"; ?>"><button type="button" class="btn btn-sm btn-<?php echo $selected_type=="last_month"?"primary":"secondary"; ?>">Last month</button></a>


                        <a href="<?php echo base_url()."admin/reports?employee_id=".$_GET["employee_id"]."&this_year=1"; ?>"><button type="button" class="btn btn-sm btn-<?php echo $selected_type=="this_year"?"primary":"secondary"; ?>">This Year</button></a>
                    </div>

                    <div class="col-12" style="margin-bottom: 10px;margin-top: 10px;">
                        <h3><span class="label label-default" style="color:black">Custom Date Range</span></h3>
                    </div>
                    <div class="col-md-12" style="margin:10px 0; text-align: left;">
                        <form method="post" action="<?php echo base_url()."admin/reports?employee_id=".$_GET["employee_id"]; ?>">
                            From:<input class="start_date" type="date" name="start_date" value="<?php echo $start_date; ?>">
                            To:<input class="end_date" type="date" name="end_date"  value="<?php echo $end_date; ?>">
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
                    <!--                    <div class="col-md-6">-->
                    <!--                        <div class="row">-->
                    <!--                            <label for="datesSelect">Select date for the Employee</label>-->
                    <!--                            <select id="datesSelect"-->
                    <!--                                    class="select2 m-b-10 filterEmployee" name="datesSelect" style="width: 100%">-->
                    <!--                                    --><?php
                    //                                        foreach($dates_list->result_array() as $dates)
                    //                                        {
                    //                                            echo '<option value="'.$dates["date"].'">'.$dates["date"].'</option>';
                    //                                        }
                    //
                    //                                            ?>
                    <!--                            </select>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div id="chart-container" class="m-t-40">
                        <canvas id="bar-chart"> </canvas>
                    </div>
                </div>
            </div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<script src="../resources/backend/jquery/jquery-3.2.1.min.js"></script>
<script>


    $(function(){
        //get the pie chart canvas
        //var data = JSON.parse('<?php //echo $employee_attendance; ?>//');


        var cData = JSON.parse('<?php echo $employee_attendance; ?>');
        console.log(cData.labels[0]);
        console.log(cData.data[0]);
        // console.log(cData.dates[0]);
        console.log(cData.CheckedIn[0]);
        var ctx = $("#bar-chart");

        //pie chart data
        const data = {
            labels: cData.labels[0],
            datasets: [
                {
                    label: "Employee's attendance",
                    data: cData.data[0],
                    backgroundColor: [
                        'rgb(119,227,135)',
                        'rgb(215,77,102)',
                        'rgb(243,230,147)'
                    ],
                    borderColor:[
                        'rgb(12,52,255)',
                        'rgb(123,12,191)',
                        'rgb(253,6,6)'
                    ],
                    borderWidth:[1,1,1],
                    hoverOffset: 4
                }
            ]
        };

        // console.log(data);
        //options
        var options = {
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Employee's Attendance",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 16
                }
            }
        };

        //create Pie Chart class object
        var chart1 = new Chart(ctx, {
            type: "doughnut",
            data: data,
            options:options
        });
    });

</script>