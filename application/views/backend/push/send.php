<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Push Notification Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/push-notification";?>">Send Push Notification</a></li>
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
            <?=form_open_multipart(base_url()."admin/push-notifications/send",array('class'=>'form-material','novalidate'=>""));?>
            <div class="card">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Push Notification
                    </h4>
                </div>
                <div class="card-body">
                    

                    <div class="form-group <?=(form_error('title') !='')?'error':'';?>">
                        <h5>Title  <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="title" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Title" >
                            <div class="text-danger"><?php echo form_error('title');?></div>
                        </div>
                    </div>


                    <div class="form-group ">
                        <h5>Short Description</h5>
                        <div class="controls">
                            <input type="text" name="short_description" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Short Description" >
                            <div class="text-danger"><?php echo form_error('short_description');?></div>
                        </div>
                    </div>
                    <div class="form-group <?=(form_error('all_users') !='')?'error':'';?>">
                        <div class="controls">
                            <label>
                            <input onclick="checked_or_not(this)" type="checkbox" name="all_users"  value="1" > All Users</label>
                        </div>
                    </div>

                    <?php $sites = $this->db->where('status',1)->where('is_deleted',0)->get("sites")->result_object(); 

                    foreach($sites as $site){
                     ?>
                    
                    <div class="form-group <?=(form_error('all_users') !='')?'error':'';?>">
                        <div class="controls">
                            <label>
                            <input  type="checkbox" name="all_sites[]"  value="<?php echo $site->id; ?>" > <?php  echo $site->title; ?></label>
                        </div>
                    </div>
                    <?php } ?>
                   
                    <div class="form-group ask_users_list">
                        <label for="recipient-name" class="control-label">Users:</label>
                        <select class="select2 m-b-10 select2-multiple" name="users[]" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                            <?php 
                            $drivers = $this->db->where("is_deleted",0)->where("status",1)->get('employees')->result_object();
                            foreach($drivers as $driver){?>
                                <option value="<?php echo $driver->id;?>"><?php echo $driver->first_name .' '.$driver->last_name;?></option>
                            <?php } ?>
                        </select>
                    </div>


                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Send</button>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">History</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Title</th>
                                    <th>Body</th>
                                    <th>Created At</th>
                                    <th>Is Read</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Title</th>
                                    <th>Body</th>
                                    <th>Created At</th>
                                    <th>Is Read</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $pushes = $this->db->order_by("id","DESC")->get("pushes")->result_object();
                             foreach($pushes as $push){
                                $employee =$this->db->where("id",$push->user_id)->get("employees")->result_object()[0];

                           
                            ?>
                            <tr>
                                <td>
                                    <?php echo $push->id; ?>
                                </td>
                                <td>
                                    <?php echo $employee->first_name.' '.$employee->last_name; ?>
                                </td>
                                <td>
                                    <?php echo $push->title; ?>
                                </td>
                                <td>
                                    <?php echo $push->body; ?>
                                </td>
                                <td>
                                    <?php echo $push->created_at; ?>
                                </td>

                                
                              
                                <td>
                                    <?php if($push->read == 0){?>
                                       <span class="btn btn-danger">No</span>
                                    <?php }else{?>
                                        <span class="btn btn-success">Yes</span>
                                    <?php } ?>
                                </td>


                                
                                <td>

                                    <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/push/delete/<?php echo $push->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-delete"></i></div></a>
                                   
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


</div>