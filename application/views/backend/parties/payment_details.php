<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Participants Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Participants</li>
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
                    <h4 class="card-title">Parties Participants</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Party ID</th>
                                    <th>Party Title</th>
                                    <th>Invited By</th>
                                    <th>Invited User</th>
                                    <th>Amount Paid</th>
                                    <th>Time Required</th>
                                    <th>Time Spent</th>
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
                                    <th>Time Required</th>
                                    <th>Time Spent</th>
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
                                    <?php echo $party->duration; ?>
                                </td>

                                 <td>
                                    <?php 
                                    $time = $this->db->where("party_id",$party->id)->where("user_id",$invite->user_id)->get("party_times")->result_object()[0];

                                    echo $time?($time->seconds/60):"0";
                                    echo " minutes";
                                    ?>
                                </td>
                                 <td>
                                    <?php if($invite->payment_done == 0){?>
                                        <a href="<?php echo $url.'admin/user-status/'.$user->id.'/'.$user->status;?>" ><span class="btn btn-warning">Payment Pending</span></a>
                                    <?php } ?>
                                    <?php if($invite->payment_done == 1){?>
                                        <a href="<?php echo $url.'admin/user-status/'.$user->id.'/'.$user->status;?>" ><span class="btn btn-success">Payment Released (<?php echo with_currency($invite->payment_amount); ?>)</span></a>
                                    <?php } ?>

                                   
                                </td>

                              
                                
                                
                                <td>

                                  
                                    <a href="<?php echo $url;?>admin/parties/refund_one/<?php echo $invite->id;?>"><div class="btn btn-info">Delete & Refund</div></a>

                                    <a href="<?php echo $url;?>admin/parties/release_one/<?php echo $invite->id;?>"><div class="btn btn-info">Release Payment</div></a>


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