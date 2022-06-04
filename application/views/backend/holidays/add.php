<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Holidays Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/holidays";?>">Holidays</a></li>
                <li class="breadcrumb-item active">Add New Holiday</li>
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
                 
                 <div class="card-body lang_bodieslisting">
                    
                    <?php $input = "title"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Title <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Title" value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $prev->title;?>" >
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>

                    </div>


                    <?php $input = "notif_title"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Notification Title  <small>max 70 chars</small> <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text"  maxlength="70" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Title" value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $prev->notif_title;?>" >
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>

                    </div>


                    <?php $input = "notif_description"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Notification Description <small>max 70 chars</small> <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input maxlength="70" type="text" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Title" value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $prev->notif_description;?>" >
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>

                    </div>


                    <div class="form-group <?=(form_error("recurrent") !='')?'error':'';?>">
                        <h5>Recurrent Weekly <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="recurrent" >
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group <?=(form_error("monthly") !='')?'error':'';?>">
                        <h5>Recurrent Monthly <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="monthly" >
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group <?=(form_error("yearly") !='')?'error':'';?>">
                        <h5>Recurrent Yearly <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="yearly" >
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                    </div>


                    <?php $input = "date"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Holiday Date (Or Day) <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="date" name="date" required>
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/holidays" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>