<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Leaves Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Leaves</li>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Leaves</h4>

                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>By</th>
                                <th>Site</th>
                                <th>Type</th>
                                <th>Duration</th>
                                <th>Reason</th>
                                <th>Files</th>
                                <th>Dates</th>
                                <th>Status</th>
                                <th>Data & Time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>By</th>
                                <th>Site</th>
                                <th>Type</th>
                                <th>Duration</th>
                                <th>Reason</th>
                                <th>Files</th>
                                <th>Dates</th>
                                <th>Status</th>
                                <th>Data & Time</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($leaves as $leave){

                                $user = $this->db->where('id',$leave->user_id)
                                    ->get('employees')
                                    ->result_object()[0];

                                $site = $this->db->where('id',$user->site)
                                    ->get('sites')
                                    ->result_object()[0];

                                ?>
                                <tr>
                                    <td>
                                        <?php echo $leave->id; ?>
                                    </td>

                                    <td>
                                        <?php echo $user->first_name . " ".$user->last_name; ?>
                                    </td>

                                    <td>
                                        <?php echo $site->title; ?>
                                    </td>

                                    <td>
                                        <?php echo getTypeText($leave->leave_type); ?>
                                    </td>

                                    <td>
                                        <?php echo getDurationText($leave->leave_duration); ?>
                                    </td>


                                    <td>
                                        <?php echo $leave->reason; ?>
                                    </td>

                                    <td>
                                        <?php

                                        $files = $this->db->where("leave_id",$leave->id)->get('leave_files')->result_object();

                                        foreach($files as $file)
                                        {
                                            // $ext = explode(".",$file->data_string);
                                            // $ext = $ext[ count($ext) - 1 ];
                                            // $ext = strtolower($ext);
                                            // if(in_array($ext,array("png","jgp"))){
                                            ?>

                                            <a style="margin-top: 10px; float: left;" href="<?php echo base_url()."resources/uploads/docs/".$file->data_string; ?>" download ><span class="btn btn-info btn-sm"><?php echo $file->data_title; ?></span></a>
                                            <br>

                                            <?php
                                        }

                                        ?>
                                    </td>



                                    <td>
                                        <?php echo date("d M Y",strtotime($leave->start_date));
                                        echo $leave->leave_duration==3 ? " - ". date("d M Y",strtotime($leave->end_date)) : ( $leave->leave_duration==2?" Half Day - Afternoon":" Half Day - Morning" ); ?>
                                    </td>

                                    <td>

                                        <?php


                                        $my_deparment = $this->db->where("id",$user->department)->get("departments")->result_object()[0];
                                        $arr = array();
                                        $arr[] = $my_deparment;


                                        for($i=0;$i<=20;$i++)
                                        {

                                            $my_deparment = $this->db->where("id",$my_deparment->parent)->get("departments")->result_object()[0];

                                            if(!$my_deparment) break;


                                            $arr[] = $my_deparment;
                                        }

                                        $i=1;



                                        foreach($arr as $k=>$ar){

                                            $leave_it = $ar->approves_leaves==0;

                                            // if(count($arr)==$k+1 && $ar->approves_leaves==1)  $leave_it=false;

                                            if($leave_it) continue;


                                            $did_approve = $this->db->where("department_id",$ar->id)->where("leave_id",$leave->id)->get("leave_approvals")->result_object()[0];

                                            $text = " Pending";

                                            if($did_approve && $leave->leave_type == 3)
                                            {
                                                $approved = 0;
                                                if($did_approve->status == 1) {
                                                    $text = " Approved at " . date("F d, H:i A", strtotime($did_approve->created_at));
                                                    $approved = 1;
                                                }
                                                else if($did_approve->status == 2)
                                                    $text = " Rejected at ".date("F d, H:i A",strtotime($did_approve->created_at));
                                            }
                                            else if(!$did_approve)
                                            {
                                                if($leave->leave_type == 3 && $leave->status==1)
                                                {
                                                    $text = "Emergency leave has been approved.";
                                                }
                                            }

                                            if($did_approve && $leave->leave_type != 3)
                                            {
                                                if($did_approve->status==1)
                                                    $text = " Approved at ".date("F d, H:i A",strtotime($did_approve->created_at));
                                                else
                                                    $text = " Rejected at ".date("F d, H:i A",strtotime($did_approve->created_at));

                                            }
                                            if(strtolower($user->job_title) == "hr" || (strtolower($ar->title) != strtolower($user->job_title)) )
                                            {
                                                echo ($i).". ".$ar->title.": ".$text. " <br>";
                                                $i++;
                                            }
                                            ?>

                                        <?php } ?>

                                        <?php  if($leave->status == 3){ ?>
                                            <a href="javascript:;" ><span class="btn btn-info">Cancelled By User</span></a>


                                        <?php }else{

                                            $type_employee = isEmployee();
                                            $the_employee = getEmployee();


                                            foreach($arr as $k=>$ar){
                                                $leave_it = $ar->approves_leaves==0;

                                                if(count($arr)==$k+1 && $ar->approves_leaves==1)  $leave_it=false;

                                                if($leave_it) continue;
                                                $text = "";
                                                $did_approve = $this->db->where("department_id",$ar->id)->where("leave_id",$leave->id)->get("leave_approvals")->result_object()[0];


                                                if($type_employee && !$did_approve && $the_employee->department==$ar->id){
                                                    $text = "Approve as ".$ar->title;
                                                    $textr = "Reject as ".$ar->title;
                                                }

                                                if(!$did_approve && !$type_employee)
                                                {
                                                    if(!($leave->leave_type == 3 && $leave->status == 1)) {
                                                        if (strtolower($user->job_title) == "hr" || (strtolower($ar->title) != strtolower($user->job_title))) {
                                                            //printf($user->job_title);
                                                            $text = "Approve on behalf of " . $ar->title;
                                                            $textr = "Reject on behalf of " . $ar->title;
                                                        }
                                                    }
                                                }

                                                if($text!=""){
                                                    ?>
                                                    <a style=" margin-top: 10px;float: left;" href="<?php echo $url."admin/";?>leaves/status/<?php echo $leave->id;?>/1/<?php echo $ar->id; ?>"><div class="btn btn-sm btn-success btn-xs "><?php echo $text; ?></div></a>
                                                    <a style=" margin-top: 10px;float: left;" href="<?php echo $url."admin/";?>leaves/status/<?php echo $leave->id;?>/2/<?php echo $ar->id; ?>"><div class="btn btn-sm btn-danger  btn-xs"><?php echo $textr; ?></div></a><br>


                                                <?php }} ?>




                                        <?php } ?>


                                    </td>


                                    <td >
                                        <?php echo date('d M, Y, h:i A',strtotime($leave->created_at));?>
                                    </td>
                                    <td>

                                        <!--<a href="<?php //echo $url."admin/";?>leaves/status/<?php //echo $leave->id;?>/1"><div class="btn btn-sm btn-success ">Approve</div></a>
                                    <a href="<?php //echo $url."admin/";?>leaves/status/<?php //echo $leave->id;?>/2"><div class="btn btn-sm btn-danger ">Rejected</div></a> -->

                                        <?php
                                        $check = isEmployee();
                                        // echo "Check here: ".var_dump($check);
                                        if(!$check){?>
                                            <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/delete-leave/<?php echo $leave->id;?>"><div class="btn btn-danger btn-circle"><i class="mdi mdi-delete"></i></div></a>
                                        <?php } ?>

                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
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

<script src="../resources/backend/jquery/jquery-3.2.1.min.js"></script>
<script>
    $(function() {
        var data = JSON.parse('<?php echo $ValueOfAllDone; ?>');
        console.log(data);

    });
</script>