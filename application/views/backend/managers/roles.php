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
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Managers Roles Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=$url;?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?=$url;?>admin/admins">Admins</a></li>
                <li class="breadcrumb-item active">Edit Manager Roles</li>
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
                    <h4 class="m-b-0 text-white">Edit Manager Roles</h4>
                </div>
                <div class="card-body">
                    <div class="row">

                        <?php


                        $this_roles = array(-495);
                        foreach($roles as $role)
                            $this_roles[]=$role->role;

                        $_roles = get_all_roles();
                        foreach($_roles as $key=>$role)
                        {

                        ?>
                        <div class="col-3">
                            <div class="form-group" style="width: 100%; clear: both;">
                                <div class="controls">
                                    <input type="checkbox" <?php echo in_array($key,$this_roles)?'checked':''; ?> id="roles<?php echo $key; ?>" name="roles[]" data-checkbox="icheckbox_flat-red" value="<?php echo $key; ?>">
                                    <label for="roles<?php echo $key; ?>"><?php echo $role; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/admins" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>