<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Employees Trash Management</h4>
        </div>
        <div class="col-md-12 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin/employees";?>">Employees</a></li>
                    <li class="breadcrumb-item active">Employees Trash</li>
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
                    <h4 class="card-title">Employees</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                      <th>Name</th>
                                    <th>Email</th>
                                  
                                    
                                    
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                      <th>Name</th>
                                    <th>Email</th>
                                   
                                    
                                    
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($employees->result() as $employee){?>
                            <tr>
                                <td>
                                    <?php echo $employee->name;?>
                                </td>
                                <td>
                                    <?php echo $employee->email;?>
                                </td>
                                <td>
                                     <a title="Restore" href="<?php echo $url;?>admin/restore-employee/<?php echo $employee->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-file-restore"></i></div></a>

                                     <a title="Delete Permanently" href="<?php echo $url;?>admin/employees/d_p/<?php echo $employee->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-delete"></i></div></a>
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