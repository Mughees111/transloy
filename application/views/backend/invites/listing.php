<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Parties Invites Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Parties Invites</li>
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
                    <h4 class="card-title">Parties Invites</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Party ID</th>
                                    <th>Party Title</th>
                                    <th>Invited By</th>
                                    <th>Invited User</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                   <th>Party ID</th>
                                    <th>Party Title</th>
                                    <th>Invited By</th>
                                    <th>Invited User</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($invites->result() as $invite){
                                $party = $this->db->where("id",$invite->party_id)->get("parties")->result_object()[0];

                                $by = $this->db->where("id",$invite->invited_by)->get("users")->result_object()[0];
                                $to = $this->db->where("id",$invite->user_id)->get("users")->result_object()[0];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $party->id; ?>
                                </td>
                                <td>
                                    <?php echo $party->name; ?>
                                </td>
                                <td>
                                    <?php echo $by->name; ?>
                                </td>
                                 <td>
                                    <?php echo $to->name; ?>
                                </td>
                                <td>
                                    <?php echo with_currency($invite->amount); ?>
                                </td>
                                 <td>
                                    <?php if($invite->status == 0){?>
                                        <a href="<?php echo $url.'admin/user-status/'.$user->id.'/'.$user->status;?>" ><span class="btn btn-warning">Pending</span></a>
                                    <?php } ?>
                                    <?php if($invite->status == 1){?>
                                        <a href="<?php echo $url.'admin/user-status/'.$user->id.'/'.$user->status;?>" ><span class="btn btn-success">Accepted</span></a>
                                    <?php } ?>

                                    <?php if($invite->status == 2){?>
                                        <a href="<?php echo $url.'admin/user-status/'.$user->id.'/'.$user->status;?>" ><span class="btn btn-danger">Rejected</span></a>
                                    <?php } ?>
                                </td>

                              
                                
                                
                                <td>

                                  
                                    <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/refund-invite/<?php echo $invite->id;?>"><div class="btn btn-info">Refund</div></a>
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