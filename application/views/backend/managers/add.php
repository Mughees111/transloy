<?php

 ?>

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Managers Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=$url;?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?=$url;?>admin/Managers">Managers</a></li>
                <li class="breadcrumb-item active">Add New Manager</li>
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
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Add New Manager
                       
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('fname') !='')?'error':'';?>">
                                <h5>Name : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="fname" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Name" value="<?php if(set_value('fname') != ''){ echo set_value('fname');}else echo $prev->name;?>" >
                                    <div class="text-danger"><?php echo form_error('fname');?></div>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('email') !='')?'error':'';?>">
                                <h5>Email : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" class="form-control form-control-line" placeholder="Email Address" data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})" data-validation-regex-message="Please enter the valid email address." required data-validation-required-message="This field is required" name="email" value="<?php if(set_value('email') != ''){ echo set_value('email');}else echo $prev->email; ?>">
                                    <div class="text-danger"><?php echo form_error('email');?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('password') !='')?'error':'';?>">
                                <h5>Password : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="password" class="form-control form-control-line" placeholder="*****"  required data-validation-required-message="This field is required" name="password" >
                                    <div class="text-danger"><?php echo form_error('password');?></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <?php $input = "site"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <label for="site">Select Construction Site: <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">
                                       <?php 
                                       $sites = $this->db->where("status",1)->where("is_deleted",0)->order_by("ord","ASC")->get("sites")->result_object();
                                       foreach($sites as $site){
                                        ?>
                                             <option <?php if($site->id == $this->input->post($input) || $prev->site==$site->id){ echo 'selected="selected"';}?>  value="<?php echo $site->id;?>"><?php echo $site->title;?></option>
                                        <?php } ?>
                                </select>
                                <div class="text-danger"><?php echo form_error($input);?></div>
                            </div>
                        </div>
                    </div>

                   


                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/managers" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>