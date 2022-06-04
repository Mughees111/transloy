<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * handles the sites
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Sites extends ADMIN_Controller {
    /**
     * constructs ADMIN_Controller as parent object
     * loads the neccassary class
     * checks if current user has the rights to access this class
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
	function __construct()
	{
		parent::__construct();
		auth();
        $this->redirect_role(4);
        $this->data['active'] = 'site';
        $this->load->model('sites_model','site');
	}
    /**
     * loads the listing page
     * 
     * @return view listing view
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
	public function index()
	{

		$this->data['title'] = 'Sites';
        $this->data['sub'] = 'sites';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['sites'] = $this->site->get_all_sites();
		$this->data['content'] = $this->load->view('backend/sites/listing',$this->data,true);
		$this->load->view('backend/common/template',$this->data);

	}
    /**
     * loads the trash page
     * 
     * @return view trash
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function trash()
    {

        $this->data['title'] = 'Trash Sites';
        $this->data['sub'] = 'trash';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['sites'] = $this->site->get_all_trash_sites();
        $this->data['content'] = $this->load->view('backend/sites/trash',$this->data,true);
        $this->load->view('backend/common/template',$this->data);

    }
    /**
     * moves row from trash to back to listing page
     * 
     * @param  integer $id id of row in trash
     * @return redirect     back to trash view
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function restore($id){
        
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 0;
        $this->db->where('id',$id);
        $this->db->update('sites', $dbData);
        $this->session->set_flashdata('msg', 'site restored successfully!');
        redirect('admin/trash-sites');
    }
    /**
     * loads the add view, then handles the submitted data
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
	public function add (){

   
        $input = "title";
	    $this->form_validation->set_rules($input,'Title','trim|required|callback_check_site');

        $input = "image";
	    $this->form_validation->set_rules($input,'Image','callback_image_not_required['.$input.',20,20]');
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
	    if($this->form_validation->run() === false){
            $this->data['title'] = 'Add New Site';
            $this->data['sub'] = 'add-site';
            $this->data["jsfile"] = "js/add_site";
            
            $this->data['content'] = $this->load->view('backend/sites/add',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }else{
           
            $input = "title";
	        $dbData['title'] = $this->input->post($input);


            $input = "address";
            $dbData['address'] = $this->input->post($input);



            $input = "monday";
            $dbData['monday'] = $this->input->post($input);
            $input = "monday_opens";
            $dbData['monday_opens'] = $this->input->post($input);
            $input = "monday_closes";
            $dbData['monday_closes'] = $this->input->post($input);


            $input = "tuesday";
            $dbData['tuesday'] = $this->input->post($input);
            $input = "tuesday_opens";
            $dbData['tuesday_opens'] = $this->input->post($input);
            $input = "tuesday_closes";
            $dbData['tuesday_closes'] = $this->input->post($input);


            $input = "wednesday";
            $dbData['wednesday'] = $this->input->post($input);
            $input = "wednesday_opens";
            $dbData['wednesday_opens'] = $this->input->post($input);
            $input = "wednesday_closes";
            $dbData['wednesday_closes'] = $this->input->post($input);

            $input = "thursday";
            $dbData['thursday'] = $this->input->post($input);
            $input = "thursday_opens";
            $dbData['thursday_opens'] = $this->input->post($input);
            $input = "thursday_closes";
            $dbData['thursday_closes'] = $this->input->post($input);

            $input = "friday";
            $dbData['friday'] = $this->input->post($input);
            $input = "friday_opens";
            $dbData['friday_opens'] = $this->input->post($input);
            $input = "friday_closes";
            $dbData['friday_closes'] = $this->input->post($input);

            $input = "saturday";
            $dbData['saturday'] = $this->input->post($input);
            $input = "saturday_opens";
            $dbData['saturday_opens'] = $this->input->post($input);
            $input = "saturday_closes";
            $dbData['saturday_closes'] = $this->input->post($input);


            $input = "sunday";
            $dbData['sunday'] = $this->input->post($input);
            $input = "sunday_opens";
            $dbData['sunday_opens'] = $this->input->post($input);
            $input = "sunday_closes";
            $dbData['sunday_closes'] = $this->input->post($input);



            $input = "pickup_lat";
            $dbData['lat'] = $this->input->post($input);

            $input = "pickup_lng";
            $dbData['lng'] = $this->input->post($input);


            $input = "pickup_title";
            $dbData['long_address'] = $this->input->post($input);


           
            $input = "description";
	        $dbData['description'] = $this->input->post($input);

	        $dbData['created_at'] = date('Y-m-d H:i:s');
	        $dbData['created_by'] = $this->session->userdata('admin_id');
	        $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');

            $input = "image";
            if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
	        $image = $this->image_upload($input,'./resources/uploads/sites/','jpg|jpeg|png|gif');
	        if($image['upload'] == true || $_FILES[$input]['size']<1){
                $image = $image['data'];
                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                    $dbData['image'] = $image['file_name'];
                    $this->image_thumb($image['full_path'],'./resources/uploads/sites/actual_size/',10,10);
                }
                $this->db->insert('sites',$dbData);
                if($def_key==0)
                $def_key = $this->db->insert_id();
                $this->session->set_flashdata('msg','New site added successfully!');
                redirect('admin/sites');

            }else{
                $this->session->set_flashdata('err',$image["data"]);
                $this->data['title'] = 'Add New site';
                $this->data['sub'] = 'add-site';
                $this->data['content'] = $this->load->view('backend/sites/add',$this->data,true);
                $this->load->view('backend/common/template',$this->data);

                return;
            }
        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_site($title){

	    $result = $this->site->get_site_by_title($title);
	    if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $this->form_validation->set_message('check_site', 'This site already exist.');
                return false;
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_site', 'This field is required.');
            return false;
        }
    }

    /**
     * changes status of given id row in database
     * 
     * @param  integer $id     id of row in database
     * @param  integer $status new status to set
     * @return redirect        redirects to sucess page
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function status($id,$status){

        $result = $this->site->get_site_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $site_status = 1;

        if($status == 1){

            $site_status = 0;

        }

        $dbData['status'] = $site_status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id',$id);
        $this->db->update('sites',$dbData);
        $this->session->set_flashdata('msg','Site status updated successfully!');
        redirect('admin/sites');
    }
    /**
     * loads the add view, then handles the submitted data
     * 
     * @param integer $id id of row in database
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function edit($id){

        $result = $this->site->get_site_by_id($id);
        $this->data["the_id"] = $id;

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $this->data['data'] = $result;



        $input = "title";
        $this->form_validation->set_rules($input,'Title','trim|required|callback_check_site_edit['.$id.']');

        $input = "image";
        $this->form_validation->set_rules($input,'Image','callback_image_not_required['.$input.',20,20]');
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
        
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Edit site';


            $this->data["jsfile"] = "js/add_site";

            
            $this->data['content'] = $this->load->view('backend/sites/edit',$this->data,true);
             
            $this->load->view('backend/common/template',$this->data);
        }else{
          
           
            $dbData=array();
            

            $input = "title";
            $dbData['title'] = $this->input->post($input);

            $input = "address";
            $dbData['address'] = $this->input->post($input);


            $input = "monday";
            $dbData['monday'] = $this->input->post($input);
            $input = "monday_opens";
            $dbData['monday_opens'] = $this->input->post($input);
            $input = "monday_closes";
            $dbData['monday_closes'] = $this->input->post($input);


            $input = "tuesday";
            $dbData['tuesday'] = $this->input->post($input);
            $input = "tuesday_opens";
            $dbData['tuesday_opens'] = $this->input->post($input);
            $input = "tuesday_closes";
            $dbData['tuesday_closes'] = $this->input->post($input);


            $input = "wednesday";
            $dbData['wednesday'] = $this->input->post($input);
            $input = "wednesday_opens";
            $dbData['wednesday_opens'] = $this->input->post($input);
            $input = "wednesday_closes";
            $dbData['wednesday_closes'] = $this->input->post($input);

            $input = "thursday";
            $dbData['thursday'] = $this->input->post($input);
            $input = "thursday_opens";
            $dbData['thursday_opens'] = $this->input->post($input);
            $input = "thursday_closes";
            $dbData['thursday_closes'] = $this->input->post($input);

            $input = "friday";
            $dbData['friday'] = $this->input->post($input);
            $input = "friday_opens";
            $dbData['friday_opens'] = $this->input->post($input);
            $input = "friday_closes";
            $dbData['friday_closes'] = $this->input->post($input);

            $input = "saturday";
            $dbData['saturday'] = $this->input->post($input);
            $input = "saturday_opens";
            $dbData['saturday_opens'] = $this->input->post($input);
            $input = "saturday_closes";
            $dbData['saturday_closes'] = $this->input->post($input);


            $input = "sunday";
            $dbData['sunday'] = $this->input->post($input);
            $input = "sunday_opens";
            $dbData['sunday_opens'] = $this->input->post($input);
            $input = "sunday_closes";
            $dbData['sunday_closes'] = $this->input->post($input);



            $input = "pickup_lat";
            $dbData['lat'] = $this->input->post($input);

            $input = "pickup_lng";
            $dbData['lng'] = $this->input->post($input);

            $input = "pickup_title";

            if($this->input->post($input)!="")
            $dbData['long_address'] = $this->input->post($input);

            $input = "description";
            $dbData['description'] = $this->input->post($input);

            $dbData['created_at'] = date('Y-m-d H:i:s');
            $dbData['created_by'] = $this->session->userdata('admin_id');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
            
         

            $input = "image";
            if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
            $image = $this->image_upload($input,'./resources/uploads/sites/','jpg|jpeg|png|gif');
            if($image['upload'] == true || $_FILES[$input]['size']<1){
                $image = $image['data'];
                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                    $dbData['image'] = $image['file_name'];
                }
            }else{
                $this->session->set_flashdata('err',$image['upload']);
                redirect($_SERVER["HTTP_REFERER"]);
                return;
            }


            $this->db->where("id",$id);
            $this->db->update('sites',$dbData);


            $this->session->set_flashdata('msg','Site updated successfully!');
            redirect('admin/sites');

        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_site_edit($title,$id){

        $result = $this->site->get_site_by_title($title);
        if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $result = $result->row();
                if($result->id == $id){
                    return true;
                }else{
                    $this->form_validation->set_message('check_site_edit', 'This site already exist.');
                    return false;
                }
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_site_edit', 'This field is required.');
            return false;
        }
    }
    /**
     * deletes the row in database and moves it to trash
     * 
     * @param  integer $id id of row to move to trash
     * @return redirect     back to listing page
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function delete($id){
        $result = $this->site->get_site_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id',$id);
        $this->db->update('sites', $dbData);
        $this->session->set_flashdata('msg', 'Site deleted successfully!');
        redirect('admin/sites');
    }
    public function display_order()
    {
        
        if(isset($_POST["order_val"]))
        {
            $order = $this->input->post("order_val");
            $order = explode(",",$order);
            
            
            $i = 1;
            foreach($order as $or)
            {
                $this->db->where("id",$or)->update("sites",array("ord"=>$i));
                 
                $i++;
            }
            $this->session->set_flashdata('msg', 'Sites order updated successfully!');
            redirect('admin/sites');
        }            
        else
        {
        
            $this->data['title'] = 'Order Sites';
            $this->data['sub'] = 'sites';
            $this->data['js'] = 'listing';
            $this->data['jsfile'] = 'js/sites_order';
            $this->data['sites'] = $this->site->get_all_sites("ord","ASC")->result_object();
            $this->data['content'] = $this->load->view('backend/sites/order',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }

    }

    public function d_p($id){
        $this->db->where('id',$id);
        $this->db->delete('sites');
        $this->session->set_flashdata('msg', 'site removed successfully!');
        redirect('admin/trash-sites');
    }
}
