<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends ADMIN_Controller
{
    function __construct()
    {
        parent::__construct();
        auth();
        $this->redirect_role(8);

        $this->data['active'] = 'reports';
        $this->load->model('reports_model', 'reports');
//        $this->load->model('location_model','location');
    }

    public function index()
    {
        $employee_id = $_GET['employee_id'];
//        var_dump($employee_id);
        if($employee_id == NULL)
        {
            $employee_id = 3;
        }

        $selected_type = "this_month";
        $start_date = date('Y-m-d', strtotime('first day of this month'));
        $end_date = date('Y-m-d', strtotime('today'));

//        echo "<br>First day of this month: ". $start_date;
//        echo "<br>Today: ". $end_date;
//        exit();
        if($_GET["last_month"]==1){

            // last_month
            $selected_type = "last_month";

            $start_date = date('Y-m-d', strtotime('first day of last month'));
            $end_date = date('Y-m-d', strtotime('last day of last month'));

            $this->data['employee_attendance'] = $this->reports->employee_attendance_byDate($employee_id, $start_date, $end_date);

        }

        else if($_GET["this_year"]==1){

            // last_month
            $selected_type = "this_year";

            $start_date = date('Y-01-01');
            $end_date = date("Y-m-d");
            $this->data['employee_attendance'] = $this->reports->employee_attendance_byDate($employee_id, $start_date, $end_date);


        }

        else if(isset($_POST["start_date"]) && $_POST["start_date"]!=""){


            // custom
            $selected_type = "custom";

            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];

            $this->data['employee_attendance'] = $this->reports->employee_attendance_byDate($employee_id, $start_date, $end_date);


        }
        else if ($_GET["this_month"]==1){


            $selected_type = "this_month";

            $start_date = date('Y-m-d', strtotime('first day of this month'));
            $end_date = date("Y-m-d");
            $this->data['employee_attendance'] = $this->reports->employee_attendance_byDate($employee_id, $start_date, $end_date);

        }

        else {
            $selected_type = "this_month";

            $start_date = date('Y-m-d', strtotime('first day of this month'));
            $end_date = date("Y-m-d");
            $this->data['employee_attendance'] = $this->reports->employee_attendance_byDate($employee_id, $start_date, $end_date);


        }


        $this->data['dates_list'] = $this->reports->fetch_date();
        $this->data['title'] = 'Employees Reports';
        $this->data['sub'] = 'attendance_rep';
        $this->data['js'] = 'listing';
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data["selected_type"] = $selected_type;
        $this->data['jsfile'] = 'js/general_listing';
//        $this->data['employees'] = $this->employee->get_all_employees();
        $this->data['content'] = $this->load->view('backend/reports/index', $this->data,true);
        $this->load->view('backend/common/template',$this->data);
    }

    public function getAttendanceOfDepartment()
    {

        $dep_id = $_POST['dep_id'];

        $data = $this->reports->departmentAttendance($dep_id);
//        var_dump($data);
        echo $data;
    }

    public function getAttendanceByDate()
    {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $data = $this->reports->employeeAttendanceByDate($start_date, $end_date);

        echo $data;
    }

    public function presence_trends()
    {
        $employee_id = $_GET['employee_id'];



        $this->data['chart_data'] = $this->reports->bar_chart();

        $this->data['dates_list'] = $this->reports->fetch_date();
        $this->data['title'] = 'Employees Reports';
        $this->data['sub'] = 'presence_trends';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';

//        $this->data['employees'] = $this->employee->get_all_employees();
        $this->data['content'] = $this->load->view('backend/reports/presence_trends', $this->data,true);
        $this->load->view('backend/common/template',$this->data);
    }

    public function employee_reports()
    {
        if($_GET['employee_id']==NULL)
        {
            $employeeId = 3;
        }
        else
        {
            $employeeId = $_GET['employee_id'];
        }
//        echo "The employee id: ".$employeeId;

        $employee = $this->reports->get_employee_by_id($employeeId);

        if(!$employee){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');
        }

        $selected_type = "this_month";


        if($_GET["last_month"]==1){
//            echo "Last month activated<br>";
            // last_month
            $selected_type = "last_month";

            $start_date = date('Y-m-d', strtotime('first day of last month'));
            $end_date = date('Y-m-d', strtotime('last day of last month'));

//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();
        }

        else if($_GET["this_year"]==1){
//            echo "This year activated<br>";

            // last_month
            $selected_type = "this_year";

            $start_date = date('Y-01-01');
            $end_date = date("Y-m-d");
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();
        }

        else if(isset($_POST["start_date"]) && $_POST["end_date"]!=""){

//            echo "Custom date activated<br>";

            // custom
            $selected_type = "custom";

            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();


        }
        else{

//            echo "Else condition activated<br>";

            $selected_type = "this_month";

            $start_date = date('Y-m-d', strtotime('first day of this month'));
            $end_date = date("Y-m-d");
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;

//            exit();
        }



        $this->data["start_date"] = $start_date;
        $this->data["end_date"] = $end_date;
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();
        $this->data["selected_type"] = $selected_type;

        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['title'] = 'Employee Report';
        $this->data['sub'] = "employee_report";
        $this->data['content'] = $this->load->view('backend/reports/employee_report',$this->data,true);
        $this->load->view('backend/common/template',$this->data);
    }
    
    public function report()
    {
        if($_GET['employee_id']==NULL)
        {
            $employeeId = 78;
        }
        else
        {
            $employeeId = $_GET['employee_id'];
        }
//        echo "The employee id: ".$employeeId;

        $employee = $this->reports->get_employee_by_id($employeeId);

        if(!$employee){

            $this->session->set_flashdata('err','Invalid request.');
            redirect('admin/404_page');
        }

        $selected_type = "this_month";


        if($_GET["last_month"]==1){
//            echo "Last month activated<br>";
            // last_month
            $selected_type = "last_month";

            $start_date = date('Y-m-d', strtotime('first day of last month'));
            $end_date = date('Y-m-d', strtotime('last day of last month'));

//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();
        }

        else if($_GET["this_year"]==1){
//            echo "This year activated<br>";

            // last_month
            $selected_type = "this_year";

            $start_date = date('Y-01-01');
            $end_date = date("Y-m-d");
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();
        }

        else if(isset($_POST["start_date"]) && $_POST["end_date"]!=""){

//            echo "Custom date activated<br>";

            // custom
            $selected_type = "custom";

            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();


        }
        else{

//            echo "Else condition activated<br>";

            $selected_type = "this_month";

            $start_date = date('Y-m-d', strtotime('first day of this month'));
            $end_date = date("Y-m-d");
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;

//            exit();
        }



        $this->data["start_date"] = $start_date;
        $this->data["end_date"] = $end_date;
//            echo "THe start date: ". $start_date ."<br>";
//            echo "THe end date: ". $end_date;
//
//            exit();
        $this->data["selected_type"] = $selected_type;

        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/general_listing';
        $this->data['title'] = 'Employee Report';
        $this->data['sub'] = "employee_report";
        $this->data['content'] = $this->load->view('backend/reports/employee_report',$this->data,true);
        $this->load->view('backend/common/template',$this->data);
    }

