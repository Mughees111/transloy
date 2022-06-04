<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Sites Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sites</li>
                </ol>
                <a href="<?php echo $url;?>admin/add-site">
                    <button type="button" class="btn btn-info  d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                </a>
                <a href="<?php echo $url;?>admin/site-display-order">
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-bars"></i> Change Display Order</button>
                </a>
            </div>
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
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sites</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Data & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Data & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($sites->result() as $site){

                                

                            ?>
                            <tr>
                                <td>
                                    <?php echo $site->title;?>
                                </td>

                                <td>
                                    <?php echo $site->address;?>
                                </td>
                               
                            	<td>
                            		<?php if($site->status == 0){?>
                                        <a href="<?php echo $url.'admin/site-status/'.$site->id.'/'.$site->status;?>" ><span class="btn btn-danger">Inactive</span></a>
                            		<?php }else{?>
                                        <a href="<?php echo $url.'admin/site-status/'.$site->id.'/'.$site->status;?>" ><span class="btn btn-success">Active</span></a>
                            		<?php } ?>
                            	</td>


                            	<td >
                            		<?php echo date('d M, Y, h:i A',strtotime($site->created_at));?>
                            	</td>
                                <td>

                                    <a href="<?php echo $url."admin/";?>edit-site/<?php echo $site->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-pencil"></i></div></a>
                                    <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/delete-site/<?php echo $site->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-delete"></i></div></a>

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
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>