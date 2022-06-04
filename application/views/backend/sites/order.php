
  <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Construction Sites Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Change Sites order</li>
                </ol>
               
               
            </div>
        </div>
    </div>
    <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px;
    padding: 0.4em;
    padding-left: 1.5em;
    font-size: 1.4em;
    /* height: 18px; */
    float: left;
    width: 100%;
    padding: 20px;
    background: #ccc;
    
      cursor:move;
      
  }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <form method="post" action="">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order the construction sites</h4>
                    
                    <div class="col-12">
                        
                        <ul id="sortable">
                           
                        
                        <?php
                        
                    
                            foreach($sites as $site)
                            {
                                
                                ?>
                                
                                 <li id="<?php echo $site->id; ?>" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $site->title; ?> | <?php echo ($site->address); ?></li>
                                 
                                 <?php
                                
                            }
                        
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
            
             <div class="card-body">
                <div class="text-xs-right">
                    <input type="hidden" name="order_val" id="order_val" />
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/sites" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            </form>
          
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