<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Parties Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Parties</li>
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
                    <h4 class="card-title">Parties</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    
                                    <th>Type</th>
                                    <th>Starts At</th>
                                    <th>Duration</th>
                                    <th>User</th>
                                    <th>Invited</th>
                                    <th>Created At</th>
                                    <th>Participants</th>
                                    <th>Relase All Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    
                                    <th>Type</th>
                                    <th>Starts At</th>
                                    <th>Duration</th>
                                    <th>User</th>
                                    <th>Invited</th>
                                    <th>Created At</th>
                                    <th>Participants</th>
                                    <th>Relase All Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($parties->result() as $party){
                            ?>
                            <tr>
                                <td>
                                    <?php echo $party->id; ?>
                                </td>
                                 <td>
                                    <?php echo $party->name; ?>
                                </td>
                                <td>
                                    <?php echo $party->type; ?>
                                </td>
                                <td>
                                    <?php echo date("F d, Y H:i A",$party->date_time); ?>
                                </td>
                                <td>
                                    <?php echo $party->duration; ?>
                                </td>
                                <td>
                                    <?php
                                    $user = $this->db->where("id",$party->user_id)->get("users")->result_object()[0];
                                    echo $user->name; ?>
                                </td>
                                <td>
                                    <?php
                                    $invited = $this->db->where("party_id",$party->id)->get("party_invites")->result_object();

                                    foreach($invited as $party_invite)
                                    {
                                        $user = $this->db->where("id",$party_invite->user_id)->get("users")->result_object()[0];
                                        echo $user->name; 
                                        echo "<br>";
                                    }

                                        echo empty($invited)?"--":"";
                                     
                                    ?>
                                </td>
                                <td >
                            		<?php echo date('d M, Y, h:i A',strtotime($party->created_at));?>
                            	</td>

                                <td>
                                    <?php
                                    $invited = $this->db->where("party_id",$party->id)->where("status",1)->get("party_invites")->result_object();

                                    foreach($invited as $party_invite)
                                    {
                                        $user = $this->db->where("id",$party_invite->user_id)->get("users")->result_object()[0];
                                        echo '<span class="btn btn-xs btn-'.($party_invite->payment_done==1?"success":"warning").'"> Name: '.$user->name.', Payment: '.($party_invite->payment_done==1?"Done":"Pending").'</span>'; 
                                        echo "<br>";
                                    }

                                        echo empty($invited)?"--":"";
                                     
                                    ?>

                                     <a href="<?php echo $url."admin/";?>parties/payment_details/<?php echo $party->id;?>"><div class="btn btn-info btn-sm">View Details</div></a>
                                </td>
                                <td>

                                    <a href="<?php echo $url."admin/";?>parties/release_all/<?php echo $party->id;?>"><div class="btn btn-info btn-sm">Release All Payments</div></a>

                                </td>
                                <td>

                                    <a href="<?php echo $url."admin/";?>party-details/<?php echo $party->id;?>"><div class="btn btn-info btn-circle"><i class="fa fa-tv"></i></div></a>

                                    <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/delete-party/<?php echo $party->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-delete"></i></div></a>
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
<style type="text/css">
    span{
        margin-bottom: 5px;
    }
</style>