<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Users Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/users";?>">Users</a></li>
                <li class="breadcrumb-item active">Add New User</li>
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
                    <h4 class="m-b-0 text-white">Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('name') !='')?'error':'';?>">
                                <h5>Name : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="name" class="form-control" required data-validation-required-message="This field is required" placeholder="Name" value="<?php if(set_value('name') != ''){ echo set_value('name');}else echo $prev->name;?>" pattern="[a-zA-Z0-9 ]+" data-validation-pattern-message="Only alphabet and numbers are allowed.">
                                    <div class="text-danger"><?php echo form_error('name');?></div>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('email') !='')?'error':'';?>">
                                <h5>Email : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Email Address" data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})" data-validation-regex-message="Please enter the valid email address." required data-validation-required-message="This field is required" name="email" value="<?php if(set_value('email') != ''){ echo set_value('email');}else echo $prev->email;?>">
                                    <div class="text-danger"><?php echo form_error('email');?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('name') !='')?'error':'';?>">
                                <h5>5 Mins Price : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="number" step=1 name="amount_1" class="form-control" required data-validation-required-message="This field is required" placeholder="<?php echo get_currency(); ?>" value="<?php if(set_value('amount_1') != ''){ echo set_value('amount_1');}else echo $prev->amount_1;?>" >
                                    <div class="text-danger"><?php echo form_error('amount_1');?></div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('amount_2') !='')?'error':'';?>">
                                <h5>15 Mins Price : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="number" step=1 name="amount_2" class="form-control" required data-validation-required-message="This field is required" placeholder="<?php echo get_currency(); ?>" value="<?php if(set_value('amount_2') != ''){ echo set_value('amount_2');}else echo $prev->amount_2;?>" >
                                    <div class="text-danger"><?php echo form_error('amount_2');?></div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('amount_3') !='')?'error':'';?>">
                                <h5>30 Mins Price : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="number" step=1 name="amount_3" class="form-control" required data-validation-required-message="This field is required" placeholder="<?php echo get_currency(); ?>" value="<?php if(set_value('amount_3') != ''){ echo set_value('amount_3');}else echo $prev->amount_3;?>" >
                                    <div class="text-danger"><?php echo form_error('amount_3');?></div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('amount_4') !='')?'error':'';?>">
                                <h5>60 Mins Price : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="number" step=1 name="amount_4" class="form-control" required data-validation-required-message="This field is required" placeholder="<?php echo get_currency(); ?>" value="<?php if(set_value('amount_4') != ''){ echo set_value('amount_4');}else echo $prev->amount_4;?>" >
                                    <div class="text-danger"><?php echo form_error('amount_4');?></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/users" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>