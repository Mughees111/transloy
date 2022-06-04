<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends ADMIN_Controller {

	function __construct()
	{
		parent::__construct();
		auth();
        $this->data['active'] = 'product';
        $this->load->model('products_model','product');
	}

	public function index()
	{

			$this->data['title'] = 'Products';
            $this->data['sub'] = 'products';
            $this->data['js'] = 'listing';
            $this->data['jsfile'] = 'js/general_listing';
            $this->data['products'] = $this->product->get_all_products();
			$this->data['content'] = $this->load->view('backend/products/listing',$this->data,true);
			$this->load->view('backend/common/template',$this->data);

	}
    public function trash()
    {

            $this->data['title'] = 'Trash products';
            $this->data['sub'] = 'trash';
            $this->data['js'] = 'listing';
            $this->data['jsfile'] = 'js/general_listing';
            $this->data['products'] = $this->product->get_all_trash_products();
            $this->data['content'] = $this->load->view('backend/products/trash',$this->data,true);
            $this->load->view('backend/common/template',$this->data);

    }
    public function restore($id){

        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 0;
        $this->db->where('id',$id);
        $this->db->update('products', $dbData);
        $this->session->set_flashdata('msg', 'product restored successfully!');
        redirect('admin/trash-products');
    }

	public function add (){


        $dlang = dlang();
        $langs = langs();
        $input = $dlang->slug."[title]";

	    $this->form_validation->set_rules($input,'Title','trim|required|alpha_numeric_spaces');
	    
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
	    if($this->form_validation->run() === false){
            $this->data['title'] = 'Add New product';
            $this->data['sub'] = 'add-product';
            $this->data['jsfile'] = 'js/add_product';
            $this->data['categories'] = $this->db->where('is_deleted',0)
            ->where('lparent',0)

            ->get('categories');
            if(isset($_GET['replicate']))
            {
                $this->data['prev'] = $this->db->where('is_deleted',0)
                ->where('id',$_GET['replicate'])
                ->get('products')->result_object()[0];

            }
            $this->data['quantity_units'] = $this->db->where('is_deleted',0)
            ->get('quantity_units');
            $this->data['brands'] = $this->db->where('is_deleted',0)
            ->where('status',1)
            ->where('lparent',0)
            ->get('brands');
            $this->data['stores'] = $this->db->where('is_deleted',0)
            ->where('status',1)
            ->where('lparent',0)
            ->get('stores');
            $this->data['meta'] = $this->load->view('backend/common/meta_data',$this->data,true);
            $this->data['content'] = $this->load->view('backend/products/add',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }else{


            $def_key=0;
            $def_parent=0;
            $fault = false;
            foreach($langs as $key=>$lang){
                $dbData=array();
                $input = $lang->slug."[title]";
                $dbData['title'] = $this->input->post($input);
                $input = $lang->slug."[category]";
                $dbData['category'] = $this->input->post($input);
                $input = $lang->slug."[brand]";
    	        $dbData['brand'] = $this->input->post($input);


                $input = $lang->slug."[store]";
                $dbData['store_id'] = $this->input->post($input);


                $input = $lang->slug."[title]";
    	        $dbData['slug'] = slug($this->input->post($input));
                $input = $lang->slug."[description]";
                $dbData['description'] = $this->input->post($input);

                $input = "title_of_section".$lang->slug;
                $description2 = array();
                foreach($this->input->post($input) as $k=>$v)
                    $description2[] = array($this->input->post($input)[$k]=>$v);
                $description2 = json_encode($description2);

                
    	        $dbData['description2'] = $description2;
                
                $input = $lang->slug."[discount_type]";
                $dbData['discount_type'] = $this->input->post($input)?$this->input->post($input):0;
                $input = $lang->slug."[price]";
                $dbData['price'] = $this->input->post($input)?$this->input->post($input):0;
                $input = $lang->slug."[discount]";
                $dbData['discount'] = $this->input->post($input)?$this->input->post($input):0;
                $input = $lang->slug."[sku]";
                $dbData['sku'] = $this->input->post($input)?$this->input->post($input):0;


                $input = $lang->slug."[qty]";
                $dbData['qty'] = $this->input->post($input)?$this->input->post($input):100;


                $input = $lang->slug."[qty_unit]";
                $dbData['qty_unit'] = $this->input->post($input)?$this->input->post($input):1;

                $input = $lang->slug."[featured]";
                $dbData['featured'] = $this->input->post($input)==1?1:0;
    	        
    	        $dbData['created_at'] = date('Y-m-d H:i:s');
    	        $dbData['created_by'] = $this->session->userdata('admin_id');
    	        $dbData['updated_at'] = date('Y-m-d H:i:s');
                $dbData['updated_by'] = $this->session->userdata('admin_id');

                $dbData["lparent"] = $def_key;
                $dbData["lang_id"] = $lang->id;

                $files = $_FILES;
                $input = "image_more".$lang->slug;
                $cpt = count($_FILES[$input]['name']);
                // echo $cpt;exit;
                $more_images = array();
                for($i=0; $i<$cpt; $i++)
                {
                    $_FILES[$input]['name']= $files[$input]['name'][$i];
                    $_FILES[$input]['type']= $files[$input]['type'][$i];
                    $_FILES[$input]['tmp_name']= $files[$input]['tmp_name'][$i];
                    $_FILES[$input]['error']= $files[$input]['error'][$i];
                    $_FILES[$input]['size']= $files[$input]['size'][$i];

                    $image = $this->image_upload($input,'./resources/uploads/products/','jpg|jpeg|png|gif');

                    if($image['upload'] == true){

                        $image = $image['data'];

                        $more_images[] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/products/actual_size/',200,200);

                    }else{

                        $this->session->set_flashdata('err','An Error occurred durring uploading image, please try again');
                        redirect('admin/add-product');
                    }
                }



                $input = "image".$lang->slug;

                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
    	        $image = $this->image_upload($input,'./resources/uploads/products/','jpg|jpeg|png|gif');
    	        if($image['upload'] == true || $_FILES[$input]['size']<1){
                    $image = $image['data'];
                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $dbData["image"] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/products/actual_size/',200,200);
                    }

                    $this->db->insert('products',$dbData);
                    if($def_key==0){
                        $def_key = $this->db->insert_id();
                        $insert_id = $def_key;
                    }
                    else{
                        $insert_id = $this->db->insert_id();
                    }

                    foreach($more_images as $im)
                    {
                        $this->db->insert('product_images',array(
                            'created_by'=>$dbData['created_by'],
                            'updated_at'=>$dbData['updated_at'],
                            'updated_by'=>$dbData['updated_by'],
                            'product_id'=>$insert_id,
                            'image'=>$im
                        ));
                    }

                    

                }else{

    	            $this->session->set_flashdata('err','An Error occurred durring uploading image, please try again');
    	            redirect('admin/add-product');
                }
            }



            $product_id = $def_key;
           
            foreach($this->input->post("variations") as $vv=>$k)
            // foreach($langs as $key=>$lang)
            {
                $def_key=0;
                $def_parent=0;
                $fault = false;
                $input = $lang->slug."[type]";
                foreach($langs as $key=>$lang)
                {
                    $input = $lang->slug."[type]";
                    $type = $this->input->post($input)[$vv];
                    $input = $lang->slug."[value]";
                    $title = $this->input->post($input)[$vv];
                    $img = null;

                    $files = $_FILES;
                    $input = "vimg".$lang->slug;
                    $_FILES[$input]['name']= $files[$input]['name'][$k];
                    $_FILES[$input]['type']= $files[$input]['type'][$k];
                    $_FILES[$input]['tmp_name']= $files[$input]['tmp_name'][$k];
                    $_FILES[$input]['error']= $files[$input]['error'][$k];
                    $_FILES[$input]['size']= $files[$input]['size'][$k];
                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $image = $this->image_upload($input,'./resources/uploads/products/','jpg|jpeg|png|gif');
                        if($image['upload'] == true || $_FILES[$input]['size']<1){
                            $image = $image['data'];
                            $img = $image['file_name'];
                        }
                    }
                   
                    $this->db->insert('variations',array(
                        'type'=>$type,
                        'title'=>$title,
                        'product_id'=>$product_id,
                        'image'=>$img,
                        "lparent"=>$def_key,
                        "lang_id"=>$lang->id
                    ));

                    if($def_key==0){
                        $def_key = $this->db->insert_id();
                    }
                    
                }
            }



            $this->session->set_flashdata('msg','New product added successfully!');
            redirect('admin/products');
        }
    }
    public function view_description_section($mlang)
    {
        $this->data["m_lang"] = $mlang;
        echo $this->load->view('backend/products/description_section',$this->data,true);
    }
    public function view_variation_section($mlang)
    {
        $this->data["m_lang"] = $mlang;
        echo $this->load->view('backend/products/variation_section',$this->data,true);
    }
    public function view_more_image($mlang)
    {
        $this->data["m_lang"] = $mlang;

        echo $this->load->view('backend/products/image_section',$this->data,true);
    }

    public function check_product($title){

	    $result = $this->product->get_product_by_title($title);
	    if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $this->form_validation->set_message('check_product', 'This product already exist.');
                return false;
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_product', 'This field is required.');
            return false;
        }
    }
    public function details($product=0)
    {
        $this->data['title'] = 'Product Details';
        $this->data['sub'] = 'details';

        $this->data['product'] = $this->product->get_product_by_id($product);

        if(empty($this->data['product']))
        {
            $this->session->set_flashdata('msg','No product found matching your selection');
            redirect(base_url()."products");
            exit();
        }

        $this->data['content'] = $this->load->view('backend/products/details',$this->data,true);
        $this->load->view('backend/common/template',$this->data);
    }


    public function status($id,$status){

        $result = $this->product->get_product_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $product_status = 1;

        if($status == 1){

            $product_status = 0;

        }

        $dbData['status'] = $product_status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id',$id);
        $this->db->update('products',$dbData);
        $this->session->set_flashdata('msg','product status updated successfully!');
        redirect('admin/products');
    }

    public function edit($id){

        $result = $this->product->get_product_by_id($id);


        $this->data["the_id"] = $id;
        $the_id = $id;

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $this->data['data'] = $result;
        $dlang = dlang();
        $langs = langs();
        $input = $dlang->slug."[title]";

        $this->form_validation->set_rules($input,'Title','trim|required|alpha_numeric_spaces');
        
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Edit product';
            $this->data['jsfile'] = 'js/add_product';
            $this->data['meta'] = $this->load->view('backend/common/meta_data',$this->data,true);
            $this->data['categories'] = $this->db->where('is_deleted',0)
            ->where('parent',0)
            ->where('lparent',0)
            ->get('categories');
            if(isset($_GET['replicate']))
            {
                $this->data['prev'] = $this->db->where('is_deleted',0)
                ->where('id',$_GET['replicate'])
                ->get('products')->result_object()[0];

            }
            $this->data['quantity_units'] = $this->db->where('is_deleted',0)
            ->get('quantity_units');
            $this->data['brands'] = $this->db->where('is_deleted',0)
            ->where('status',1)
            ->where('lparent',0)
            ->get('brands');
            $this->data['stores'] = $this->db->where('is_deleted',0)
            ->where('status',1)
            ->where('lparent',0)
            ->get('stores');
            $this->data['content'] = $this->load->view('backend/products/edit',$this->data,true);

            $this->load->view('backend/common/template',$this->data);
        }else{

            $def_key=0;
            $def_parent=0;
            $fault = false;
            foreach($langs as $key=>$lang){
                $dbData=array();
                $input = $lang->slug."[row_id]";
                $row_id = $this->input->post($input);

                $input = $lang->slug."[title]";
                $dbData['title'] = $this->input->post($input);
                $input = $lang->slug."[category]";
                $dbData['category'] = $this->input->post($input);
                $input = $lang->slug."[brand]";
                $dbData['brand'] = $this->input->post($input);



                $input = $lang->slug."[qty]";
                $dbData['qty'] = $this->input->post($input)?$this->input->post($input):100;


                $input = $lang->slug."[qty_unit]";
                $dbData['qty_unit'] = $this->input->post($input)?$this->input->post($input):1;


                $input = $lang->slug."[store]";
                $dbData['store_id'] = $this->input->post($input);


                $input = $lang->slug."[title]";
                $dbData['slug'] = slug($this->input->post($input));
                $input = $lang->slug."[description]";
                $dbData['description'] = $this->input->post($input);

                $input = "title_of_section".$lang->slug;
                $description2 = array();
                foreach($this->input->post($input) as $k=>$v)
                    $description2[] = array($this->input->post($input)[$k]=>$v);
                $description2 = json_encode($description2);

                
                $dbData['description2'] = $description2;
                
                $input = $lang->slug."[discount_type]";
                $dbData['discount_type'] = $this->input->post($input)?$this->input->post($input):0;
                $input = $lang->slug."[price]";
                $dbData['price'] = $this->input->post($input)?$this->input->post($input):0;
                $input = $lang->slug."[discount]";
                $dbData['discount'] = $this->input->post($input)?$this->input->post($input):0;
                $input = $lang->slug."[sku]";
                $dbData['sku'] = $this->input->post($input)?$this->input->post($input):0;
                $input = $lang->slug."[featured]";
                $dbData['featured'] = $this->input->post($input)==1?1:0;
                
                $dbData['updated_at'] = date('Y-m-d H:i:s');
                $dbData['updated_by'] = $this->session->userdata('admin_id');


                $files = $_FILES;
                $input = "image_more".$lang->slug;
                $cpt = count($this->input->post("def_more".$lang->slug));
                $more_images = array();
                for($i=0; $i<$cpt; $i++)
                {
                    $_FILES[$input]['name']= $files[$input]['name'][$i];
                    $_FILES[$input]['type']= $files[$input]['type'][$i];
                    $_FILES[$input]['tmp_name']= $files[$input]['tmp_name'][$i];
                    $_FILES[$input]['error']= $files[$input]['error'][$i];
                    $_FILES[$input]['size']= $files[$input]['size'][$i];

                    $image = $this->image_upload($input,'./resources/uploads/products/','jpg|jpeg|png|gif');


                    $consider_more_def = $this->input->post("def_more".$lang->slug."[".$i."]");

                    if($image['upload'] == true){

                        $image = $image['data'];

                        $more_images[] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/products/actual_size/',200,200);

                    }elseif($consider_more_def!=""){
                        $more_images[] = $consider_more_def;
                    }
                    else{

                        $this->session->set_flashdata('err','An Error occurred durring uploading image, please try again');
                        redirect('admin/add-product');
                    }
                }


                $input = "image".$lang->slug;

                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
                $image = $this->image_upload($input,'./resources/uploads/products/','jpg|jpeg|png|gif');
                if($image['upload'] == true || $_FILES[$input]['size']<1){
                    $image = $image['data'];
                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $dbData["image"] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/products/actual_size/',200,200);
                    }

                    $this->db->where("id",$row_id);
                    $this->db->update('products',$dbData);
                    if($def_key==0){
                        $def_key = $this->db->insert_id();
                        $insert_id = $def_key;
                    }
                    else{
                        $insert_id = $this->db->insert_id();
                    }

                    $this->db->where("product_id",$row_id)->delete("product_images");


                    foreach($more_images as $im)
                    {
                        $this->db->insert('product_images',array(
                            'created_by'=>$this->session->userdata('admin_id'),
                            'updated_at'=>date("Y-m-d H:i:s"),
                            'updated_by'=>$this->session->userdata('admin_id'),
                            'product_id'=>$row_id,
                            'image'=>$im
                        ));
                    }

                    

                }else{

                    $this->session->set_flashdata('err','An Error occurred durring uploading image, please try again');
                    redirect('admin/add-product');
                }
            }

            $this->db->where("product_id",$the_id)->delete("variations");



            $product_id = $the_id;
            
           
            foreach($this->input->post("variations") as $vv=>$k)
            // foreach($langs as $key=>$lang)
            {
                $def_key=0;
                $def_parent=0;
                $fault = false;
                $input = $lang->slug."[type]";
                foreach($langs as $key=>$lang)
                {
                    $input = $lang->slug."[type]";
                    $type = $this->input->post($input)[$vv];
                    $input = $lang->slug."[value]";
                    $title = $this->input->post($input)[$vv];
                    $img = null;

                    $files = $_FILES;
                    $input = "vimg".$lang->slug;
                    $_FILES[$input]['name']= $files[$input]['name'][$k];
                    $_FILES[$input]['type']= $files[$input]['type'][$k];
                    $_FILES[$input]['tmp_name']= $files[$input]['tmp_name'][$k];
                    $_FILES[$input]['error']= $files[$input]['error'][$k];
                    $_FILES[$input]['size']= $files[$input]['size'][$k];

                    $varData = array(
                        'type'=>$type,
                        'title'=>$title,
                        'product_id'=>$product_id,
                        "lparent"=>$def_key,
                        "lang_id"=>$lang->id
                    );


                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $image = $this->image_upload($input,'./resources/uploads/products/','jpg|jpeg|png|gif');
                        if($image['upload'] == true || $_FILES[$input]['size']<1){
                            $image = $image['data'];
                            $img = $image['file_name'];
                            $varData['image']=$img;
                        }
                        else{
                            $varData['image']=$this->input->post("def_".$input."[".$k."]");
                        }
                    }
                    else{
                        $varData['image']=$this->input->post("def_".$input."[".$k."]");
                    }


                    $this->db->insert('variations',$varData);
                    if($def_key==0){
                        $def_key = $this->db->insert_id();
                    }
                    
                }
            }
            $this->session->set_flashdata('msg', 'product updated successfully!');
            redirect('admin/products');

        }
    }

    public function check_product_edit($title,$id){

        $result = $this->product->get_product_by_title($title);
        if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $result = $result->row();
                if($result->id == $id){
                    return true;
                }else{
                    $this->form_validation->set_message('check_product_edit', 'This product already exist.');
                    return false;
                }
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_product_edit', 'This field is required.');
            return false;
        }
    }

    public function delete($id){
        $result = $this->product->get_product_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id',$id);
        $this->db->update('products', $dbData);
        $this->session->set_flashdata('msg', 'product deleted successfully!');
        redirect('admin/products');
    }

    public function delete_image($id){
        $result = $this->product->get_product_image_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id',$id);
        $this->db->update('products', $dbData);
        $this->session->set_flashdata('msg', 'product deleted successfully!');
        redirect($_SERVER['HTTP_REFERER']);
    }
}
