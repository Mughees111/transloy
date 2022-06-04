<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * handles the leaves
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Leaves extends ADMIN_Controller
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

    public $emergencyFlag = 0;
    //    public $emergencyLeaveId = 0;
    function __construct()
    {
        parent::__construct();
        auth();
        $this->data['active'] = 'leaves';
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


        // $Total_depts= array ();
        // function GetChildDepartments($parentid) {
        //     global $Total_depts;
        //     $ci =&get_instance();
        //   // echo "All child departments step 1 parent id =  ".$parentid;
        // //var_dump ($Total_depts);
        // $child_departments;


        // foreach($parentid as $parent)
        // {
        //     $child_departments=$ci->db->where("parent",$parent)->get("departments")->result_object();
        // }

        // $i=0;
        // // echo "All child departments step 2 ";
        // //var_dump ($child_departments);

        // foreach ($child_departments as $child){
        // 	//$Total_depts[]=$child->id;
        // 	$Total_depts []= strval($child->id);
        // 	$nextchild = $ci->db->where("parent",$child->id)->get("departments")->result_object();
        // 	//echo "All child departments step 3 of ".$child->id;
        // 	//var_dump ($nextchild);
        // if ($nextchild == null) {
        // 	continue;
        // }
        // else
        // {
        //     $childArr [] =$nextchild->id;
        //     	$Total_depts[] = strval(GetChildDepartments($childArr));
        // }

        // }
        // return $Total_depts;
        // }

        if (isEmployee()) {
            $the_employee = getEmployee();



            $my_deparments = $this->db->where("id", $the_employee->department)->get("departments")->result_object();

            // echo "<pre>";
            // var_dump($my_deparments);





            // $Total_depts[] = $my_deparments->id ;
            // foreach ($my_deparments as $my_dept){
            //     $parentId [] =$my_dept->id;
            //     $Total_depts[]= GetChildDepartments ($parentId,$Total_depts);
            //     echo "All child departments final";
            // var_dump ($Total_Departments);
            // echo "All child departments second final";
            // var_dump ($Total_depts);
            // echo "All child departments third final";
            // unset ($Total_depts);
            // var_dump ($Total_depts);

            // exit();
            // }

            // Code by Talha
            $the_id;
            foreach ($my_deparments as $get_id) {
                $the_id = $get_id->id;
            }
            // $childArray = array();
            function getChildrenRecursively($the_id)
            {
                global $childArray;
                $ci = &get_instance();
                // echo "<pre>";
                $my_departments = $ci->db->where("parent", $the_id)->get("departments")->result_object();

                foreach ($my_departments as $child_dep) {
                    $childArray[] = $child_dep->id;
                    $the_id = $child_dep->id;

                    getChildrenRecursively($the_id);
                }

                return $childArray;
            }
            $childArray = array();
            $children_dep = array();
            $children_dep = getChildrenRecursively($the_id);

            // echo "The children array : <br>";
            //         var_dump($children_dep);
            // exit();


            // // echo "Current department id: ".$curr_id."<br>"; 
            // foreach($my_deparments as $my_dep)
            // {
            //     $curr_id = $my_dep->id;
            //     $arr[] = $my_dep->id;

            //     $my_deparment = $this->db->where("parent",$curr_id)->get("departments")->result_object();
            //     // echo "<pre>";
            //     // var_dump($my_deparment);
            //     // exit();
            //     if(!$my_deparment) break;

            //     foreach($my_deparment as $my_dep)
            //     {
            //         $curr_id = $my_dep->id;
            //         $arr[] = $my_dep->id;

            //         $sub_dep = $this->db->where("parent",$curr_id)->get("departments")->result_object();

            //         // echo "<pre>";
            //         // echo "current id: " .$curr_id. " parent id: ". $my_dep->parent . "<br>";
            //         // var_dump($sub_dep);

            //         foreach($sub_dep as $my_dep)
            //         {
            //             $arr[] = $my_dep->id;
            //             $curr_id = $my_dep->id;

            //             $sub_dep = $this->db->where("parent",$curr_id)->get("departments")->result_object();
            //             // var_dump($sub_dep);
            //             foreach($sub_dep as $my_dep)
            //             {
            //                 $arr[] = $my_dep->id;
            //                 $curr_id = $my_dep->id;
            //             }
            //         }

            //     }
            //     //echo $curr_id;
            // }
            // echo "<pre>Original hierarchy<br>";
            // var_dump($arr);
            // exit();
            //             if(count($my_deparments)>0)
            //             {
            //                 $arr = array(-1);


            //                 foreach($my_deparments as $my_deparment)
            //                 {
            //                     for($i=0;$i<=20;$i++)
            //                     {



            //                         $parent_departments = $this->db->where("parent",$my_deparment->id)->get("departments")->result_object();
            // // echo "<pre>";
            // // var_dump($my_deparments);
            //                         if(empty($parent_departments)) break;
            //                         foreach($parent_departments as $md)  $arr[] = $md->id;

            //                     }
            //                 }


            //             }
            //             else{
            //                 $leaves= [];
            //             }
            // echo "The array departments: ";
            // echo "<pre>";
            // var_dump($arr);
            // exit();
            // print_r($arr);exit;


            $this->db->where("id !=", $the_employee->id);
            $this->db->where_in("department ", $children_dep);
            $this->db->where("is_deleted", 0);
            $employees = $this->db->get("employees")->result_object();
            $the_arr = array(-1);

            // echo "The employees <pre>";
            // var_dump($employees);
            // exit();

            foreach ($employees as $employee) {
                $the_arr[] = $employee->id;
                // echo $employee->job_title." ".$employee->department."<br>";
            }
            // echo "The array of employee's id whose super parent is ".$the_id."<pre>";
            // var_dump($the_arr);
            // exit();

            $this->db->where("user_id !=", $the_employee->id);
            $this->db->where_in("user_id ", $the_arr);
            $leaves = $this->db->get("leaves")->result_object();
            // var_dump($leaves);
            // exit();
        } else {
            $result = $this->db->query(
                '
                SELECT *
                FROM leaves
                '
            );

            $leaves = $result->result_object();
        }
        //        $this->data['ValueOfAllDone'] = $ValueOfAllDone;
        $this->data['title'] = 'Leaves';
        $this->data['sub'] = 'leaves';
        $this->data['js'] = 'listing';
        $this->data['jsfile'] = 'js/leaves_listing';
        $this->data['leaves'] = $leaves;
        $this->data['emergencyFlag'] = $this->emergencyFlag;
        $this->data['emergencyLeaveId'] = $this->emergencyLeaveId;
        $this->data['content'] = $this->load->view('backend/leaves/listing', $this->data, true);
        $this->load->view('backend/common/template', $this->data);
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
    public function status($id, $status, $department_id = 0)
    {

        if ($department_id == 0) {
            $this->session->set_flashdata('err', 'Department must be assigned to this user first');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $result = $this->db->where("id", $id)->get("leaves")->result_object()[0];
        $user_logged = $this->db->where("id", $result->user_id)->get("employees")->result_object()[0];

        if (!$result) {
            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }


        $department = $this->db->where("id", $department_id)->where("approves_leaves", 1)->get("departments")->result_object()[0];

        $by = " by: " . $department->title;




        $notif["data"] = (object) array();
        $notif["tag"] = "Updates";
        $notif["title"] = $status == 1 ? "Leave Approved" : "Leave Rejected";
        $notif["msg"] = $status == 1 ? "Your leave has been approved" . $by : "Your leave has been rejected" . $by;



        if ($user_logged->push_id != "")
            try {

                $x = push_notif($user_logged->push_id, $notif);
                $this->db->insert("pushes", array(
                    "user_id" => $user_logged->id,
                    "created_at" => date("Y-m-d H:i:s"),
                    "title" => $notif['title'],
                    "body" => $notif['msg'],
                    "read" => 0
                ));
            } catch (Exception $e) {
                $x = push_notif($user_logged->push_id, $e);
            }




        $ar = array(
            "department_id" => $department_id,
            "leave_id" => $id,
            "created_at" => date("Y-m-d H:i:s"),
            "is_employee" => isEmployee() ? 1 : 0,
            "status" => $status
        );



        $this->db->insert("leave_approvals", $ar);


        $my_deparment = $this->db->where("id", $user_logged->department)->get("departments")->result_object()[0];
        $arr = array();
        //            $arr[] = $my_deparment;


        for ($i = 0; $i <= 20; $i++) {

            $my_deparment = $this->db->where("id", $my_deparment->parent)->get("departments")->result_object()[0];
            if (!$my_deparment) break;


            $arr[] = $my_deparment;
        }

        $i = 1;

        $all_done = 0;

        // $this->emergencyFlag = 0;
        // echo "<pre>";
        // var_dump($arr);


        if ($result->leave_type == 3) {
            $text_status = "";
            foreach ($arr as $k => $ar) {

                $leave_it = FALSE;
                if ($ar->approves_leaves == 0) {
                    $leave_it = TRUE;
                }

                if ($leave_it) {
                    continue;
                }

                $did_approve = $this->db->where("department_id", $ar->id)->where("leave_id", $id)->get("leave_approvals")->result_object()[0];
                $text = " Pending";
                if ($did_approve->status == 1) {
                    $all_done = 1;
                    //                    echo "<br>The emergency leave approved by: ". $ar->id;

                    break;
                } elseif ($did_approve->status == 2) {
                    $all_done = 2;
                    //                    echo "<br>The emergency leave rejected by: ".$ar->id;
                    continue;
                }

                $i++;
            }
        } else {
            $text_status = "";
            foreach ($arr as $k => $ar) {

                $leave_it = FALSE;
                if ($ar->approves_leaves == 0) {
                    $leave_it = TRUE;
                }

                if ($leave_it) {
                    continue;
                }


                $did_approve = $this->db->where("department_id", $ar->id)->where("leave_id", $id)->get("leave_approvals")->result_object()[0];
                $text = " Pending";

                if (!$did_approve) {
                    $all_done = 0;
                    // echo "<br>This employee not found in leave approvals table: ".$ar->id;
                    break;
                } else if ($did_approve->status == 1 && $result->leave_type != 3) {
                    $all_done = 1;
                    // echo "<br>Approved by: ".$ar->id;
                } else if ($did_approve->status == 2 && $result->leave_type != 3) {
                    $all_done = 2;
                    // echo "<br>Rejected by: ".$ar->id;
                    break;
                }

                $i++;
            }
        }

        //        echo "<br>The all done is: ".$all_done;

        //         exit();

        if ($all_done == 1) {

            $endDate =  strtotime($result->end_date);
            $startDate = strtotime($result->start_date);
            $datediff = $endDate - $startDate;

            $days = ceil(abs($datediff / (60 * 60 * 24)));

            $to_minus = $result->leave_duration == 3 ? ($days + 1) : 0.5;

            $leavesLeft = $user_logged->leaves;

            // $checkLeaves = $leavesLeft-$to_minus;
            // if($checkLeaves <= 0)
            // {
            //     $this->session->set_flashdata('msg','Leave status updated successfully!');
            //     redirect('admin/leaves');
            // }
            $this->db->where("id", $user_logged->id)->update("employees", array("leaves" => $user_logged->leaves - $to_minus));
            $this->db->where("id", $id)->update("leaves", array("status" => $all_done));
        } else if ($all_done == 2) {
            $this->db->where("id", $id)->update("leaves", array("status" => $all_done));
        } else {
            $this->db->where("id", $id)->update("leaves", array("status" => $all_done));
        }

        //        $this->data['emergencyFlag'] = $emergencyFlag;
        $user_logged_leaves = $this->db->where("id", $result->user_id)->get("employees")->result_object()[0];

        //        echo "Leaves left: ".$user_logged_leaves->leaves;
        //        exit();

        $this->session->set_flashdata('msg', 'Leave status updated successfully!');
        redirect('admin/leaves');
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
        $result = $this->db->where("id", $id)->get("leaves")->result_object()[0];

        if (!$result) {

            $this->session->set_flashdata('err', 'Invalid request.');
            redirect('admin/404_page');
        }

        $this->db->where('id', $id);
        $this->db->delete('leaves');
        $this->session->set_flashdata('msg', 'Leave deleted successfully!');
        redirect('admin/leaves');
    }
}
