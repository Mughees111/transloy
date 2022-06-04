<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * handles the holidays
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Holidays extends ADMIN_Controller {
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
        $this->redirect_role(5);
        $this->data['active'] = 'holiday';
        $this->load->model('holidays_model','holiday');
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

        $this->data['title'] = 'Holidays';
        $this->data['sub'] = 'holidays';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['holidays'] = $this->holiday->get_all_holidays();
        $this->data['content'] = $this->load->view('backend/holidays/listing',$this->data,true);
        $this->load->view('backend/common/template',$this->data);

    }

    public function cal()
    {

        $this->data['title'] = 'Holidays';
        $this->data['sub'] = 'holidays';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['holidays'] = $this->holiday->get_all_holidays();
        $this->data['content'] = $this->load->view('backend/holidays/cal',$this->data,true);
        $this->load->view('backend/common/template',$this->data);

    }
   
    public function add (){

        
        $input = "title";
        $this->form_validation->set_rules($input,'Title','trim|required');

        $input = "recurrent";
        $this->form_validation->set_rules($input,'Title','trim|required');

        $this->form_validation->set_message('required','This field is required.');

        if($this->form_validation->run() === false){
            $this->data['title'] = 'Add New Holiday';
            $this->data['sub'] = 'add-holiday';
            
            $this->data['content'] = $this->load->view('backend/holidays/add',$this->data,true);
            $this->load->view('backend/common/template',$this->data);

        }else{
           
            $input = "title";
            $dbData['title'] = $this->input->post($input);


            $input = "notif_title";
            $dbData['notif_title'] = $this->input->post($input);


            $input = "notif_description";
            $dbData['notif_description'] = $this->input->post($input);

            $input = "recurrent";
            $dbData['recurrent'] = $this->input->post($input)==1?1:0;


            $input = "monthly";
            $dbData['monthly'] = $this->input->post($input)==1?1:0;

            $input = "yearly";
            $dbData['yearly'] = $this->input->post($input)==1?1:0;

            $input = "date";
            $dbData['date'] = $this->input->post($input);

            $dbData['day'] = date("l",strtotime( $this->input->post($input) ));


            $dbData['created_at'] = date('Y-m-d H:i:s');
            $dbData['created_by'] = $this->session->userdata('admin_id');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
           
            $this->db->insert('holidays',$dbData);

            $id = $this->db->insert_id();

            $this->send_push($id);
          
            $this->session->set_flashdata('msg','New Holiday added successfully!');
            redirect('admin/holidays');
        }
    }

    private function send_push($id)
    {
        $holiday = $this->holiday->get_holiday_by_id($id);


        $users = $this->db->where("status",1)->where("is_deleted",0)->get("employees")->result_object();
        $final_notifs = array();
        foreach($users as $user)
        {
            if($user->push_id)
                $final_notifs[] = $user->push_id;
        }
        

        if(empty($final_notifs))
        {
            $this->session->set_flashdata('err', 'Notification was not sent!');
            return;
        }

        $notif["data"] = (Object) array();
        $notif["tag"] = "Updates";
        $notif["title"] =$holiday->notif_title;
        $notif["msg"] = $holiday->notif_description;

        foreach($final_notifs as $final_notif){
            try{
                push_notif($final_notif,$notif);
            }
            catch(Exception $e)
            {
                
            }
        }
        $this->session->set_flashdata('info', 'Notification was sent!');
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
        $result = $this->holiday->get_holiday_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
    
        $this->db->where('id',$id);
        $this->db->delete('holidays');
        $this->session->set_flashdata('msg', 'Holiday deleted successfully!');
        redirect('admin/holidays');
    }
   
}
