<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Employees Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url . "admin"; ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url . "admin/employees"; ?>">Employees</a></li>
                <li class="breadcrumb-item active">Add New Employee</li>
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
            <?= form_open_multipart('', array('class' => 'form-material', 'novalidate' => "")); ?>
            <div class="card">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('first_name') != '') ? 'error' : ''; ?>">
                                <h5>First Name: <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="first_name" class="form-control" required data-validation-required-message="This field is required" placeholder="First Name" value="<?php if (set_value('first_name') != '') {
                                                                                                                                                                                                        echo set_value('first_name');
                                                                                                                                                                                                    } else echo $prev->first_name; ?>">
                                    <div class="text-danger"><?php echo form_error('first_name'); ?></div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('last_name') != '') ? 'error' : ''; ?>">
                                <h5>Last Name: <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="last_name" class="form-control" required data-validation-required-message="This field is required" placeholder="Last Name" value="<?php if (set_value('last_name') != '') {
                                                                                                                                                                                                    echo set_value('last_name');
                                                                                                                                                                                                } else echo $prev->last_name; ?>">
                                    <div class="text-danger"><?php echo form_error('last_name'); ?></div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('employee_id') != '') ? 'error' : ''; ?>">
                                <h5>Employee ID : <span class="text-danger">*</span> <small>Must be unique to this employee</small></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Employee ID" required data-validation-required-message="This field is required" name="employee_id" value="<?php if (set_value('employee_id') != '') {
                                                                                                                                                                                                        echo set_value('employee_id');
                                                                                                                                                                                                    } else echo $prev->employee_id; ?>">
                                    <div class="text-danger"><?php echo form_error('employee_id'); ?></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('job_title') != '') ? 'error' : ''; ?>">
                                <h5>Job Title : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Job Title" required data-validation-required-message="This field is required" name="job_title" value="<?php if (set_value('job_title') != '') {
                                                                                                                                                                                                    echo set_value('job_title');
                                                                                                                                                                                                } else echo $prev->job_title; ?>">
                                    <div class="text-danger"><?php echo form_error('job_title'); ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('email') != '') ? 'error' : ''; ?>">
                                <h5>Email : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" autocomplete="new-email" class="form-control" placeholder="Email Address" data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})" data-validation-regex-message="Please enter the valid email address." required data-validation-required-message="This field is required" name="email" value="<?php if (set_value('email') != '') {
                                                                                                                                                                                                                                                                                                                                                                                echo set_value('email');
                                                                                                                                                                                                                                                                                                                                                                            } else echo $prev->email; ?>">
                                    <div class="text-danger"><?php echo form_error('email'); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('phone') != '') ? 'error' : ''; ?>">
                                <h5>Phone : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Phone" required data-validation-required-message="This field is required" name="phone" value="<?php if (set_value('phone') != '') {
                                                                                                                                                                                            echo set_value('phone');
                                                                                                                                                                                        } else echo $prev->phone; ?>">
                                    <div class="text-danger"><?php echo form_error('phone'); ?></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('experience') != '') ? 'error' : ''; ?>">
                                <h5>Employee Experience : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input 
                                        type="number" 
                                        step="1" 
                                        min="0"
                                        class="form-control" 
                                        placeholder="experience" 
                                        required data-validation-required-message="This field is required" 
                                        name="experience" 
                                        value="<?php if (set_value('experience') != '') {echo set_value('experience');} else echo $prev->experience; ?>">
                                    <div class="text-danger"><?php echo form_error('leaves'); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('leaves') != '') ? 'error' : ''; ?>">
                                <h5>Annualy Allowed Leaves : <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input 
                                        type="number" 
                                        step="1" 
                                        min="0" 
                                        max="365" 
                                        class="form-control" 
                                        placeholder="leaves" 
                                        required data-validation-required-message="This field is required and should be in between 0-365" 
                                        name="leaves" 
                                        onblur="set_experiece()"
                                        value="<?php if (set_value('leaves') != '') {
                                                                            echo set_value('leaves');
                                                                                } 
                                                                                
                                                                                    else echo $prev->leaves; ?>">
                                    <div class="text-danger"><?php echo form_error('leaves'); ?></div>
                                </div>
                            </div>
                        </div> -->


                        <div class="col-lg-6 col-md-6">
                            <div class="form-group <?= (form_error('password') != '') ? 'error' : ''; ?>">
                                <h5>Password : <span class="text-danger">*</span></h5>
                                <div class="controls">

                                    <input type="password" id="inputPassword" autocomplete="new-password" class="form-control" placeholder="Password" required data-validation-required-message="This field is required" name="password" data-validation-regex-regex="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$" data-validation-regex-message="password must contain at least eight characters, at least one number and both lower and uppercase letters" value="<?php if (set_value('password') != '') {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo set_value('password');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else echo $prev->password; ?>">
                                    <div class="small" style="margin-top: 5px">
                                        <input type="checkbox" id="showPassword"> Show Password
                                    </div>

                                    <div class="text-danger"><?php echo form_error('password'); ?></div>
                                </div>
                                <div class="small">

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <?php $input = "department"; ?>
                            <div class="form-group <?= (form_error($input) != '') ? 'error' : ''; ?>">
                                <label for="department">Select Department: <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">
                                    <?php
                                    $departments = $this->db->where("status", 1)->where("is_deleted", 0)->get("departments")->result_object();
                                    foreach ($departments as $department) {
                                    ?>
                                        <option <?php if ($department->id == $this->input->post($input) || $prev->department == $department->id) {
                                                    echo 'selected="selected"';
                                                } ?> value="<?php echo $department->id; ?>"><?php echo $department->title; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="text-danger"><?php echo form_error($input); ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <?php $input = "isOfficeEmployee"; ?>
                            <div class="form-group <?= (form_error($input) != '') ? 'error' : ''; ?>">
                                <label for="isOfficeEmployee">Select Employee Type: <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>" id="<?php echo $input; ?>">
                                    <option value="0">Construction Employee</option>
                                    <option value="1">Office Employee</option>
                                </select>
                                <div class="text-danger"><?php echo form_error($input); ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <?php $input = "petrolcode"; ?>
                            <div class="form-group <?= (form_error($input) != '') ? 'error' : ''; ?>">
                                <label for="petrolcode">Select Petrol Code: <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>" id="<?php echo $input; ?>">
                                    <option value="0">Code N (Unlimited)</option>
                                    <option value="1">Code Y (RM 200-250)</option>
                                    <option value="2">Code Z (RM 300)</option>
                                </select>
                                <div class="text-danger"><?php echo form_error($input); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="divForConstructionEmployee">
                        <div class="col-6">
                            <?php $input = "site"; ?>
                            <div class="form-group <?= (form_error($input) != '') ? 'error' : ''; ?>">
                                <label for="site">Select Construction Site: <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">
                                    <option value="0">None</option>
                                    <?php
                                    $sites = $this->db->where("status", 1)->where("is_deleted", 0)->order_by("ord", "ASC")->get("sites")->result_object();
                                    foreach ($sites as $site) {
                                    ?>
                                        <option <?php if ($site->id == $this->input->post($input) || $prev->site == $site->id) {
                                                    echo 'selected="selected"';
                                                } ?> value="<?php echo $site->id; ?>"><?php echo $site->title; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="text-danger"><?php echo form_error($input); ?></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?= $url; ?>admin/employees" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>
<script src="../resources/backend/jquery/jquery-3.2.1.min.js"></script>
<script>
    $("body").on('click', '#showPassword', function() {


        var input = $("#inputPassword").attr("type");

        if ($("#inputPassword").attr("type") === "password") {
            $("#inputPassword").attr("type", "text");
        } else {
            $("#inputPassword").attr("type", "password");
        }
    });

    // function set_experiece(){
        // alert('asd');
        // var experience = '<?php echo $this->input->post('experience'); ?>';
        
        // if ($experince <= 2 ) {echo "8";} 
        // else if ($experince<=5 && $experince >2) {echo "12";} 
        // else if($experince>5) {echo "16";}
                                                                                
    // }
    
    
</script>