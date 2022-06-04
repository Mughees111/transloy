

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Products Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/products";?>">Products</a></li>
                <li class="breadcrumb-item active">Edit Product</li>
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

                <?php
                    $sub_ids = "listing";
                    require ("./application/views/backend/common/lang_select.php");
                ?>

                <div class="card-header">
                    <h4 class="m-b-0 text-white">Information

                    </h4>
                </div>
                <?php foreach($languages as $language){
                    $data = $this->product->get_product_by_lang($language->id,$the_id);

                 ?>
                 <div class="card-body lang_bodieslisting" id="lang-<?php echo $language->id; ?>listing"
                    style="display: <?php echo $language->id==$active?"":"none"; ?>;"
                    >

                    <?php $input = $language->slug."[title]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Title <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="<?php echo $input; ?>" class="form-control form-control-line"  placeholder="Title" value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $data->title;?>">
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>

                    </div>
                    <?php if($language->is_default==1){ ?>
                    <?php $input = $language->slug."[sku]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>SKU <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="SKU" value="<?php if(set_value($input) != ''){ echo set_value($input);} else echo $data->sku;?>">
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>

                    </div>

                   <?php $input = $language->slug."[qty]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Stock Quantity <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="number" step="1" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Stock Quantity" value="<?php if(set_value($input) != ''){ echo set_value($input);} else echo $data->qty;?>">
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>

                    </div>
                    <?php $input = $language->slug."[qty_unit]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <label for="category">Select Quantity Unit: <span class="text-danger">*</span> </label>
                        <select class="custom-select form-control required" name="<?php echo $input; ?>">

                               <?php 
                               $q_units = $this->db->where("status",1)->where("lparent",0)->where("is_deleted",0)->get("quantity_units")->result_object();
                               foreach($q_units as $q_unit){


                                ?>
                                     <option <?php if($q_unit->id == $this->input->post($input) || $data->qty_unit==$q_unit->id){ echo 'selected="selected"';}?>  value="<?php echo $q_unit->id;?>"><?php echo $q_unit->title;?></option>


                                
                                   
                                <?php } ?>
                        </select>
                        <div class="text-danger"><?php echo form_error($input);?></div>
                    </div>
                    <?php $input = $language->slug."[category]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <label for="category">Select Category: <span class="text-danger">*</span> </label>
                        <select class="custom-select form-control required" name="<?php echo $input; ?>">

                               <?php foreach($categories->result() as $category){


                                ?>
                                    
                                     <option <?php if($category->id == $this->input->post($input) || $data->category==$category->id){ echo 'selected="selected"';}?>  value="<?php echo $category->id;?>"><?php echo $category->title;?></option>


                                   
                                <?php } ?>
                        </select>
                        <div class="text-danger"><?php echo form_error($input);?></div>
                    </div>
                    <?php $input = $language->slug."[brand]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <label for="brand">Select Brand: <span class="text-danger">*</span> </label>
                        <select class="custom-select form-control required"  name="<?php echo $input; ?>">

                               <?php foreach($brands->result() as $brand){?>
                                   <option <?php if($brand->id == $this->input->post($input) || $data->brand==$brand->id){ echo 'selected="selected"';}?>  value="<?php echo $brand->id;?>"><?php echo $brand->title;?></option>
                                <?php } ?>
                        </select>
                        <div class="text-danger"><?php echo form_error($input);?></div>
                    </div>
                   
                    <?php $input = $language->slug."[price]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Price (USD) <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="number" step="0.1" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="$" value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $data->price;?>">
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>
                    <?php $input = $language->slug."[discount_type]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Discount Type <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select class="form-control form-control-line" name="<?php echo $input; ?>" required>
                                <option <?php if($this->input->post($input)=="0"  || $data->discount_type=="0") echo "selected"; ?> value="0">None</option>
                                <option <?php if($this->input->post($input)=="1"  || $data->discount_type=="1") echo "selected"; ?> value="1">Flat</option>
                                <option <?php if($this->input->post($input)=="2"  || $data->discount_type=="2") echo "selected"; ?> value="2">Percent</option>
                            </select>

                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>
                    <?php $input = $language->slug."[discount]"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Discount <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="number" step="0.1" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="0" value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $data->discount;?>">
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php $input = $language->slug."[description]"; ?>
                    <div class="form-group
                    <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Description </h5>
                        <div class="controls">
                            <textarea
                            class="mymce form-control form-control-line"
                            id="mymce"
                            name="<?php echo $input; ?>" ><?php
                            if(set_value($input) != ''){
                                echo set_value($input);
                            }else echo $data->description;?></textarea>
                            <div class="text-danger"><?php
                            echo form_error($input);?></div>
                        </div>
                    </div>
                   
                   
                    <?php $input = "image".$language->slug; ?>
                    <div class="easy form-group <?=(form_error($input) !='')?'error':'';?>">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 nopad">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Featured Image</h5>

                                        <input type="file" multiple id="input-file-disable-remove" class="dropify" data-show-remove="false" name="<?php echo $input; ?>" data-default-file="<?php if($data->image!=""){

                                            echo base_url()."resources/uploads/products/".$data->image;
                                        } ?>" />
                                        <div class="text-danger"><?php echo form_error($input);?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="add_more_images_in_me<?php echo $language->slug; ?>" class="easy pull-left" style="width: 100%;">
                        <?php




                        $more_images_now = $this->db->where("product_id",$data->id)->get("product_images")->result_object();

                        foreach($more_images_now as $mire_key=>$more_image_now)
                        {
                            $this->data["more_image_now"] = $more_image_now->image;
                            $this->data["m_lang"] = $language->slug;
                            $this->load->view("backend/products/image_section",$this->data);
                        }

                         ?>
                    </div>


                    <div class="form-group easy">
                        <button type="button" class="btn btn-info btn-sm" onclick="moreImage(this,'<?php echo $language->slug; ?>');">+ Image</button>
                    </div>


                    <div class="form-group easy">
                        <hr>
                    </div>
                    <div class="form-group easy">
                        <h4></h4>
                    </div>
                    <!-- ///// -->
                </div>
                <input type="hidden" name="<?php echo $language->slug."[row_id]"; ?>" value="<?php echo $data->id; ?>">
                <?php } ?>
            </div>



           

        
            
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/products" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>
