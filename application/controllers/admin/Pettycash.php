<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pettycash extends ADMIN_Controller
{
    function __construct()
    {
        parent::__construct();
        auth();
        $this->redirect_role(8);

        $this->data['active'] = 'petty_cash';
        $this->load->model('pettycash_model', 'pettycash');
    }

    public function index()
    {
        $this->data['data'] = $this->pettycash->getEveryRecord();
        $this->data['title'] = 'Petty Cash';
        $this->data['sub'] = 'petty_cash_inside';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['content'] = $this->load->view('backend/pettyCash/index', $this->data,true);
        $this->load->view('backend/common/template',$this->data);
    }

    public function status($id,$status)
    {
        $result = $this->db->where("id",$id)->get("pettycash_form")->result_object()[0];

        if(!$result){
            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');
        }

        if($result->status != 0)
        {
            // already approved/rejected from mobile app
            $this->session->set_flashdata('err','Allowance status has already been changed - Refreshing page');
            redirect('admin/pettycash');
        }

        $target_user = $this->db->where("id",$result->user_id)->get("employees")->result_object()[0];

        // update status and approve/rejected by 
        $this->db->where("id",$id)->update("pettycash_form",array("status"=>$status,"approved_by"=>0,"updated_at"=>date("Y-m-d H:i:s")));

        // prepare notification
        $actionText1="";
        $actionText2="";

        if($status == 1)
        {
            $actionText1 = $actionText1 . "Allowance Approved";
            $actionText2 = $actionText2 . "Your Allowance request has been approved by admin";

        }else{
            $actionText1 = $actionText1 . "Allowance Rejected";
            $actionText2 = $actionText2 . "Your Allowance request has been rejected by admin";
        }

        if($target_user->push_id!="")
        {
            try
            {
                $notif["data"] = (Object) array();
                $notif["tag"] = "Updates";
                $notif["title"] = $actionText1;
                $notif["msg"] = $actionText2;

                push_notif($target_user->push_id,$notif);
                $this->db->insert("pushes",array(
                    "user_id"=>$target_user->id,
                    "created_at"=>date("Y-m-d H:i:s"),
                    "title"=>$notif['title'],
                    "body"=>$notif['msg'],
                    "read"=>0
                ));
    
            }catch(Exception $exc)
            {
    
            }

            $this->session->set_flashdata('msg','Allowance status updated successfully!');
            redirect('admin/pettycash');
        }
    }

    
}