<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * handles the departments
 * 
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Departments extends ADMIN_Controller
{
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
        $this->data['active'] = 'department';
        $this->load->model('departments_model', 'department');
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

        $this->data['title'] = 'Departments';
        $this->data['sub'] = 'departments';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['departments'] = $this->department->get_all_departments();
        $this->data['content'] = $this->load->view('backend/departments/listing', $this->data, true);
        $this->load->view('backend/common/template', $this->data);
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

        $this->data['title'] = 'Trash Departments';
        $this->data['sub'] = 'trash';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['departments'] = $this->department->get_all_trash_departments();
        $this->data['content'] = $this->load->view('backend/departments/trash', $this->data, true);
        $this->load->view('backend/common/template', $this->data);
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
    public function restore($id)
    {

        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 0;
        $this->db->where('id', $id);
        $this->db->update('departments', $dbData);
        $this->session->set_flashdata('msg', 'Department restored successfully!');
        redirect('admin/trash-departments');
    }
    /**
     * loads the add view, then handles the submitted data
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function add()
    {


        $input = "title";
        $this->form_validation->set_rules($input, 'Title', 'trim|required|callback_check_department');

        $this->form_validation->set_message('required', 'This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces', 'Only alphabets and numbers are allowed.');
        if ($this->form_validation->run() === false) {
            $this->data['title'] = 'Add New department';
            $this->data['sub'] = 'add-department';
            $this->data["jsfile"] = "js/add_department";
            $this->data['categories'] = $this->db->where('is_deleted', 0)
                ->get('departments');

            $this->data['content'] = $this->load->view('backend/departments/add', $this->data, true);
            $this->load->view('backend/common/template', $this->data);
        } else {

            $input = "title";
            $dbData['title'] = $this->input->post($input);




            $input = "description";
            $dbData['description'] = $this->input->post($input);
            $input = "parent";
            $dbData['parent'] = $this->input->post($input);

            $input = "approves_leaves";
            $dbData['approves_leaves'] = $this->input->post($input) == 1 ? 1 : 0;
            $input = "can_approve_leaves";
            $dbData['dep_can_approve_leaves'] = $this->input->post($input) == 1 ? 1 : 0;
            $input = "can_approve_allowance";
            $dbData['dep_can_approve_allowance'] = $this->input->post($input) == 1 ? 1 : 0;
            $dbData['created_at'] = date('Y-m-d H:i:s');
            $dbData['created_by'] = $this->session->userdata('admin_id');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');


            $this->db->insert('departments', $dbData);


            $this->session->set_flashdata('msg', 'New department added successfully!');
            redirect('admin/departments');
        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_department($title)
    {

        $result = $this->department->get_department_by_title($title);
        if (!empty($title)) {
            if ($result->num_rows() > 0) {
                $this->form_validation->set_message('check_department', 'This department already exist.');
                return false;
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('check_department', 'This field is required.');
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
    public function status($id, $status)
    {

        $result = $this->department->get_department_by_id($id);

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }

        $department_status = 1;

        if ($status == 1) {

            $department_status = 0;
        }

        $dbData['status'] = $department_status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id', $id);
        $this->db->update('departments', $dbData);
        $this->session->set_flashdata('msg', 'Department status updated successfully!');
        redirect('admin/departments');
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
    public function edit($id)
    {

        $result = $this->department->get_department_by_id($id);
        $this->data["the_id"] = $id;

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }

        $this->data['data'] = $result;

        $input = "title";
        $this->form_validation->set_rules($input, 'Title', 'trim|required|callback_check_department_edit[' . $id . ']');

        $this->form_validation->set_message('required', 'This field is required.');
        $this->form_validation->set_message('alpha_numeric_spaces', 'Only alphabet and numbers are allowed.');

        if ($this->form_validation->run() === false) {
            $this->data['title'] = 'Edit department';
            $this->data["jsfile"] = "js/add_department";
            $this->data['categories'] = $this->db->where('is_deleted', 0)
                ->get('departments');

            $this->data['content'] = $this->load->view('backend/departments/edit', $this->data, true);

            $this->load->view('backend/common/template', $this->data);
        } else {


            $dbData = array();


            $input = "title";
            $dbData['title'] = $this->input->post($input);

            $input = "parent";
            $dbData['parent'] = $this->input->post($input);

            $input = "description";
            $dbData['description'] = $this->input->post($input);

            $input = "approves_leaves";
            $dbData['approves_leaves'] = $this->input->post($input) == 1 ? 1 : 0;

            $input = "can_approve_leaves";
            $dbData['dep_can_approve_leaves'] = $this->input->post($input) == 1 ? 1 : 0;

            $input = "can_approve_allowance";
            $dbData['dep_can_approve_allowance'] = $this->input->post($input) == 1 ? 1 : 0;

            $dbData['created_at'] = date('Y-m-d H:i:s');
            $dbData['created_by'] = $this->session->userdata('admin_id');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');

            $this->db->where("id", $id);
            $this->db->update('departments', $dbData);

            $this->session->set_flashdata('msg', 'Department updated successfully!');
            redirect('admin/departments');
        }
    }
    /**
     * validation check
     * 
     * @since 1.0
     * @author DeDevelopers
     * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
     */
    public function check_department_edit($title, $id)
    {

        $result = $this->department->get_department_by_title($title);
        if (!empty($title)) {
            if ($result->num_rows() > 0) {
                $result = $result->row();
                if ($result->id == $id) {
                    return true;
                } else {
                    $this->form_validation->set_message('check_department_edit', 'This department already exist.');
                    return false;
                }
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('check_department_edit', 'This field is required.');
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
    public function delete($id)
    {
        $result = $this->department->get_department_by_id($id);

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id', $id);
        $this->db->update('departments', $dbData);
        $this->session->set_flashdata('msg', 'Department deleted successfully!');
        redirect('admin/departments');
    }


    public function d_p($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('departments');
        $this->session->set_flashdata('msg', 'department removed successfully!');
        redirect('admin/trash-departments');
    }
}
