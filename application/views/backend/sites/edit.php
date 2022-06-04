<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Sites Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/sites";?>">Sites</a></li>
                <li class="breadcrumb-item active">Add New Site</li>
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
                
                <div class="card-body lang_bodieslisting" >
                    <?php $input = "title"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Title <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="<?php echo $input; ?>" class="form-control form-control-line" placeholder="Title" value="<?php if(set_value($input) != ''){ echo set_value($input);} else echo $data->title; ?>">
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>


                    <?php $input = "address"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Address <small><i class="fa fa-info"></i> Human Read-able</small> </h5>
                        <div class="controls">
                            <textarea class=" form-control form-control-line" name="<?php echo $input; ?>" ><?php if(set_value($input) != ''){ echo set_value($input);}  else echo $data->address;?></textarea>
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>
                    
                    <?php $input ="description"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Description </h5>
                        <div class="controls">
                            <textarea class="mymce form-control form-control-line" id="mymce" name="<?php echo $input; ?>" ><?php if(set_value($input) != ''){ echo set_value($input);} else echo $data->description;?></textarea>
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>



                    <?php /* ?>

                    <div class="form-group">
                        <hr style="border-style: dashed;">
                    </div>


                    <?php $input = "lat"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Latitude <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="<?php echo $input; ?>" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Latitude" value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $data->lat;?>" >
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>

                    <?php $input = "lng"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <h5>Longitude <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input 
                            type="text" 
                            name="<?php echo $input; ?>" 
                            class="form-control form-control-line" 
                            required 
                            data-validation-required-message="This field is required" 
                            placeholder="Longitude" 
                            value="<?php if(set_value($input) != ''){ echo set_value($input);}else echo $data->lng;?>" 
                            >
                            <div class="text-danger"><?php echo form_error($input);?></div>
                        </div>
                    </div>
                    <?php */ ?>


                    <span style="margin: 10px 0;">Selected: <?php echo $data->long_address; ?></span>

                     <input class="form-control" name="pickup_title" id="pac-input"  type="text"
                            placeholder="Leave Empty if you don't want to change the location">
                    <input type="hidden" name="pickup_lat" value="<?php echo $data->lat; ?>" id="pickup_lat">
                    <input type="hidden" name="pickup_lng" value="<?php echo $data->lng; ?>" id="pickup_lng">
                    <div id="map" class="map"></div>
                    <div id="infowindow-content">
                      <img src="" width="16" height="16" id="place-icon">
                      <span id="place-name"  class="title"></span><br>
                      <span id="place-address"></span>
                    </div>
                    <div style="margin-top: 20px;"></div>



                    <div class="form-group">
                        <hr style="border-style: dashed;">
                    </div>
                    <div class="easy row">
                        <div class="col-4">

                            <?php $input = "monday"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Monday <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">


                                    <option <?php if($data->monday==1){ echo 'selected="selected"';}?>  value="1">Opens</option>
                                    <option <?php if($data->monday==0){ echo 'selected="selected"';}?>  value="0">Closes</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "monday_opens"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Monday Opens At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "08:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "monday_closes"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Monday Closes At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "20:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>

                    </div>


                    <div class="easy row">
                        <div class="col-4">

                            <?php $input = "tuesday"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Tuesday <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">


                                    <option <?php if($data->tuesday==1){ echo 'selected="selected"';}?>  value="1">Opens</option>
                                    <option <?php if($data->tuesday==0){ echo 'selected="selected"';}?>  value="0">Closes</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "tuesday_opens"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Tuesday Opens At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "08:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "tuesday_closes"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Tuesday Closes At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "20:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>

                    </div>

                    <div class="easy row">
                        <div class="col-4">

                            <?php $input = "wednesday"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Wednesday <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">


                                    <option <?php if($data->wednesday==1){ echo 'selected="selected"';}?>  value="1">Opens</option>
                                    <option <?php if($data->wednesday==0){ echo 'selected="selected"';}?>  value="0">Closes</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "wednesday_opens"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Wednesday Opens At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "08:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "wednesday_closes"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Wednesday Closes At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "20:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>

                    </div>

                    <div class="easy row">
                        <div class="col-4">

                            <?php $input = "thursday"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Thursday <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">


                                    <option <?php if($data->thursday==1){ echo 'selected="selected"';}?>  value="1">Opens</option>
                                    <option <?php if($data->thursday==0){ echo 'selected="selected"';}?>  value="0">Closes</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "thursday_opens"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Thursday Opens At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "08:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "thursday_closes"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Thursday Closes At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "20:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>

                    </div>

                    <div class="easy row">
                        <div class="col-4">

                            <?php $input = "friday"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Friday <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">


                                    <option <?php if($data->friday==1){ echo 'selected="selected"';}?>  value="1">Opens</option>
                                    <option <?php if($data->friday==0){ echo 'selected="selected"';}?>  value="0">Closes</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "friday_opens"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Friday Opens At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "08:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "friday_closes"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Friday Closes At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "20:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>

                    </div>

                    <div class="easy row">
                        <div class="col-4">

                            <?php $input = "saturday"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Saturday <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">


                                    <option <?php if($data->saturday==1){ echo 'selected="selected"';}?>  value="1">Opens</option>
                                    <option <?php if($data->saturday==0){ echo 'selected="selected"';}?>  value="0">Closes</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "saturday_opens"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Saturday Opens At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "08:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "saturday_closes"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Saturday Closes At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "20:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>

                    </div>

                    <div class="easy row">
                        <div class="col-4">

                            <?php $input = "sunday"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Sunday <span class="text-danger">*</span></h5>
                                <select class="custom-select form-control required" name="<?php echo $input; ?>">


                                    <option <?php if($data->sunday==1){ echo 'selected="selected"';}?>  value="1">Opens</option>
                                    <option <?php if($data->sunday==0){ echo 'selected="selected"';}?>  value="0">Closes</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "sunday_opens"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Sunday Opens At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "08:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">

                            <?php $input = "sunday_closes"; ?>
                            <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                                <h5>Sunday Closes At:</h5>
                                <div class="controls">
                                    <input 
                                    type="time" 
                                    name="<?php echo $input; ?>" 
                                    class="form-control form-control-line" 
                                    value="<?php if($data->$input != ''){ echo $data->$input;} else echo "20:30:00";?>" 
                                    >
                                    <div class="text-danger"><?php echo form_error($input);?></div>
                                </div>
                            </div>  
                        </div>

                    </div>

                     <div class="form-group">
                        <hr style="border-style: dashed;">
                    </div>


                    <?php $input = "image"; ?>
                    <div class="form-group <?=(form_error($input) !='')?'error':'';?>">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 nopad">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Image</h5>

                                        <input type="file" id="input-file-disable-remove" class="dropify" data-show-remove="false" name="<?php echo $input; ?>" data-default-file="<?php echo $url."resources/";?>uploads/sites/<?php echo $data->image;?>" />
                                        <div class="text-danger"><?php echo form_error($input);?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/sites" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>
<style type="text/css">
    #map,#map2 {
        height: 200px;
        width: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
     
      

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content,#map2 #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

     

      

      #pac-input,#pac-input2 {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
      }

      #pac-input:focus,#pac-input2:focus {
        border-color: #4d90fe;
      }

     
</style>
<script type="text/javascript">
    var doEdit = true;
    var lat_Edit = '<?php echo $data->lat; ?>';
    var lng_Edit = '<?php echo $data->lng; ?>';
</script>