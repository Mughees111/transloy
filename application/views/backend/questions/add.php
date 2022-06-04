

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Questions Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $url."admin";?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url."admin/questions";?>">Questions</a></li>
                <li class="breadcrumb-item active">Add New Question</li>
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
                <div class="card-body">
                    

                    <div class="form-group <?=(form_error('title') !='')?'error':'';?>">
                        <h5>Question <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="title" class="form-control form-control-line" required data-validation-required-message="This field is required" placeholder="Question" value="<?php if(set_value('title') != ''){ echo set_value('title');}else echo $prev->title;?>" >
                            <div class="text-danger"><?php echo form_error('title');?></div>
                        </div>

                    </div>


                    <div class="form-group <?=(form_error('remember_able') !='')?'error':'';?>">
                        <h5>Remember Able </h5>
                        <div class="controls">
                            <input <?php if($this->input->post('remember_able')==1 || $prev->remember_able==1) echo "checked"; ?> type="checkbox" value="1" name="remember_able">
                            <div class="text-danger"><?php echo form_error('remember_able');?></div>
                        </div>

                    </div>

                    <div class="form-group <?=(form_error('weight') !='')?'error':'';?>">
                        <h5>Weight  <small>From 0 to 1, example 0.5 or 0.9</small></h5>
                        <div class="controls">
                            <input type="number" step="0.1" min="0" max="1" name="weight" class="form-control form-control-line"  placeholder="Weight" value="<?php if(set_value('weight') != ''){ echo set_value('weight');}else echo $prev->weight; ?>" >
                            <div class="text-danger"><?php echo form_error('weight');?></div>
                        </div>

                    </div>

                    <div class="form-group <?=(form_error('type') !='')?'error':'';?>">
                        <h5>Question Type <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select onchange="toggleViewTypeChoices()" name="type" required="" class="form-control form-control-line">
                                <option <?php if($this->input->post("type")=="1" || $prev->type=="1") echo "selected"; ?> value="1">MCQ</option>
                                <option <?php if($this->input->post("type")=="2" || $prev->type=="2") echo "selected"; ?> value="2">Text</option>
                            </select>
                            <div class="text-danger"><?php echo form_error('type');?></div>
                        </div>
                    </div>

                    <div class="msq_type_div" id="add_more_choices_in_me" style="<?php if($this->input->post("type")=="2" || $prev->type=="2") echo "display: none;"; ?>">
                       <?php 
                       if(empty($this->input->post('choices'))){
                            if(empty($prev)){
                                $this->load->view('backend/questions/choice',$this->data); 
                                $this->load->view('backend/questions/choice',$this->data);
                            }
                            else
                            {
                                foreach(json_decode($prev->choices) as $k=>$v){
                                $this->data['choice'] = $v;
                                $this->data['is_correct'] = $this->input->post('correct')[$k]==1?1:0;
                                $this->load->view('backend/questions/choice',$this->data);
                                }
                            }
                        }
                        else{
                            foreach($this->input->post('choices') as $k=>$v){
                                $this->data['choice'] = $v;
                                $this->data['is_correct'] = $this->input->post('correct')[$k]==1?1:0;
                                $this->load->view('backend/questions/choice',$this->data);
                            }
                        }
                        ?>

                        



                    </div>
                    <div class="form-group easy msq_type_div" style="<?php if($this->input->post("type")=="2" || $prev->type=="2") echo "display: none;"; ?>">
                        <button type="button" class="btn btn-info btn-sm" onclick="moreChoice(this);">+ More Choice</button>
                    </div>
                    <div id="text_type_div" class="easy" style="<?php if($this->input->post("type")!="2" || $prev->type!="2") echo "display: none;"; ?>">
                        <div class="form-group <?=(form_error('description') !='')?'error':'';?>">
                            <h5>Answer </h5>
                            <div class="controls">
                                <textarea class="mymce form-control form-control-line" id="mymce" name="description" ><?php if(set_value('description') != ''){ echo set_value('description');}?></textarea>
                                <div class="text-danger"><?php echo form_error('description');?></div>
                            </div>
                        </div>
                    </div>

                   
                    
                   


                </div>
            </div>
            <div class="card-body">
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="<?=$url;?>admin/questions" class="btn btn-inverse">Cancel</a>
                </div>
            </div>
            <?=form_close();?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>