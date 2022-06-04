<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * handles the teams
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Teams extends ADMIN_Controller {
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
        $this->data['active'] = 'team';
        $this->load->model('teams_model','team');
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

		$this->data['title'] = 'Teams';
        $this->data['sub'] = 'teams';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['teams'] = $this->team->get_all_teams();
		$this->data['content'] = $this->load->view('backend/teams/listing',$this->data,true);
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

        $this->data['title'] = 'Trash Teams';
        $this->data['sub'] = 'trash';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['teams'] = $this->team->get_all_trash_teams();
        $this->data['content'] = $this->load->view('backend/teams/trash',$this->data,true);
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
        $this->db->update('teams', $dbData);
        $this->session->set_flashdata('msg', 'team restored successfully!');
        redirect('admin/trash-teams');
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
	    $this->form_validation->set_rules($input,'Title','trim|required|callback_check_team');

        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
	    if($this->form_validation->run() === false){
            $this->data['title'] = 'Add New team';
            $this->data['sub'] = 'add-team';
            $this->data["jsfile"] = "js/add_team";
            
            $this->data['content'] = $this->load->view('backend/teams/add',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }else{
           
            $input = "title";
	        $dbData['title'] = $this->input->post($input);



           
            $input = "description";
	        $dbData['description'] = $this->input->post($input);

	        $dbData['created_at'] = date('Y-m-d H:i:s');
	        $dbData['created_by'] = $this->session->userdata('admin_id');
	        $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');


            $this->db->insert('teams',$dbData);


            $team_id = $this->db->insert_id();

            $this->db->where("team_id",$team_id)->delete("team_users");
            foreach($this->input->post("users") as $user_id)
            {
                $this->db->insert("team_users",array(
                    "team_id"=>$team_id,
                    "user_id"=>$user_id
                ));
            }


            $this->db->where("team_id",$team_id)->delete("team_departments");
            foreach($this->input->post("departments") as $user_id)
            {
                $this->db->insert("team_departments",array(
                    "team_id"=>$team_id,
                    "department_id"=>$user_id
                ));
            }

            $this->db->where("team_id",$team_id)->delete("team_sites");
            foreach($this->input->post("sites") as $user_id)
            {
                $this->db->insert("team_sites",array(
                    "team_id"=>$team_id,
                    "site_id"=>$user_id
                ));
            }


            $this->session->set_flashdata('msg','New team added successfully!');
            redirect('admin/teams');
        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_team($title){

	    $result = $this->team->get_team_by_title($title);
	    if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $this->form_validation->set_message('check_team', 'This team already exist.');
                return false;
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_team', 'This field is required.');
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

        $result = $this->team->get_team_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $team_status = 1;

        if($status == 1){

            $team_status = 0;

        }

        $dbData['status'] = $team_status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id',$id);
        $this->db->update('teams',$dbData);
        $this->session->set_flashdata('msg','team status updated successfully!');
        redirect('admin/teams');
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

        $result = $this->team->get_team_by_id($id);
        $this->data["the_id"] = $id;

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $this->data['data'] = $result;



        $input = "title";
        $this->form_validation->set_rules($input,'Title','trim|required|callback_check_team_edit['.$id.']');

        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
        
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Edit team';


            $this->data["jsfile"] = "js/add_team";

            
            $this->data['content'] = $this->load->view('backend/teams/edit',$this->data,true);
             
            $this->load->view('backend/common/template',$this->data);
        }else{
          
           
            $dbData=array();
            

            $input = "title";
            $dbData['title'] = $this->input->post($input);

           

            $input = "description";
            $dbData['description'] = $this->input->post($input);

            $dbData['created_at'] = date('Y-m-d H:i:s');
            $dbData['created_by'] = $this->session->userdata('admin_id');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
            
            $this->db->where("id",$id);
            $this->db->update('teams',$dbData);


            $team_id = $id;

            $this->db->where("team_id",$team_id)->delete("team_users");
            foreach($this->input->post("users") as $user_id)
            {
                $this->db->insert("team_users",array(
                    "team_id"=>$team_id,
                    "user_id"=>$user_id
                ));
            }

            $this->db->where("team_id",$team_id)->delete("team_departments");
            foreach($this->input->post("departments") as $user_id)
            {
                $this->db->insert("team_departments",array(
                    "team_id"=>$team_id,
                    "department_id"=>$user_id
                ));
            }

            $this->db->where("team_id",$team_id)->delete("team_sites");
            foreach($this->input->post("sites") as $user_id)
            {
                $this->db->insert("team_sites",array(
                    "team_id"=>$team_id,
                    "site_id"=>$user_id
                ));
            }

            $this->session->set_flashdata('msg','team updated successfully!');
            redirect('admin/teams');
        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_team_edit($title,$id){

        $result = $this->team->get_team_by_title($title);
        if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $result = $result->row();
                if($result->id == $id){
                    return true;
                }else{
                    $this->form_validation->set_message('check_team_edit', 'This team already exist.');
                    return false;
                }
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_team_edit', 'This field is required.');
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
        $result = $this->team->get_team_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id',$id);
        $this->db->update('teams', $dbData);
        $this->session->set_flashdata('msg', 'team deleted successfully!');
        redirect('admin/teams');
    }
   

    public function d_p($id){
        $this->db->where('id',$id);
        $this->db->delete('teams');
        $this->session->set_flashdata('msg', 'team removed successfully!');
        redirect('admin/trash-teams');
    }
}
