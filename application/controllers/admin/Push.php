<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  ini_set('display_errors', 1);

/**
 * handles the Push
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Push extends ADMIN_Controller {
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
        // check_role(1);
        $this->redirect_role(1);
        $this->data['active'] = 'push';
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
		$this->data['title'] = 'Push Notifications';
        $this->data['sub'] = 'push';
        $this->data['jsfile'] = 'js/push';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';

		$this->data['content'] = $this->load->view('backend/push/send',$this->data,true);
		$this->load->view('backend/common/template',$this->data);
	}

     public function delete($id){
        
        $this->db->where('id',$id);
        $this->db->delete('pushes');
        $this->session->set_flashdata('msg', 'Leave deleted successfully!');
        redirect($_SERVER["HTTP_REFERER"]);
    }
	
	public function send()
	{
	    $title = $this->input->post("title");
        $body = $this->input->post("short_description");


        $user_ids = $this->input->post("users");

        if(!empty($user_ids))
            $users = $this->db->where("status",1)->where("is_deleted",0)->where_in("id",$user_ids)->get("employees")->result_object();


        if($this->input->post("all_users")==1)
        {
            $users = $this->db->where("status",1)->where("is_deleted",0)->get("employees")->result_object();
        }
        foreach($users as $user)
        {
            if($user->push_id){
                $final_notifs[] = $user->push_id;
               
            }
             $final_user_ids[] = $user->id;

        }


        foreach($this->input->post("all_sites") as $key=>$value)
        {
            $users = $this->db->where("status",1)->where("is_deleted",0)->where("site",$value)->get("employees")->result_object();

            foreach($users as $user)
            {
                if($user->push_id){
                    $final_notifs[] = $user->push_id;
                    
                }
                $final_user_ids[] = $user->id;
            }
        }
        

        // if(empty($final_notifs))
        // {
        //     $this->session->set_flashdata('msg', 'Notification was not sent!');
        //     redirect($_SERVER["HTTP_REFERER"]);
        //     return;
        // }


        $notif["data"] = (Object) array();
        $notif["tag"] = "Updates";
        $notif["title"] =$title;
        $notif["msg"] = $body;

        foreach($final_notifs as $final_notif){
            try{
              
                //    echo "<pre>";
                //    echo "Push id: ".$final_notif. "<br>";
                //    print_r($notif);
                //    echo "Notification: ".$notif ."<br>";
                // exit;
                push_notif($final_notif,$notif);
            }
            catch(Exception $e)
            {
             
            }
        }

        foreach($final_user_ids as $user_id)
        {
 
            $this->db->insert("pushes",array(
                "user_id"=>$user_id,
                "created_at"=>date("Y-m-d H:i:s"),
                "title"=>$title,
                "body"=>$body,
                "read"=>0
            ));
        }

        $this->session->set_flashdata('msg', 'Notification sent successfully!');
        redirect($_SERVER["HTTP_REFERER"]);
	}
}
