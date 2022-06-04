<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Employees Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/employees";?>">Employees</a></li>
                <li class="breadcrumb-item active">Edit Employee</li>
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
                            <div class="form-group <?=(form_error('first_name') !='')?'error':'';?>">
                                <h5>First Name: <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="first_name" class="form-control" required data-validation-required-message="This field is required" placeholder="First Name" value="<?php if(set_value('first_name') != ''){ echo set_value('first_name');}else echo $data->first_name;?>" >
                                    <div class="text-danger"><?php echo form_error('first_name');?></div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('last_name') !='')?'error':'';?>">
                                <h5>Last Name: <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="last_name" class="form-control" required data-validation-required-message="This field is required" placeholder="Last Name" value="<?php if(set_value('last_name') != ''){ echo set_value('last_name');}else echo $data->last_name;?>" >
                                    <div class="text-danger"><?php echo form_error('last_name');?></div>
                                </div>

                            </div>
                        </div>
                        
                    </div>


                     <div class="row">
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('employee_id') !='')?'error':'';?>">
                                <h5>Employee ID : <span class="text-danger">*</span> <small>Must be unique to this employee</small></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Employee ID" required data-validation-required-message="This field is required" name="employee_id" value="<?php if(set_value('employee_id') != ''){ echo set_value('employee_id');}else echo $data->employee_id;?>">
                                    <div class="text-danger"><?php echo form_error('employee_id');?></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('job_title') !='')?'error':'';?>">
                                <h5>Job Title : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Job Title" required data-validation-required-message="This field is required" name="job_title" value="<?php if(set_value('job_title') != ''){ echo set_value('job_title');}else echo $data->job_title;?>">
                                    <div class="text-danger"><?php echo form_error('job_title');?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('email') !='')?'error':'';?>">
                                <h5>Email : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Email Address" data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})" data-validation-regex-message="Please enter the valid email address." required data-validation-required-message="This field is required" name="email" value="<?php if(set_value('email') != ''){ echo set_value('email');}else echo $data->email;?>">
                                    <div class="text-danger"><?php echo form_error('email');?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('phone') !='')?'error':'';?>">
                                <h5>Phone : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Phone" required data-validation-required-message="This field is required" name="phone" value="<?php if(set_value('phone') != ''){ echo set_value('phone');}else echo $data->phone;?>">
                                    <div class="text-danger"><?php echo form_error('phone');?></div>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('leaves') !='')?'error':'';?>">
                                <h5>Annualy Allowed Leaves : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="number" step="1" min="0" max="365" class="form-control" placeholder="leaves" required data-validation-required-message="This field is required and should be in between 0-365" name="leaves" value="<?php if(set_value('leaves') != ''){ echo set_value('leaves');}else echo $data->leaves;?>">
                                    <div class="text-danger"><?php echo form_error('leaves');?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?=(form_error('petrolcode') !='')?'error':'';?>">
                                <h5>Petrol Code : <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="petrolcode">
                                    <option <?php if($data->petrolcode==0){ echo 'selected="selected"';}?>value="0">Code N (Unlimited)</option>
                                    <option <?php if($data->petrolcode==1){ echo 'selected="selected"';}?>value="1">Code Y (RM 200-250)</option>
                                    <option <?php if($data->petrolcode==2){ echo 'selected="selected"';}?>value="2">Code Z (RM 300)</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <?php $input = "department"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <label for="department">Select Department: <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">
                                    <option value="0" >None</option>
                                       <?php 
                                       $departments = $this->db->where("status",1)->where("is_deleted",0)->get("departments")->result_object();
                                       foreach($departments as $department){
                                        ?>
                                             <option <?php if($department->id == $this->input->post($input) || $data->department==$department->id){ echo 'selected="selected"';}?>  value="<?php echo $department->id;?>"><?php echo $department->title;?></option>
                                        <?php } ?>
                                </select>
                                <div class="text-danger"><?php echo form_error($input);?></div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <?php $input = "site"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <label for="site">Select Construction Site: <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">
                                    <option value="0" <?php if(0 == $this->input->post($input) || $data->site==0){ echo 'selected="selected"';}?> >None</option>
                                       <?php 
                                       $sites = $this->db->where("status",1)->where("is_deleted",0)->order_by("ord","ASC")->get("sites")->result_object();
                                       foreach($sites as $site){
                                        ?>
                                             <option <?php if($site->id == $this->input->post($input) || $data->site==$site->id){ echo 'selected="selected"';}?>  value="<?php echo $site->id;?>"><?php echo $site->title;?></option>
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
                    <a href="<?=$url;?>admin/employees" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>