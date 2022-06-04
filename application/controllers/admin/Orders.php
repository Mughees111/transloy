<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends ADMIN_Controller {

	function __construct()
	{
		parent::__construct();
		auth();
        $this->data['active'] = 'orders';
        $this->load->model('orders_model','order');
	}

	public function index()
	{

			$this->data['title'] = 'Orders';
            $this->data['sub'] = 'orders';
            $this->data['js'] = 'listing';
            $this->data['jsfile'] = 'js/general_listing';
            $this->data['orders'] = $this->order->get_all_orders();
			$this->data['content'] = $this->load->view('backend/orders/listing',$this->data,true);
			$this->load->view('backend/common/template',$this->data);

	}
    public function trash()
    {

            $this->data['title'] = 'Trash Orders';
            $this->data['sub'] = 'trash';
            $this->data['js'] = 'listing';
            $this->data['jsfile'] = 'js/general_listing';
            $this->data['orders'] = $this->order->get_all_trash_orders();
            $this->data['content'] = $this->load->view('backend/orders/trash',$this->data,true);
            $this->load->view('backend/common/template',$this->data);

    }
    public function restore($id){
        
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 0;
        $this->db->where('id',$id);
        $this->db->update('orders', $dbData);
        $this->session->set_flashdata('msg', 'order restored successfully!');
        redirect('admin/trash-orders');
    }

	public function add (){

	    $this->form_validation->set_rules('title','Title','trim|required|alpha_numeric_spaces|callback_check_order');
	    //$this->form_validation->set_rules('description','Description','trim|required');
	    $this->form_validation->set_rules('image','Image','callback_image_not_required[image,200,200]');
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
	    if($this->form_validation->run() === false){
            $this->data['title'] = 'Add New Order';
            $this->data['sub'] = 'add-order';
            $this->data['meta'] = $this->load->view('backend/common/meta_data',$this->data,true);
            $this->data['content'] = $this->load->view('backend/orders/add',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }else{

	        $dbData['title'] = $this->input->post('title');
	        $dbData['slug'] = slug($this->input->post('title'));
	        $dbData['description'] = $this->input->post('description');
	        $dbData['meta_title'] = $this->input->post('meta_title');
	        $dbData['meta_keywords '] = $this->input->post('meta_keys');
	        $dbData['meta_description'] = $this->input->post('meta_desc');
	        $dbData['created_at'] = date('Y-m-d H:i:s');
	        $dbData['created_by'] = $this->session->userdata('admin_id');
	        $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');


            if((isset($_FILES['image']) && $_FILES['image']['size'] > 0))
	        $image = $this->image_upload('image','./resources/uploads/orders/','jpg|jpeg|png|gif');
	        if($image['upload'] == true || $_FILES['image']['size']<1){
                $image = $image['data'];
                if((isset($_FILES['image']) && $_FILES['image']['size'] > 0)){
                    $dbData['image'] = $image['file_name'];
                    $this->image_thumb($image['full_path'],'./resources/uploads/orders/actual_size/',200,200);
                }
                $this->db->insert('orders',$dbData);
                $this->session->set_flashdata('msg','New order added successfully!');
                redirect('admin/orders');
            }else{
                print_r($image);exit;

	            $this->session->set_flashdata('err','An Error occurred durring uploading image, please try again');
	            redirect('admin/add-order');
            }

        }
    }

    public function check_order($title){

	    $result = $this->order->get_order_by_title($title);
	    if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $this->form_validation->set_message('check_order', 'This order already exist.');
                return false;
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_order', 'This field is required.');
            return false;
        }
    }


    public function status($id,$status){

        $result = $this->order->get_order_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        if($status==1)
        {
            $dbData["status_2"] = date('Y-m-d H:i:s');
        }
        if($status==2)
        {
            $dbData["status_3"] = date('Y-m-d H:i:s');
        }
         if($status==3)
        {
            $dbData["status_4"] = date('Y-m-d H:i:s');
        }

        $dbData['status'] = $status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id',$id);
        $this->db->update('orders',$dbData);
        $this->session->set_flashdata('msg','order status updated successfully!');
        redirect('admin/orders');
    }

    public function edit($id){

        $result = $this->order->get_order_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $this->data['data'] = $result;
        $this->form_validation->set_rules('title','Title','trim|required|alpha_numeric_spaces|callback_check_order_edit['.$id.']');
        //$this->form_validation->set_rules('description','Description','trim|required');
        $this->form_validation->set_rules('image','Image','callback_image_not_required[image,200,200]');
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Edit Order';
            $this->data['meta'] = $this->load->view('backend/common/meta_data',$this->data,true);
        
            $this->data['content'] = $this->load->view('backend/orders/edit',$this->data,true);
             
            $this->load->view('backend/common/template',$this->data);
        }else{

            $dbData['title'] = $this->input->post('title');
            $dbData['description'] = $this->input->post('description');
            $dbData['meta_title'] = $this->input->post('meta_title');
            $dbData['meta_keywords '] = $this->input->post('meta_keys');
            $dbData['meta_description'] = $this->input->post('meta_desc');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');

            if(!empty($_FILES['image']['name'])) {
                unlink('./resources/uploads/orders/'.$this->data['data']->image);
                unlink('./resources/uploads/orders/actual_size/'.$this->data['data']->image);
                $image = $this->image_upload('image', './resources/uploads/orders/', 'jpg|jpeg|png|gif');
                if ($image['upload'] == true) {
                    $image = $image['data'];
                    $dbData['image'] = $image['file_name'];
                    $this->image_thumb($image['full_path'], './resources/uploads/orders/actual_size/', 1400, 438);
                } else {

                    $this->session->set_flashdata('err', 'An Error occurred durring uploading image, please try again');
                    redirect('admin/add-order');
                }
            }
            $this->db->where('id',$id);
            $this->db->update('orders', $dbData);
            $this->session->set_flashdata('msg', 'order updated successfully!');
            redirect('admin/orders');

        }
    }

    public function check_order_edit($title,$id){

        $result = $this->order->get_order_by_title($title);
        if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $result = $result->row();
                if($result->id == $id){
                    return true;
                }else{
                    $this->form_validation->set_message('check_order_edit', 'This order already exist.');
                    return false;
                }
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_order_edit', 'This field is required.');
            return false;
        }
    }

    public function delete($id){
        $result = $this->order->get_order_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id',$id);
        $this->db->update('orders', $dbData);
        $this->session->set_flashdata('msg', 'order deleted successfully!');
        redirect('admin/orders');
    }
}
