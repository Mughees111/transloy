<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Allowance Management</h4>
        </div>
        <div class="col-md-12 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Allowances</li>
                </ol>
<!--                <a href="--><?php //echo $url;?><!--admin/add-employee">-->
<!--                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>-->
<!--                </a>-->
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
                    <h4 class="card-title">Allowance Management</h4>

                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>By</th>
                                <th>Site</th>
                                <th>Claims</th>
                                <th>Files</th>
                                <th>Applied Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date & Time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>By</th>
                                <th>Site</th>
                                <th>Claims</th>
                                <th>Files</th>
                                <th>Applied Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date & Time</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($data as $row){

                                $user = $this->db->where('id',$row->empId)
                                    ->get('employees')
                                    ->result_object()[0];

                                $site = $this->db->where('id',$user->site)
                                    ->get('sites')
                                    ->result_object()[0];

                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row->id;?>
                                    </td>
                                    <td>
                                        <?php echo $user->first_name . " ".$user->last_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $site->title; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->claims ?>
                                    </td>
                                    <td>
                                    <?php
                                        $files = $this->db->where("pc_form_id", $row->id)->get('pettycash_form_files')->result_object();
                                        foreach($files as $file)
                                        {
                                            ?>
                                            <a style="margin-top: 10px; float: left;" href="<?php echo base_url()."resources/uploads/docs/".$file->data_string; ?>" download ><span class="btn btn-info btn-sm"><?php echo $file->data_title; ?></span></a>
                                            <br>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date('d M, Y',strtotime($row->appliedDate));?>
                                    </td>
                                    <td>
                                        <?php echo "RM " . $row->totalAmount; ?>
                                    </td>
                                    <td>
                                        <?php  if($row->status == 0){
                                                 echo " Pending";
                                                }
                                                else{
                                                    $actionText = $row->status == 1 ? "Approved by " : "Rejected by ";
                                                    if($row->approvedBy == 0)
                                                    {
                                                        $actionText = $actionText . "Admin"; 

                                                    }else
                                                    {
                                                        $actionBy = $this->db->where('id',$row->approvedBy)
                                                                    ->get('employees')
                                                                    ->result_object()[0];
                                                        $actionByName =  $actionBy->first_name . " ". $actionBy->last_name;
                                                        $actionByDep  =  $this->db->where('id',$actionBy->department)
                                                                    ->get('departments')
                                                                    ->result_object()[0]->title;

                                                        $actionText = $actionText . $actionByDep. " ".$actionByName;             

                                                    }
                                                   echo $actionText;
                                                }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($row->actionDate != null)echo date('d M, Y, h:i A',strtotime($row->actionDate));?>
                                    </td>
                                    <td>
                                        <?php if($row->status == 0) { ?>
                                            <a style=" margin-top: 10px;float: left;" href="<?php echo $url."admin/";?>pettycash/status/<?php echo $row->id;?>/1"><div style="width: 100px;" class="btn btn-sm btn-success"><?php echo "Approve"; ?></div></a><br>
                                            <a style=" margin-top: 10px;float: left;" href="<?php echo $url."admin/";?>pettycash/status/<?php echo $row->id;?>/2"><div style="width: 100px;" class="btn btn-sm btn-danger"><?php echo "Reject"; ?></div></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
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