//    public function report()
//    {
//        echo "This is the employee id: ".$_GET['employee_id']. "<br>";
//
//        $employee = $this->employee->get_employee_by_id($_GET["employee_id"]);
//
//        if (!$employee) {
//
//            $this->session->set_flashdata('err', 'Invalid request.');
//            redirect('admin/404_page');
//        }
//
//        $selected_type = "this_month";
//
//
//        if ($_GET["last_month"] == 1) {
//
//            // last_month
//            $selected_type = "last_month";
//
//            $start_date = date('Y-m-d', strtotime('first day of last month'));
//            $end_date = date('Y-m-d', strtotime('last day of last month'));
//
//        } else if ($_GET["this_year"] == 1) {
//
//            // last_month
//            $selected_type = "this_year";
//
//            $start_date = date('Y-01-01');
//            $end_date = date("Y-m-d");
//        } else if (isset($_POST["start_date"]) && $_POST["start_date"] != "") {
//
//
//            // custom
//            $selected_type = "custom";
//
//            $start_date = $_POST["start_date"];
//            $end_date = $_POST["end_date"];
//
//
//        } else {
//
//
//            $selected_type = "this_month";
//
//            $start_date = date('Y-m-d', strtotime('first day of this month'));
//            $end_date = date("Y-m-d");
//        }
//
//
//        $this->data["start_date"] = $start_date;
//        $this->data["end_date"] = $end_date;
//
//        $this->data["selected_type"] = $selected_type;
//
//        $this->data['js'] = 'listing';
//        $this->data['jsfile'] = 'js/general_listing';
//        $this->data['title'] = 'Employee Reports';
//        $this->data['sub'] = "";
//        $this->data['content'] = $this->load->view('backend/reports/index', $this->data, true);
//        $this->load->view('backend/common/template', $this->data);
//    }


}