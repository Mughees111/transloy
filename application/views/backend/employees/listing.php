<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Employees Management</h4>
        </div>
        <div class="col-md-12 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
                <?php if(!isEmployee()){ ?>
                <a href="<?php echo $url;?>admin/add-employee">
                    <button type="button" class="btn btn-info  d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                </a>
            <?php  } ?>
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
                    <h4 class="card-title">Employees</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>

                                    <th>Name</th>
                                    <th>Job Title</th>
                                    <th>Employee type</th>
                                    <th>Site</th>
                                    <th>Department</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    
                                    <th>Status</th>
                                    <th>Data & Time</th>

                                    <th>Reports</th>
                                    <th>Leaves Allowed</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>

                                    <th>Name</th>
                                    <th>Job Title</th>
                                    <th>Employee Type</th>
                                    <th>Site</th>
                                    <th>Department</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    
                                    <th>Status</th>
                                    <th>Data & Time</th>

                                    <th>Reports</th>
                                    <th>Leaves Allowed</th>

                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($employees as $employee){

                                $site = $this->db->where("id",$employee->site)->get("sites")->result_object()[0];

                                $department = $this->db->where("id",$employee->department)->get("departments")->result_object()[0];
                                ?>
                            <tr>


                                <td>
                                    <?php echo $employee->employee_id; ?>
                                </td>
                                <td>
                                    <?php echo $employee->first_name. ' '.$employee->last_name; ?>
                                </td>
                                
                                <td>
                                    <?php echo $employee->job_title; ?>
                                </td>
                                <td>
                                    <?php $empType = $employee->isOfficeEmployee;
                                        if($empType==1) {echo "Office Employee";}
                                        elseif($empType==0) {echo "Construction Employee";}
                                    ?>
                                </td>
                                <td>
                                    <?php if($employee->site==0) echo "None"; else echo $site->title; ?>
                                </td>
                                <td>
                                    <?php echo $department->title; ?>
                                </td>
                                <td>
                                    <?php echo $employee->email;?>
                                    <a href="mailto:<?php echo $employee->email;?>"><i class="fa fa-envelope"></i></a>
                                </td>
                                 <td>
                                    <?php echo $employee->phone;?>
                                     <a href="tel:<?php echo $employee->phone;?>"><i class="fa fa-phone"></i></a>
                                </td>

                                
                                
                              
                                <td>
                                    <?php if($employee->status == 0){?>
                                        <a href="<?php echo $url.'admin/employee-status/'.$employee->id.'/'.$employee->status;?>" ><span class="btn btn-danger">Inactive</span></a>
                                    <?php }else{?>
                                        <a href="<?php echo $url.'admin/employee-status/'.$employee->id.'/'.$employee->status;?>" ><span class="btn btn-success">Active</span></a>
                                    <?php } ?>
                                </td>


                                <td >
                                    <?php echo date('d M, Y, h:i A',strtotime($employee->created_at));?>
                                </td>

                                <td>

                                    <a href="<?php echo $url."admin/";?>employee-report?employee_id=<?php echo $employee->id;?>"><div class="btn btn-info btn-circle"><i class="fa fa-file-o"></i></div></a>

                                </td>   
                                <td>
                                    <?php echo $employee->leaves; ?>
                                </td>
                                <td>

                                    <a href="<?php echo $url."admin/";?>edit-employee/<?php echo $employee->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-pencil"></i></div></a>



                                    <a title="Change Password" href="<?php echo $url."admin/";?>reset-password-employee/<?php echo $employee->id;?>"><div class="btn btn-info btn-circle"><i class="fa fa-lock"></i></div></a>




                                    <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/delete-employee/<?php echo $employee->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-delete"></i></div></a>

                                    
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