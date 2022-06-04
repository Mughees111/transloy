<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * handles the parties
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Parties extends ADMIN_Controller {
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
        $this->data['active'] = 'party';
        $this->load->model('parties_model','party');
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

        $this->data['title'] = 'Parties';
        $this->data['sub'] = 'parties';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['parties'] = $this->party->get_all_parties();
        $this->data['content'] = $this->load->view('backend/parties/listing',$this->data,true);
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

        $this->data['title'] = 'Trash Parties';
        $this->data['sub'] = 'trash';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['parties'] = $this->party->get_all_trash_parties();
        $this->data['content'] = $this->load->view('backend/parties/trash',$this->data,true);
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
        
        $dbData['is_deleted'] = 0;
        $this->db->where('id',$id);
        $this->db->update('parties', $dbData);
        $this->session->set_flashdata('msg', 'party restored successfully!');
        redirect('admin/trash-parties');
    }
    /**
     * loads the add view, then handles the submitted data
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function add (){
        $this->shutdown_function();
        $dlang = dlang();
        $langs = langs();
        $input = $dlang->slug."[title]";
        $this->form_validation->set_rules($input,'Title','trim|required|callback_check_party');

        $input = $dlang->slug."[image]";
        $this->form_validation->set_rules($input,'Image','callback_image_not_required['.$input.',20,20]');
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Add New party';
            $this->data['sub'] = 'add-party';
            $this->data['parties'] = $this->db->where('is_deleted',0)
            ->where('parent',0)
            ->where('lparent',0)
            ->get('parties');
            if(isset($_GET['replicate']))
            {
                $this->data['prev'] = $this->db->where('is_deleted',0)
                ->where('id',$_GET['replicate'])
                ->get('parties')->result_object()[0];
               
            }
            $this->data['meta'] = $this->load->view('backend/common/meta_data',$this->data,true);
            $this->data['content'] = $this->load->view('backend/parties/add',$this->data,true);
            $this->load->view('backend/common/template',$this->data);
        }else{
            $def_key=0;
            $def_parent=0;
            $fault = false;
            foreach($langs as $key=>$lang){
                $input = $lang->slug."[title]";
                $dbData['title'] = $this->input->post($input);


                $input = $lang->slug."[sale_title]";
                $dbData['sale_title'] = $this->input->post($input);

                $input = $lang->slug."[sale_subtitle]";
                $dbData['sale_subtitle'] = $this->input->post($input);

                $input = $lang->slug."[title]";
                $dbData['slug'] = slug($this->input->post($input));
                $input = $lang->slug."[description]";
                $dbData['description'] = $this->input->post($input);
                $input = $lang->slug."[meta_title]";
                $dbData['meta_title'] = $this->input->post($input);
                $input = $lang->slug."[meta_keys]";
                $dbData['meta_keywords '] = $this->input->post($input);
                $input = $lang->slug."[meta_desc]";
                $dbData['meta_description'] = $this->input->post($input);
                $dbData['created_at'] = date('Y-m-d H:i:s');
                $dbData['created_by'] = $this->session->userdata('admin_id');
                $dbData['updated_at'] = date('Y-m-d H:i:s');
                $dbData['updated_by'] = $this->session->userdata('admin_id');
                $input = $lang->slug."[parent]";
               



                $dbData["lparent"] = $def_key;
                $dbData["lang_id"] = $lang->id;




                $input = $lang->slug."_sale_banner";
                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
                $image = $this->image_upload($input,'./resources/uploads/parties/','jpg|jpeg|png|gif');
                if($image['upload'] == true || $_FILES[$input]['size']<1){
                    $image = $image['data'];
                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $dbData['sale_banner'] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/parties/actual_size/',10,10);
                    }
                    
                    
                    
                }else{
                    $fault=true;
                }



                $input = $lang->slug."_image";
                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
                $image = $this->image_upload($input,'./resources/uploads/parties/','jpg|jpeg|png|gif');
                if($image['upload'] == true || $_FILES[$input]['size']<1){
                    $image = $image['data'];
                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $dbData['image'] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/parties/actual_size/',10,10);
                    }
                    
                    $this->db->insert('parties',$dbData);
                    if($def_key==0)
                    $def_key = $this->db->insert_id();
                    
                }else{
                    $fault=true;
                }
            }

            if($fault){
                $this->session->set_flashdata('err','An Error occurred durring uploading image, please try again');
                redirect('admin/add-party');
                return;
            }
            $this->session->set_flashdata('msg','New party added successfully!');
            redirect('admin/parties');

        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_party($title){

        $result = $this->party->get_party_by_title($title);
        if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $this->form_validation->set_message('check_party', 'This party already exist.');
                return false;
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_party', 'This field is required.');
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

        $result = $this->party->get_party_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $party_status = 1;

        if($status == 1){

            $party_status = 0;

        }

        $dbData['status'] = $party_status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id',$id);
        $this->db->update('parties',$dbData);
        $this->session->set_flashdata('msg','party status updated successfully!');
        redirect('admin/parties');
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
        $this->shutdown_function();
        $result = $this->party->get_party_by_id($id);
        $this->data["the_id"] = $id;

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        $this->data['data'] = $result;



        $dlang = dlang();
        $langs = langs();
        $input = $dlang->slug."[title]";
        $this->form_validation->set_rules($input,'Title','trim|required|callback_check_party_edit['.$id.']');

        $input = $dlang->slug."[image]";
        $this->form_validation->set_rules($input,'Image','callback_image_not_required['.$input.',20,20]');
        $this->form_validation->set_message('required','This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces','Only alphabet and numbers are allowed.');
        
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Edit party';
            $this->data['meta'] = $this->load->view('backend/common/meta_data',$this->data,true);
            $this->data['parties'] = $this->db->where('is_deleted',0)
            ->where('parent',0)
            ->where('lparent',0)
            ->get('parties');
            $this->data['content'] = $this->load->view('backend/parties/edit',$this->data,true);
             
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


                $input = $lang->slug."[sale_title]";
                $dbData['sale_title'] = $this->input->post($input);

                $input = $lang->slug."[sale_subtitle]";
                $dbData['sale_subtitle'] = $this->input->post($input);

                $input = $lang->slug."[title]";
                $dbData['slug'] = slug($this->input->post($input));
                $input = $lang->slug."[description]";
                $dbData['description'] = $this->input->post($input);
                $input = $lang->slug."[meta_title]";
                $dbData['meta_title'] = $this->input->post($input);
                $input = $lang->slug."[meta_keys]";
                $dbData['meta_keywords '] = $this->input->post($input);
                $input = $lang->slug."[meta_desc]";
                $dbData['meta_description'] = $this->input->post($input);
                $dbData['created_at'] = date('Y-m-d H:i:s');
                $dbData['created_by'] = $this->session->userdata('admin_id');
                $dbData['updated_at'] = date('Y-m-d H:i:s');
                $dbData['updated_by'] = $this->session->userdata('admin_id');
                $input = $lang->slug."[parent]";
                if($key==0){
                    $dbData['parent'] = $this->input->post($input)?$this->input->post($input):0;
                    $def_parent = $dbData['parent'];
                }
                else{
                    $dbData['parent'] = $def_parent;
                }
                // $dbData["lparent"] = $def_key;
                // $dbData["lang_id"] = $lang->id;


                $input = $lang->slug."_sale_banner";
                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
                $image = $this->image_upload($input,'./resources/uploads/parties/','jpg|jpeg|png|gif');
                if($image['upload'] == true || $_FILES[$input]['size']<1){
                    $image = $image['data'];
                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $dbData['sale_banner'] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/parties/actual_size/',10,10);
                    }
                }else{
                    if($lang->is_default==1){
                         $this->session->set_flashdata('err',$error);
                        redirect($_SERVER["HTTP_REFERER"]);
                        return;
                    }
                }



                $input = $lang->slug."_image";
                if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0))
                $image = $this->image_upload($input,'./resources/uploads/parties/','jpg|jpeg|png|gif');
                if($image['upload'] == true || $_FILES[$input]['size']<1){
                    $image = $image['data'];
                    if((isset($_FILES[$input]) && $_FILES[$input]['size'] > 0)){
                        $dbData['image'] = $image['file_name'];
                        $this->image_thumb($image['full_path'],'./resources/uploads/parties/actual_size/',10,10);
                    }
                }else{
                    if($lang->is_default==1){
                         $this->session->set_flashdata('err',$error);
                        redirect($_SERVER["HTTP_REFERER"]);
                        return;
                    }
                }
                $this->db->where("id",$row_id);
                $this->db->update('parties',$dbData);
            }

            $this->session->set_flashdata('msg','party updated successfully!');
            redirect('admin/parties');

        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_party_edit($title,$id){

        $result = $this->party->get_party_by_title($title);
        if(!empty($title)) {
            if ($result->num_rows() > 0) {
                $result = $result->row();
                if($result->id == $id){
                    return true;
                }else{
                    $this->form_validation->set_message('check_party_edit', 'This party already exist.');
                    return false;
                }
            } else {
                return true;
            }
        }else{
            $this->form_validation->set_message('check_party_edit', 'This field is required.');
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


        $result = $this->party->get_party_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $dbData['is_deleted'] = 1;
        $this->db->where('id',$id);
        $this->db->update('parties', $dbData);
        $this->session->set_flashdata('msg', 'party deleted successfully!');
        redirect('admin/parties');
    }
    public function display_order()
    {
        $this->shutdown_function();
        // $result = $this->party->get_party_display_order();

        // if(!$result){

        //     $this->session->set_flashdata('err','Invalid request.');
        //     redirect('admin/404_page');

        // }

        $this->data['data'] = $result;
        $this->form_validation->set_rules('json_order','Title','trim|required');
       
        if($this->form_validation->run() === false){
            $this->data['title'] = 'Edit parties Display Order';
            $this->data['jsfile'] = "js/partys_display_order";
            $this->data['parties'] = $this->db->where('is_deleted',0)
            ->order_by('display_priority',"ASC")
            ->where('parent',0)
            ->get('parties');

            $this->data['content'] = $this->load->view('backend/parties/display_order',$this->data,true);
             
            $this->load->view('backend/common/template',$this->data);
        }else{


            $json_order = $this->input->post('json_order');
            $json_order = json_decode($json_order);
            $i = 1;
            foreach ($json_order as $json_order_key => $json_order_value) {
                $this->db->where('id',$json_order_value->id)
                ->update('parties',array(
                    'parent'=>0,
                    'display_priority'=>$i
                ));
                $i++;

                foreach($json_order_value->children as $child)
                {
                    $this->db->where('id',$child->id)->update('parties',array('parent'=>$json_order_value->id,'display_priority'=>$i));
                    $i++;
                }
            }
            
            // $this->db->where('id',$id);
            // $this->db->update('parties', $dbData);
            $this->session->set_flashdata('msg', 'party updated successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        }
    }
    public function details($id)
    {       
        $result = $this->party->get_party_by_id($id);

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }
        $this->data['title'] = 'Party Detail';
        $this->data['party'] = $result;

        $this->data['content'] = $this->load->view('backend/parties/detail',$this->data,true);
        $this->load->view('backend/common/template',$this->data);
        
        
    }
    public function payment_details($id)
    {

        $this->data['title'] = 'Party Participants';
        $this->data['sub'] = 'parties';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/invites_listing';
        $this->data['invites'] = $this->db->where("party_id",$id)->where("status",1)->get("party_invites");
        $this->data['content'] = $this->load->view('backend/parties/payment_details',$this->data,true);
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
    public function release_all($id){

        

        $this->db->where("id",$id)->update("parties",array("ended"=>1,"ended_at"=>date("Y-m-d H:i:s")));

       
       $reqs = $this->db->where("party_id",$id)->where("status",1)->get("party_invites")->result_object();

       foreach($reqs as $req){

            if($req->payment_done==1) continue;

            $reward =  $req->amount;
            // $reward = $req->amount - $reward;
            $bacha = $this->db->where("id",$req->user_id)->get("users")->result_object()[0];


            if($req->self_invited==1){
                $the_party = $this->db->where("id",$req->party_id)->where("is_deleted",0)->get("parties")->result_object()[0];

                if($the_party)
                {
                    $bacha = $this->db->where("id",$the_party->user_id)->get("users")->result_object()[0];


                    $this->db->where("id",$bacha->id)->update("users",array("balance"=>(
                    $bacha->balance + $reward
                    )));


                    $this->db->where('id',$req->id);
                    $this->db->update('party_invites',array("payment_done"=>1,"payment_amount"=>$reward));
                }
            }
            else{
                $this->db->where("id",$req->user_id)->update("users",array("balance"=>(
                    $bacha->balance + $reward
                )));

                $this->db->where('id',$req->id);
                $this->db->update('party_invites',array("payment_done"=>1,"payment_amount"=>$reward));
            }
       }
        redirect('admin/parties');
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
    public function release_one($id){

        $result = $this->db->where("id",$id)->get("party_invites")->result_object()[0];
        $party = $this->db->where("id",$result->party_id)->where("is_deleted",0)->get("parties")->result_object()[0];

        if(!$result || !$party){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        if($result->payment_done==0){




            if($result->self_invited==1){
               

              

                $old_balance = $this->db->where("id",$party->user_id)->get("users")->result_object()[0];

                $this->db->where("id",$party->user_id)->update("users",array("balance"=>$old_balance->balance+$result->amount));

            }
            else{

                $old_balance = $this->db->where("id",$result->user_id)->get("users")->result_object()[0];

                $this->db->where("id",$result->user_id)->update("users",array("balance"=>$old_balance->balance+$result->amount));
            }


            $this->db->where('id',$id);
            $this->db->update('party_invites',array("payment_done"=>1,"payment_amount"=>$result->amount));

            $this->session->set_flashdata('msg','Done!');
        }
        redirect('admin/parties/payment_details/'.$party->id);
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
    public function refund_one($id){

        $result = $this->db->where("id",$id)->get("party_invites")->result_object()[0];
        $party = $this->db->where("id",$result->party_id)->get("parties")->result_object()[0];

        if(!$result){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');

        }

        if($result->payment_done==0){

            $old_balance = $this->db->where("id",$result->invited_by)->get("users")->result_object()[0];

            $this->db->where("id",$result->invited_by)->update("users",array("balance"=>$old_balance->balance+$result->amount));


            $this->db->where('id',$id);
            $this->db->delete('party_invites');
            $this->session->set_flashdata('msg','Done!');
        }
        redirect('admin/parties/payment_details/'.$party->id);
    }
}
