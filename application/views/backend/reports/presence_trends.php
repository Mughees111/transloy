<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Presence Trend</h4>
        </div>
        <div class="col-md-12 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
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

<!--                                               <span class="card-title">Departments: </span>-->

                        <?php

                        $recurrent_holidays = recurrent_holidays();
                        $departments = $this->db->where("is_deleted",0)->get("departments")->result_object();
                        //                        var_dump($employees);
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <label for="filterEmployeeSelect">Select any department from the following list</label>
                                <select
                                    id="filterDepartmentSelect"
                                    class="select2 m-b-10 " name="departments" style="width: 100%" >
                                    <?php foreach($departments as $dep){
                                        $site = $this->db->where("id",$employee->site)->get("sites")->result_object()[0];
                                        ?>
                                        <option <?php if($_GET["employee_id"]==$dep->id){ echo 'selected="selected"';}?> value="<?php echo $dep->id; ?>"><?php echo $dep->title;?></option>
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





<!--                    <div class="col-12" style="text-align: left;">-->
<!---->
<!--                        <a href="--><?php //echo base_url()."admin/reports/index?employee_id=".$_GET["employee_id"]."&this_month=1"; ?><!--"><button type="button" class="btn btn-sm btn---><?php //echo $selected_type=="this_month"?"primary":"secondary"; ?><!--">This month</button></a>-->
<!---->
<!---->
<!--                        <a href="--><?php //echo base_url()."admin/reports/index?employee_id=".$_GET["employee_id"]."&last_month=1"; ?><!--"><button type="button" class="btn btn-sm btn---><?php //echo $selected_type=="last_month"?"primary":"secondary"; ?><!--">Last month</button></a>-->
<!---->
<!---->
<!--                        <a href="--><?php //echo base_url()."admin/reports/index?employee_id=".$_GET["employee_id"]."&this_year=1"; ?><!--"><button type="button" class="btn btn-sm btn---><?php //echo $selected_type=="this_year"?"primary":"secondary"; ?><!--">This Year</button></a>-->
<!--                    </div>-->

                    <div class="col-12" style="margin:10px 0; text-align: left;">
                        OR
                    </div>
                    <div class="col-12" style="margin:10px 0; text-align: left;">

                            From: <input class="start_date" type="date" name="start_date" id="start_date" value="<?php echo $start_date; ?>">
                            To: <input class="end_date" type="date" name="end_date" id="end_date"  value="<?php echo $end_date; ?>">
                            <button id="dateBtn" class="btn btn-sm btn-<?php echo $selected_type=="custom"?"primary":"secondary"; ?>">Custom Range Filter</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Presence Trends</h4>
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
    $(document).ready(function(){
        $(function() {
            var data = JSON.parse('<?php echo $chart_data; ?>');
            console.log(data);
            var name = [];
            var marks = [];

            for (var i in data) {
                name.push(data[i].date);
                marks.push(data[i].employee_count);
            }

            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: 'Over all Employee Attendance',
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgb(75, 192, 192)',
                        data: marks
                    }
                ]
            };

            var graphTarget = $("#bar-chart");

            var graph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata,
                options:{
                    scales:{
                        yAxis:[{
                            ticks:{
                                stepSize:1
                            }
                        }]
                    }
                }
            });
        });

        $('#filterDepartmentSelect').change(function(){
            var dep_id = $('#filterDepartmentSelect option').filter(":selected").val();
            var dep_title = $('#filterDepartmentSelect option').filter(":selected").text();
            console.log(dep_id+" / "+dep_title);

            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : 'Reports/getAttendanceOfDepartment', //Your form processing file URL
                data      : { dep_id:dep_id},
                dataType  : 'json',
                success   : function(data){
                    console.log(data);

                    $('#chart-container').html(''); //remove canvas from container
                    $('#chart-container').html('<canvas id="bar-chart"> </canvas>'); //add it back to the container

                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].date);
                        marks.push(data[i].employee_count);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Attendance of Department: '+dep_title,
                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                borderColor: 'rgb(75, 192, 192)',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#bar-chart");

                    var graph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options:{
                            scales:{
                                y:{
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }
                        }
                    });
                },
                error: function(data){
                    alert("error");
                    console.log(data);
                }
            });

        });

        $('#dateBtn').click(function(){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            console.log(start_date+" / "+end_date);

            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : 'Reports/getAttendanceByDate', //Your form processing file URL
                data      : { start_date:start_date, end_date:end_date},
                dataType  : 'json',
                success   : function(data){
                    console.log(data);

                    $('#chart-container').html(''); //remove canvas from container
                    $('#chart-container').html('<canvas id="bar-chart"> </canvas>'); //add it back to the container

                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].date);
                        marks.push(data[i].employee_count);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Attendance of all Employees In Range: '+start_date+' - '+end_date,
                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                borderColor: 'rgb(75, 192, 192)',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#bar-chart");

                    var graph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options:{
                            scales:{
                                y:{
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }
                        }
                    });
                },
                error: function(data){
                    alert("error");
                    console.log(data);
                }
            });

        });
    });




</script>