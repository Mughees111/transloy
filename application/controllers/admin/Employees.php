<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employees extends ADMIN_Controller
{

    function __construct()
    {
        parent::__construct();
        auth();
        $this->redirect_role(7);

        $this->data['active'] = 'employees';
        $this->load->model('employees_model', 'employee');
        $this->load->model('location_model', 'location');
    }

    public function index()
    {

        $this->data['title'] = 'Employees';
        $this->data['sub'] = 'employees';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['employees'] = $this->employee->get_all_employees();
        $this->data['content'] = $this->load->view('backend/employees/listing', $this->data, true);
        $this->load->view('backend/common/template', $this->data);
    }
    public function trash()
    {
        $this->data['title'] = 'Trash employees';
        $this->data['sub'] = 'trash-employees';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['employees'] = $this->employee->get_all_trashed_employees();
        $this->data['content'] = $this->load->view('backend/employees/trash', $this->data, true);
        $this->load->view('backend/common/template', $this->data);
    }

    public function add()
    {

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email');
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required|callback_check_employee_id');


        $this->form_validation->set_message('required', 'This field is required.');
        if ($this->form_validation->run() === false) {
            $this->data['title'] = 'Add New employee';
            $this->data['sub'] = 'add-employee';
            $this->data['jsfile'] = 'js/add_employee';
            $this->data['content'] = $this->load->view('backend/employees/add', $this->data, true);
            $this->load->view('backend/common/template', $this->data);
        } else {

            $leaves = 8;
            $experience = $this->input->post('experience');
            if ($experience <= 2) {
                $leaves = 8;
            } else if ($experience <= 5 && $experience > 2) {
                $leaves = 12;
            } else if ($experience > 5) {
                $leaves = 16;
            }
            $dbData['experience'] = $experience;
            $dbData['leaves'] = $leaves;

            $dbData['job_title'] = $this->input->post('job_title');
            $dbData['first_name'] = $this->input->post('first_name');
            $dbData['employee_id'] = $this->input->post('employee_id');
            $dbData['last_name'] = $this->input->post('last_name');
            $dbData['email'] = $this->input->post('email');
            $dbData['phone'] = $this->input->post('phone');
            $dbData['password'] = md5($this->input->post('password'));
            $dbData["site"] = $this->input->post("site");
            $dbData['department'] = $this->input->post('department');
            // $dbData['leaves'] = $this->input->post('leaves') > 0 ? $this->input->post('leaves') : 0;
            $dbData['isOfficeEmployee'] = $this->input->post('isOfficeEmployee');
            $dbData['petrolcode'] = $this->input->post('petrolcode');
            $dbData['created_at'] = date('Y-m-d H:i:s');
            $dbData['created_by'] = $this->session->userdata('admin_id');
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
            $this->db->insert('employees', $dbData);

            $this->load->library('email');

            // prepare email
            $this->email
                ->from(settings()->email, settings()->site_title)
                ->to($dbData['email'])
                ->subject("Welcome Onboard")
                ->message("Admin just created your account as an employee on " . settings()->site_title . ", your login details are:<br> Your username is: <br> <span style='background:#f5f5f5;padding:5px;'>" . $dbData['email'] . "</span> <br> Your password is: <br> <span style='background:#f5f5f5;padding:5px;'>" . $this->input->post('password') . "</span> <br> <b>You can login in the app</b>")
                ->set_mailtype('html');

            // send email
            $this->email->send();



            $this->session->set_flashdata('msg', 'New employee added successfully!');
            redirect('admin/employees');
        }
    }

    public function check_email($email)
    {

        $result = $this->employee->get_employee_by_email($email);
        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('check_email', 'Please enter the valid email address.');
                return false;
            } else {
                if ($result->num_rows() > 0) {
                    $this->form_validation->set_message('check_email', 'This email already exist.');
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            $this->form_validation->set_message('check_email', 'This field is required.');
            return false;
        }
    }

    public function check_employee_id($employee_id)
    {

        $result = $this->employee->get_employee_by_employee_id($employee_id);
        if (!empty($employee_id)) {
            if ($result->num_rows() > 0) {
                $this->form_validation->set_message('check_employee_id', 'This employee ID already exist.');
                return false;
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('check_employee_id', 'This field is required.');
            return false;
        }
    }


    public function status($id, $status)
    {

        $result = $this->employee->get_employee_by_id($id);

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }

        $employee_status = 1;

        if ($status == 1) {

            $employee_status = 0;
        }

        $dbData['status'] = $employee_status;
        $dbData['updated_at'] = date('Y-m-d H:i:s');
        $dbData['updated_by'] = $this->session->userdata('admin_id');

        $this->db->where('id', $id);
        $this->db->update('employees', $dbData);
        $this->session->set_flashdata('msg', 'employee status updated successfully!');
        redirect('admin/employees');
    }

    public function edit($id)
    {

        $result = $this->employee->get_employee_by_id($id);

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }

        $this->data['data'] = $result;
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email_edit[' . $id . ']');
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required|callback_check_employee_id_edit[' . $id . ']');

        $this->form_validation->set_message('required', 'This field is required.');

        if ($this->form_validation->run() === false) {
            $this->data['title'] = 'Edit employee';
            $this->data['sub'] = 'edit-employee';
            $this->data['jsfile'] = 'js/add_employee';
            $this->data['content'] = $this->load->view('backend/employees/edit', $this->data, true);
            $this->load->view('backend/common/template', $this->data);
        } else {
            $dbData['job_title'] = $this->input->post('job_title');

            $dbData['first_name'] = $this->input->post('first_name');
            $dbData['leaves'] = $this->input->post('leaves') > 0 ? $this->input->post('leaves') : 0;
            $dbData['employee_id'] = $this->input->post('employee_id');
            $dbData['last_name'] = $this->input->post('last_name');
            $dbData['email'] = $this->input->post('email');

            $dbData['site'] = $this->input->post('site');
            $dbData['department'] = $this->input->post('department');
            $dbData['phone'] = $this->input->post('phone');

            $dbData['gender'] = $this->input->post('gender');
            $dbData['petrolcode'] = $this->input->post('petrolcode');

            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
            $this->db->where('id', $id);
            $this->db->update('employees', $dbData);
            $this->session->set_flashdata('msg', 'employee updated successfully!');
            redirect('admin/employees');
        }
    }

    public function check_email_edit($email, $id)
    {

        $result = $this->employee->get_employee_by_email($email);
        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('check_email_edit', 'Please enter the valid email address.');
                return false;
            } else {
                if ($result->num_rows() > 0) {
                    $result = $result->row();
                    if ($result->id == $id) {
                        return true;
                    } else {

                        $this->form_validation->set_message('check_email_edit', 'This email already exist.');
                        return false;
                    }
                } else {
                    return true;
                }
            }
        } else {
            $this->form_validation->set_message('check_email_edit', 'This field is required.');
            return false;
        }
    }


    public function check_employee_id_edit($employee_id, $id)
    {

        $result = $this->employee->get_employee_by_employee_id($employee_id);
        if (!empty($employee_id)) {

            if ($result->num_rows() > 0) {
                $result = $result->row();
                if ($result->id == $id) {
                    return true;
                } else {

                    $this->form_validation->set_message('check_employee_id_edit', 'This Employee ID already exist.');
                    return false;
                }
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('check_employee_id_edit', 'This field is required.');
            return false;
        }
    }


    public function delete($id)
    {
        $result = $this->employee->get_employee_by_id($id);

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }
        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 1;
        $this->db->where('id', $id);
        $this->db->update('employees', $dbData);
        $this->session->set_flashdata('msg', 'employee deleted successfully!');
        redirect('admin/employees');
    }
    public function restore($id)
    {

        $dbData['deleted_by'] = $this->session->userdata('admin_id');
        $dbData['is_deleted'] = 0;
        $this->db->where('id', $id);
        $this->db->update('employees', $dbData);
        $this->session->set_flashdata('msg', 'employee restored successfully!');
        redirect('admin/trash-employees');
    }
    public function d_p($id)
    {


        $this->db->where('id', $id);
        $this->db->delete('employees');
        $this->session->set_flashdata('msg', 'employee removed successfully!');
        redirect('admin/trash-employees');
    }


    public function employee_detail($id)
    {
        $result = $this->employee->get_employee_by_id($id);

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }
        $this->data['title'] = 'employee Detail';
        $this->data['sub'] = 'add-employee';
        $this->data['jsfile'] = 'js/employee_detail';
        $this->data['employee_detail'] = $this->employee->get_employee_by_id($id);

        $this->data['content'] = $this->load->view('backend/employees/detail', $this->data, true);
        $this->load->view('backend/common/template', $this->data);
    }


    public function password($id)
    {

        $result = $this->employee->get_employee_by_id($id);

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }

        $this->data['data'] = $result;
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->data['title'] = 'Change Employee Password';
            $this->data['sub'] = 'edit-employee';
            $this->data['content'] = $this->load->view('backend/employees/password', $this->data, true);
            $this->load->view('backend/common/template', $this->data);
        } else {

            $dbData['password'] = md5($this->input->post('password'));
            $dbData['updated_at'] = date('Y-m-d H:i:s');
            $dbData['updated_by'] = $this->session->userdata('admin_id');
            $this->db->where('id', $id);
            $this->db->update('employees', $dbData);
            $this->session->set_flashdata('msg', 'Employee password updated successfully!');
            redirect('admin/employees');
        }
    }


    public function report()
    {
        $employee = $this->employee->get_employee_by_id($_GET["employee_id"]);

        if (!$employee) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }

        $selected_type = "this_month";


        if ($_GET["last_month"] == 1) {

            // last_month
            $selected_type = "last_month";

            $start_date = date('Y-m-d', strtotime('first day of last month'));
            $end_date = date('Y-m-d', strtotime('last day of last month'));
        } else if ($_GET["this_year"] == 1) {

            // last_month
            $selected_type = "this_year";

            $start_date = date('Y-01-01');
            $end_date = date("Y-m-d");
        } else if (isset($_POST["start_date"]) && $_POST["start_date"] != "") {


            // custom
            $selected_type = "custom";

            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];
        } else {


            $selected_type = "this_month";

            $start_date = date('Y-m-d', strtotime('first day of this month'));
            $end_date = date("Y-m-d");
        }


        $this->data["start_date"] = $start_date;
        $this->data["end_date"] = $end_date;

        $this->data["selected_type"] = $selected_type;

        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['title'] = 'Employee Report';
        $this->data['sub'] = "";
        $this->data['content'] = $this->load->view('backend/employees/report', $this->data, true);
        $this->load->view('backend/common/template', $this->data);
    }
}
