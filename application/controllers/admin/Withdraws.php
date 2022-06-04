<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * handles the Withdraws
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Withdraws extends ADMIN_Controller {
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
        check_role(14);
        $this->data['active'] = 'withdraw';
        $this->load->model('withdraws_model','withdraw');
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
		$this->data['title'] = 'withdraws';
        $this->data['sub'] = 'withdraws';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['withdraws'] = $this->withdraw->get_all_withdraws("id","DESC");
		$this->data['content'] = $this->load->view('backend/withdraws/listing',$this->data,true);
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
    public function status($id,$status){

        $result = $this->withdraw->get_withdraw_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }


        $dbData['status'] = $status;


        if($status==1)
        {
            $driver = $this->db->where("id",$result->user_id)->get("users")->result_object()[0];
            $this->db->where("id",$result->user_id)->update("users",array("balance"=> ($driver->balance) - $result->amount ));

        }

        $this->db->where('id',$id);
        $this->db->update('withdraws',$dbData);
        $this->session->set_flashdata('msg','withdraw status updated successfully!');
        redirect('admin/withdraws');
    }
    
}
