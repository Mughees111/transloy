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
                    <h4 class="card-title">Party Details</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            
                            <tbody>
                            
                            <tr>
                                <th>
                                    Party Name
                                </th>
                                <td>
                                    <?php echo $party->name; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Party Type
                                </th>
                                <td>
                                    <?php echo $party->type; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Party Starts At
                                </th>
                                <td>
                                    <?php echo date("F d, Y H:i A",$party->date_time); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Party Duration
                                </th>
                                <td>
                                    <?php echo $party->duration; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Party Host
                                </th>
                                <td>
                                     <?php
                                    $user = $this->db->where("id",$party->user_id)->get("users")->result_object()[0];
                                    echo $user->name; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Invited People
                                </th>
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
                            </tr>
                            <tr>
                                <th>
                                    Party Description
                                </th>
                                <td>
                                    <?php echo $party->description; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Party Image
                                </th>
                                <td>
                                    <img src="<?php echo base_url()."resources/uploads/parties/".$party->image; ?>" style="width: 100px;" />
                                </td>
                            </tr>
                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Party Invited People</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                            <thead>
                                <th>Name</th>
                                <th>Payment Selected</th>
                                <th>Status</th>
                            </thead>
                            
                            <tbody>
                            <?php
                            $invited = $this->db->where("party_id",$party->id)->get("party_invites")->result_object();

                                    foreach($invited as $party_invite)
                                    {
                                        $user = $this->db->where("id",$party_invite->user_id)->get("users")->result_object()[0];

                             ?>
                            <tr>
                                
                                <td>
                                    <?php echo $user->name; ?>
                                </td>
                                <td>
                                    <?php echo with_currency($party_invite->amount); ?>
                                </td>


                                <td>
                                    <?php
                                    if($party_invite->status==0)
                                    {
                                     ?>
                                     <span class="btn btn-warning">Pending</span>
                                    <?php } ?>

                                    <?php
                                    if($party_invite->status==1)
                                    {
                                     ?>
                                     <span class="btn btn-success">Approved</span>

                                    <?php } ?>

                                    <?php
                                    if($party_invite->status==2)
                                    {
                                     ?>
                                     <span class="btn btn-danger">Rejected</span>

                                    <?php } ?>
                                </td>
                            </tr>

                        <?php } ?>
                          
                           
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