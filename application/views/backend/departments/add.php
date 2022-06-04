<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Departments Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url . "admin"; ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url . "admin/departments"; ?>">Departments</a></li>
                <li class="breadcrumb-item active">Add New Department</li>
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
                    <h4 class="m-b-0 text-white">Information
                    </h4>
                </div>

                <div class="card-body lang_bodieslisting">
                    <?php $input = "title"; ?>
                    <div class="form-group <?= (form_error($input) != '') ? 'error' : ''; ?>">
                        <h5>Title <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="<?php echo $input; ?>" class="form-control form-control-line" placeholder="Title" value="<?php if (set_value($input) != '') {
                                                                                                                                                    echo set_value($input);
                                                                                                                                                } ?>">
                            <div class="text-danger"><?php echo form_error($input); ?></div>
                        </div>
                    </div>
                    <?php $input = "parent"; ?>
                    <div class="form-group <?= (form_error('parent') != '') ? 'error' : ''; ?>">
                        <label for="parent">Select Parent Department: <span class="text-danger">*</span> </label>
                        <select class="custom-select form-control " id="parent" name="<?php echo $input; ?>">
                            <optgroup>
                                <option value="0">Self Parent</option>
                            </optgroup>
                            <optgroup>
                                <?php foreach ($categories->result() as $parent) { ?>
                                    <option <?php if ($parent->id == $this->input->post($input)) {
                                                echo 'selected="selected"';
                                            } ?> value="<?php echo $parent->id; ?>"><?php echo $parent->title; ?></option>
                                <?php } ?>
                            </optgroup>
                        </select>
                        <div class="text-danger"><?php echo form_error($input); ?></div>
                    </div>


                    <div class="form-group ">
                        <h5>Can parent of this department approve the leaves?</h5>
                        <div class="controls ">
                            <div class="switchery-demo m-b-20">
                                <input name="approves_leaves" <?php if ($this->input->post("approves_leaves") == 1) echo "checked"; ?> value="1" type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <h5>Can this department approve the leaves?</h5>
                        <div class="controls ">
                            <div class="switchery-demo m-b-20">
                                <input name="can_approve_leaves" <?php if ($this->input->post("can_approve_leaves") == 1) echo "checked"; ?> value="1" type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <h5>Can this department approve the Allowances?</h5>
                        <div class="controls ">
                            <div class="switchery-demo m-b-20">
                                <input name="can_approve_allowance" <?php if ($this->input->post("can_approve_allowance") == 1) echo "checked"; ?> value="1" type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" />
                            </div>
                        </div>
                    </div>


                    <?php $input = "description"; ?>
                    <div class="form-group <?= (form_error($input) != '') ? 'error' : ''; ?>">
                        <h5>Description </h5>
                        <div class="controls">
                            <textarea class="mymce form-control form-control-line" id="mymce" name="<?php echo $input; ?>"><?php if (set_value($input) != '') {
                                                                                                                                echo set_value($input);
                                                                                                                            } ?></textarea>
                            <div class="text-danger"><?php echo form_error($input); ?></div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?= $url; ?>admin/departments" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>