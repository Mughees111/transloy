<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Orders Management</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
                <a href="<?php echo $url;?>admin/add-order">
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
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
                    <h4 class="card-title">Orders</h4>
                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Product(s)</th>
                                    <th>Grand Total</th>
                                    <th>Status</th>
                                    <th>Mark as</th>
                                    <th>Data & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Product(s)</th>
                                    <th>Grand Total</th>
                                    <th>Status</th>
                                    <th>Mark as</th>
                                    <th>Data & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach($orders->result() as $order){

                                $product = $this->db->where('id',$order->product_id)
                                ->get('products')
                                ->result_object()[0];

                                $customer = $this->db->where('id',$order->user_id)
                                ->get('users')
                                ->result_object()[0];

                            ?>
                            <tr>
                                <td>
                                    #TF-0<?php echo $order->id;?>
                                </td>

                                <td>
                                    <?php echo $customer->name;?>
                                </td>

                                <td>
                                    <?php

                                    $products_order = $this->db->where('order_id',$order->id)->get('order_products')->result_object();
                                        $prod_ids = array();

                                        foreach($products_order as $product){
                                            $prod_ids[] = $product->product_id;

                                        }

                                        $products = $this->db->where_in('id',$prod_ids)->where('is_deleted',0)->get('products')->result_object();
                                        foreach($products as $product)
                                            echo $product->title.', ';
                                     ?>
                                </td>
                                <td> <?php echo with_currency($order->total); ?>
                                </td>
                               
                            	<td>
                            		<?php if($order->status == 0){?>


                                        (Pending)

                                    <?php } if($order->status == 1){?>
                                        (On It's Way)
                                   
                                    <?php } if($order->status == 2){?>
                                        (Delivered)
                                   
                                    <?php } if($order->status == 3){?>
                                        (Cancelled)
                            		<?php } ?>
                            	</td>
                                <td>
                                    <?php if($order->status == 0){?>


                                        <a href="<?php echo $url.'admin/order-status/'.$order->id.'/1';?>" ><span class="btn btn-sm btn-info">On It's way</span></a>
                                          <a href="<?php echo $url.'admin/order-status/'.$order->id.'/3'; ?>" ><span class="btn btn-sm btn-danger">Cancelled</span></a>

                                    <?php } if($order->status == 1){?>
                                    <a href="<?php echo $url.'admin/order-status/'.$order->id.'/2';?>" ><span class="btn btn-sm btn-info">Delivered</span></a>
                                      <a href="<?php echo $url.'admin/order-status/'.$order->id.'/3'; ?>" ><span class="btn btn-sm btn-danger">Cancelled</span></a>
                                    <?php } if($order->status == 2){?>
                                    <a href="<?php echo $url.'admin/order-status/'.$order->id.'/3'; ?>" ><span class="btn btn-sm btn-danger">Cancelled</span></a>
                                    <?php } if($order->status == 3){?>
                                    <?php } ?>
                                </td>

                            	<td >
                            		<?php echo date('d M, Y, h:i A',strtotime($order->created_at));?>
                            	</td>
                                <td>

                                   
                                   

                                    <a href="<?php echo $url."admin/";?>view-invoice-template/0/<?php echo $order->id;?>"><div class="btn btn-info btn-circle"><i class="fa fa-file-o"></i></div></a>
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