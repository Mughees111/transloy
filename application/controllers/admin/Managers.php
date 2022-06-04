<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * handles the admins
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Managers extends ADMIN_Controller {
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

        $this->redirect_role(3);
        $this->data['active'] = 'managers';
        $this->load->model('admins_model','admin');
        $this->load->model('location_model','location');
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

		$this->data['title'] = 'Managers';
        $this->data['sub'] = 'admins';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['admins'] = $this->db->where("is_deleted",0)->get("admin");
		$this->data['content'] = $this->load->view('backend/managers/listing', $this->data,true);
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
        $this->data['title'] = 'Trash Managers';
        $this->data['sub'] = 'trash-admins';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['admins'] = $this->admin->get_all_trashed_admins();
        $this->data['content'] = $this->load->view('backend/managers/trash', $this->data,true);
        $this->load->view('backend/common/template',$this->data);
    }
    /**
     * loads the add view, then handles the submitted data
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
	public function add (){

	    $this->form_validation->set_rules('fname','Name','trim|required');
	    $this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_check_email');
        $this->form_validation->set_rules('password','Password','trim|required');

        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
	    if($this->form_validation->run() === false){
            $this->data['title'] = 'Add New Admin';
            $this->data['sub'] = 'add-admin';
            if($_GET['replicate']==1)
            {
                $this->data['prev'] = $this->db->where('is_deleted',0)
                ->order_by('id',"DESC")
                ->get('admin')->result_object()[0];
               
            }
            $this->data['content'] = $this->load->view('backend/managers/add',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }else{

	        $dbData['name'] = $this->input->post('fname');
            $dbData['email'] = $this->input->post('email');
            $dbData['password'] = md5($this->input->post('password'));

            $dbData["type"]=2;
	       
	        $dbData['created_at'] = date('Y-m-d H:i:s');
	        $dbData['created_by'] = $this->session->userdata('admin_id');
	        $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
            $this->db->insert('admin',$dbData);
            $this->session->set_flashdata('msg','New Admin added successfully!');




            $this->load->library('email');

            // prepare email
            $this->email
                ->from(settings()->email, settings()->site_title)
                ->to($dbData['email'])
                ->subject("Welcome Onboard")
                ->message("Admin just created your account as a manager on ".settings()->site_title.", your login details are:<br> Your username is: <br> <span style='background:#f5f5f5;padding:5px;'>".$dbData['email']."</span> <br> Your password is: <br> <span style='background:#f5f5f5;padding:5px;'>".$this->input->post('password')."</span> <br> <b>You can login on the app")
                ->set_mailtype('html');

            // send email
            $this->email->send();


            redirect('admin/managers');

        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_email($email){

	    $result = $this->admin->get_admin_by_email($email);
	    if(!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('check_email', 'Please enter the valid email address.');
                return false;
            }else{
                if ($result->num_rows() > 0) {
                    $this->form_validation->set_message('check_email', 'This email already exist.');
                    return false;
                } else {
                    return true;
                }
            }

        }else{
            $this->form_validation->set_message('check_email', 'This field is required.');
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

        $result = $this->admin->get_admin_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $client_status = 1;

        if($status == 1){

            $client_status = 0;

        }

        $dbData['status'] = $client_status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id',$id);
        $this->db->update('admin',$dbData);
        $this->session->set_flashdata('msg','Admin status updated successfully!');
        redirect('admin/managers');
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

        $result = $this->admin->get_admin_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $this->data['data'] = $result;
        $this->form_validation->set_rules('fname','Name','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_check_email_edit['.$id.']');
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Edit Manager';
            $this->data['sub'] = 'edit-admin';
            $this->data['jsfile'] = 'add_admin';
            $this->data['countries'] = $this->location->get_all_countries('name','ASC');
            $this->data['content'] = $this->load->view('backend/managers/edit',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }else{

            $dbData['name'] = $this->input->post('fname');
            $dbData['email'] = $this->input->post('email');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
            $this->db->where('id',$id);
            $this->db->update('admin', $dbData);
            $this->session->set_flashdata('msg', 'Manager updated successfully!');
            redirect('admin/managers');

        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_email_edit($email,$id){

        $result = $this->admin->get_admin_by_email($email);
        if(!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('check_email_edit', 'Please enter the valid email address.');
                return false;
            }else{
                if ($result->num_rows() > 0) {
                    $result = $result->row();
                    if($result->id == $id){
                        return true;
                    }else{
                        $this->form_validation->set_message('check_email_edit', 'This email already exist.');
                        return false;
                    }
                } else {
                    return true;
                }
            }

        }else{
            $this->form_validation->set_message('check_email_edit', 'This field is required.');
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
        $result = $this->admin->get_admin_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id',$id);
        $this->db->update('admin', $dbData);
        $this->session->set_flashdata('msg', 'Admin deleted successfully!');
        redirect('admin/managers');
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
        $this->db->update('admin', $dbData);
        $this->session->set_flashdata('msg', 'Manager restored successfully!');
        redirect('admin/trash-managers');
    }
    
	
    /**
     * provides view to change roles of admin
     * 
     * @param  integer $id id of admin to change roles
     * @return [redirect|view]     view to change the admin roles, redirect 
     * upon success
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function edit_admin_roles($id)
    {
        $result = $this->admin->get_admin_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $this->data['data'] = $result;
        $this->data['roles']=$this->db->where('admin_id',$id)->get('admin_roles')->result_object();

        if(isset($_POST['roles']))
        {
            $this->db->where('admin_id',$id)->delete('admin_roles');


            foreach($_POST['roles'] as $role)
            {
                $dbData['admin_id'] = $id;
                $dbData['role'] = $role;
                $dbData['role_name'] = get_role_name($role);
                $this->db->insert('admin_roles', $dbData);
                $this->session->set_flashdata('msg', 'Manager updated successfully!');
            }
            redirect('admin/managers');

        }
        else
        {
            $this->data['content'] = $this->load->view('backend/managers/roles',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }
    }
	
}
