<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Teams Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/teams";?>">Teams</a></li>
                <li class="breadcrumb-item active">Add New Team</li>
            </ol>
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
            <?=form_open_multipart('',array('class'=>'form-material','novalidate'=>""));?>
            <div class="card">
                

                
               

                <div class="card-header">
                    <h4 class="m-b-0 text-white">Information
                    </h4>
                </div>
                
                <div class="card-body lang_bodieslisting" >
                    <?php $input = "title"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Title <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="<?php echo $input; ?>" class="form-control form-control-line" placeholder="Title" value="<?php if(set_value($input) != ''){ echo set_value($input);} ?>">
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>

                    <div class="form-group ask_users_list">
                        <label for="recipient-name" class="control-label">Employees(s):</label>
                        <select class="select2 m-b-10 select2-multiple" name="users[]" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                            <?php 
                            $users = $this->db->where("is_deleted",0)->where("status",1)->get('employees')->result_object();
                            foreach($users as $user){?>
                                <option value="<?php echo $user->id;?>"><?php echo  $user->id . ' |  '. $user->first_name. ' '.$user->last_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>






                   
                    <div class="form-group ask_users_list">
                        <label for="recipient-name" class="control-label">Department(s):</label>
                        <select class="select2 m-b-10 select2-multiple" name="departments[]" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                            <?php 
                            $users = $this->db->where("is_deleted",0)->where("status",1)->get('departments')->result_object();
                            foreach($users as $user){?>
                                <option value="<?php echo $user->id;?>"><?php echo  $user->id . ' |  '. $user->title; ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="form-group ask_users_list">
                        <label for="recipient-name" class="control-label">Site(s):</label>
                        <select class="select2 m-b-10 select2-multiple" name="sites[]" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                            <?php 
                            $users = $this->db->where("is_deleted",0)->where("status",1)->get('sites')->result_object();
                            foreach($users as $user){?>
                                <option value="<?php echo $user->id;?>"><?php echo  $user->id . ' |  '. $user->title; ?></option>
                            <?php } ?>
                        </select>
                    </div>



                    <?php $input ="description"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Description </h5>
                        <div class="controls">
                            <textarea class="mymce form-control form-control-line" id="mymce" name="<?php echo $input; ?>" ><?php if(set_value($input) != ''){ echo set_value($input);}?></textarea>
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/teams" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>