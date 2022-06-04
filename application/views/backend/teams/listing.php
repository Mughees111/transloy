<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Teams Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Teams</li>
                </ol>
                <a href="<?php echo $url;?>admin/add-team">
                    <button type="button" class="btn btn-info  d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                </a>
               
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
                    <h4 class="card-title">Teams</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Users</th>
                                    <th>Departments</th>
                                    <th>Sites</th>
                                    <th>Status</th>
                                    <th>Data & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Users</th>
                                    <th>Departments</th>
                                    <th>Sites</th>
                                    <th>Status</th>
                                    <th>Data & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($teams->result() as $team){

                                 $team_users = $this->db->where("team_id",$team->id)->get("team_users")->result_object();
                                 $team_deps = $this->db->where("team_id",$team->id)->get("team_departments")->result_object();
                                 $team_sites = $this->db->where("team_id",$team->id)->get("team_sites")->result_object();

                            ?>
                            <tr>
                                <td>
                                    <?php echo $team->id;?>
                                </td>
                                  <td>
                                    <?php echo $team->title;?>
                                </td>

                                 <td>
                                <?php foreach($team_users as $team_user) 
                                    {

                                        $user = $this->db->where("id",$team_user->user_id)->where("status",1)->where("is_deleted",0)->get("employees")->result_object()[0];

                                        echo "<span style='margin-bottom:5px; margin-right:5px' class='btn btn-xs btn-info'>".$user->id.' | '. $user->first_name. ' '.$user->last_name. "</span>";
                                    }


                                     ?>
                               </td>

                                 <td>
                                <?php foreach($team_deps as $team_user) 
                                    {

                                        $user = $this->db->where("id",$team_user->department_id)->where("status",1)->where("is_deleted",0)->get("departments")->result_object()[0];

                                        echo "<span style='margin-bottom:5px; margin-right:5px' class='btn btn-xs btn-info'>".$user->id.' | '. $user->title. "</span>";
                                    }


                                     ?>
                               </td>
                               <td>
                                <?php foreach($team_sites as $team_user) 
                                    {

                                        $user = $this->db->where("id",$team_user->site_id)->where("status",1)->where("is_deleted",0)->get("sites")->result_object()[0];

                                        echo "<span style='margin-bottom:5px; margin-right:5px' class='btn btn-xs btn-info'>".$user->id.' | '. $user->title. "</span>";
                                    }


                                     ?>
                               </td>
                                
                            	<td>
                            		<?php if($team->status == 0){?>
                                        <a href="<?php echo $url.'admin/team-status/'.$team->id.'/'.$team->status;?>" ><span class="btn btn-danger">Inactive</span></a>
                            		<?php }else{?>
                                        <a href="<?php echo $url.'admin/team-status/'.$team->id.'/'.$team->status;?>" ><span class="btn btn-success">Active</span></a>
                            		<?php } ?>
                            	</td>


                            	<td >
                            		<?php echo date('d M, Y, h:i A',strtotime($team->created_at));?>
                            	</td>
                                <td>

                                    <a href="<?php echo $url."admin/";?>edit-team/<?php echo $team->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-pencil"></i></div></a>
                                    <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/delete-team/<?php echo $team->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-delete"></i></div></a>

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