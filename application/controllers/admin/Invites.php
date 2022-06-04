<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * handles the invites
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Invites extends ADMIN_Controller {
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
        $this->data['active'] = 'invites';
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

        $this->data['title'] = 'Party Invites';
        $this->data['sub'] = 'invites';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['invites'] = $this->db->get("party_invites");
        $this->data['content'] = $this->load->view('backend/invites/listing',$this->data,true);
        $this->load->view('backend/common/template',$this->data);

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
    public function refund($id){

        $result = $this->db->where("id",$id)->get("party_invites")->result_object()[0];
        $party = $this->db->where("id",$result->party_id)->get("parties")->result_object()[0];

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $old_balance = $this->db->where("id",$result->invited_by)->get("users")->result_object()[0];

        $this->db->where("id",$result->invited_by)->update("users",array("balance"=>$old_balance+$result->amount));


        $this->db->where('id',$id);
        $this->db->delete('party_invites');
        $this->session->set_flashdata('msg','Done!');
        redirect('admin/invites');
    }
}
