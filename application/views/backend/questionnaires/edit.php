
<style>
    .dropify-wrapper .dropify-message p{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Questionnaires Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=$url;?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?=$url;?>admin/questionnaires">Questionnaires</a></li>
                <li class="breadcrumb-item active">Edit Questionnaire</li>
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
            <div class="card ">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Edit questionnaire</h4>
                </div>
                <div class="card-body">

                    <div class="form-group <?=(form_error('title') !='')?'error':'';?>">
                        <h5>Title <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="title" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Title" value="<?php if(set_value('title') != ''){ echo set_value('title');}else{ echo $data->title;}?>" pattern="[a-zA-Z0-9 ]+" data-validation-pattern-message="Only alphabet and numbers are allowed.">
                            <div class="text-danger"><?php echo form_error('title');?></div>
                        </div>

                    </div>


                    <div class="form-group">

                            <h5>Questions: <span class="text-danger">*</span></h5>

                            <?php
                                $array = explode(',', $data->qs);
                            ?>

                            <select required class="select2 m-b-10 select2-multiple form-control-line form-control" name="qs[]" id="qs" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                                <?php foreach($questions as $q){?>
                                    <option <?php if(in_array($q->id,$array)){ echo 'selected="selected"';}?> value="<?php echo $q->id;?>"><?php echo $q->title;?></option>
                                <?php } ?>
                            </select>
                        <div class="text-danger"><?php echo form_error('qs');?></div>

                    </div>
                   
                    <div class="form-group <?=(form_error('description') !='')?'error':'';?>">
                        <h5>Description </h5>
                        <div class="controls">
                            <textarea class="mymce form-control form-control-line" id="mymce" name="description" ><?php if(set_value('description') != ''){ echo set_value('description');}else{ echo $data->description;}?></textarea>
                            <div class="text-danger"><?php echo form_error('description');?></div>
                        </div>
                    </div>
                   

                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/questionnaires" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>