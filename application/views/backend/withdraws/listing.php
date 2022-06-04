<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Withdraw Requests Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Withdraw Requests</li>
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
                    <h4 class="card-title">Withdraw Requests</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>By (User)</th>
                                    <th>Amount</th>
                                    <th>Details</th>
                                
                                    <th>Status</th>
                                    <th>At</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>By</th>
                                    <th>Amount</th>
                                    <th>Details</th>
                                
                                    <th>Status</th>
                                    <th>At</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($withdraws->result() as $withdraw){

                                $driver = $this->db->where("id",$withdraw->user_id)->get("users")->result_object()[0];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $driver->name;?>
                                </td>
                                <td>
                                    <?php echo with_currency($withdraw->amount);?>
                                </td>
                                <td>
                                    PayPal:<br>
                                    <?php echo $withdraw->email;?><br>
                                    
                                </td>
                                
                            
                            	<td>
                                    <?php if($withdraw->status == 0){?>
                                        Pending
                                    <?php } else if($withdraw->status == 1){?>
                                        Approved

                            		<?php } elseif($withdraw->status == 2){?>
                                        Rejected

                                    <?php } ?>

                                    <?php if($withdraw->status == 0){?>
                                        <a href="<?php echo $url.'admin/withdraw-status/'.$withdraw->id.'/2';?>" ><span class="btn btn-xs btn-danger">Reject</span></a>
                                        <a href="<?php echo $url.'admin/withdraw-status/'.$withdraw->id.'/1';?>" ><span class="btn  btn-xs btn-success">Approve</span></a>
                            		<?php } ?>
                            	</td>

                            	<td >
                            		<?php echo date('d M, Y, h:i A',strtotime($withdraw->at));?>
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