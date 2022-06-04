<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Holidays Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Holidays</li>
                </ol>
                <a href="<?php echo $url;?>admin/add-holiday">
                    <button type="button" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
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
                    <h4 class="card-title">Holidays</h4>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body b-l calender-sidebar">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
          
        </div>
    </div>


     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    
                    <h4 class="card-title">Recurrent Holidays</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Notification Title</th>
                                    <th>Notification Description</th>
                                    <th>Day/Date</th>
                                    <th>Recurrent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Notification Title</th>
                                    <th>Notification Description</th>
                                    <th>Day/Date</th>
                                    <th>Recurrent</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($holidays->result() as $holiday){


                            ?>
                            <tr>
                                <td>
                                    <?php echo $holiday->title;?>
                                </td>

                                <td>
                                    <?php echo $holiday->notif_title;?>
                                </td>

                                 <td>
                                    <?php echo $holiday->notif_description;?>
                                </td>


                                 <td>
                                    <?php if($holiday->recurrent==0)

                                    {
                                        echo date("F d, Y",strtotime($holiday->date));
                                    }
                                    else{
                                        echo date("l",strtotime($holiday->date));
                                    }

                                     ?>
                                </td>

                                <td>
                                    <?php 
                                    if($holiday->recurrent==1)
                                    {
                                        echo "Weekly";
                                    }
                                    elseif($holiday->monthly==1)
                                    {
                                        echo "Monthly";
                                    }
                                    elseif($holiday->yearly==1)
                                    {
                                        echo "Yearly";
                                    }
                                    else echo "No";
                                    

                                     ?>
                                </td>
                                
                                <td>

                                
                                    <a class="deleted" href="javascript:void(0);" data-url="<?php echo $url;?>admin/delete-holiday/<?php echo $holiday->id;?>"><div class="btn btn-info btn-circle"><i class="mdi mdi-delete"></i></div></a>
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

 <!-- BEGIN MODAL -->
    <div class="modal none-border" id="my-event">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <strong>Add Event</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                    <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add Category -->
    <div class="modal fade none-border" id="add-new-event">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <strong>Add</strong> a category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Category Name</label>
                                <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Choose Category Color</label>
                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                    <option value="success">Success</option>
                                    <option value="danger">Danger</option>
                                    <option value="info">Info</option>
                                    <option value="primary">Primary</option>
                                    <option value="warning">Warning</option>
                                    <option value="inverse">Inverse</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- END MODAL -->
<script type="text/javascript">
    

    var nowEvents = [];

    // {
    //     title: 'Released Ample Admin!',
    //     start: new Date($.now() + 506800000),
    //     className: 'bg-info'
    // }
    <?php foreach($holidays->result() as $holiday){ 
    ?>

    <?php if($holiday->recurrent==1){ 



        $startTime = strtotime( date("Y-01-01") );
        $endTime = strtotime( date("Y-12-31") );

        // Loop between timestamps, 24 hours at a time
        for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {

        // for($i=0; $i<=365; $i++){

        $the_date = $i;


        if(strtolower(date("l",$the_date))!=strtolower($holiday->day)) continue;

        ?>


        nowEvents.push({
            title: '<?php echo $holiday->title; ?>',
            start: new Date( <?php echo $the_date; ?> * 1000 ),
            className: '<?php echo $holiday->bg_type!=""?$holiday->bg_type:"bg-info"; ?>'
        });


    <?php } } else if($holiday->yearly==1){


        $start_year = date("Y",strtotime("-3 years"));
        $end_year = date("Y",strtotime("+3 years"));
        for($yearLoop=$start_year; $yearLoop<=$end_year; $yearLoop++)
        {



        $startTime = strtotime( date($yearLoop."-01-01") );
        $endTime = strtotime( date($yearLoop."-12-31") );


        // Loop between timestamps, 24 hours at a time
        for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {

        // for($i=0; $i<=365; $i++){

        $the_date = $i;


        if(strtolower(date("m-d",$the_date))!=strtolower(date("m-d",strtotime($holiday->date)))) continue;

        ?>


        nowEvents.push({
            title: '<?php echo $holiday->title; ?>',
            start: new Date( <?php echo $the_date; ?> * 1000 ),
            className: '<?php echo $holiday->bg_type!=""?$holiday->bg_type:"bg-info"; ?>'
        });

       <?php 
        }
    }



    } else if($holiday->yearly==0) { ?>

       


        nowEvents.push({
            title: '<?php echo $holiday->title; ?>',
            start: new Date( <?php echo strtotime($holiday->date)*1000; ?> ),
            allDay:true,
            <?php if($holiday->end_date!=""){ ?>
            end: new Date( <?php echo $the_date; ?> * 1000 ),
            <?php } ?>

            className: '<?php echo $holiday->bg_type!=""?$holiday->bg_type:"bg-info"; ?>'
        });
    <?php } ?>
    <?php } ?>



    console.log(nowEvents);
</script>