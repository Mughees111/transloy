<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Twilio\Rest\Client;

ini_set('display_errors', 1);

/**
 * handles the admins
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
class Api extends ADMIN_Controller
{
    private $guest_id;
    public $emergencyFlag = 0;
    function __construct()
    {
        parent::__construct();
    }


    public function send_otp()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $country_code = $post->c_code;
        $phone = $post->phone;
        if (substr($phone, 0, 1) == "0") {
            $phone = ltrim($phone, '0');
        }

        $to = "+" . ((string) $country_code) . $phone;



        // Your Account SID and Auth Token from twilio.com/console
        $twillio_db = $this->db->where("id", 1)->get("settings")->result_object()[0];
        $sid = $twillio_db->twillio_pub;
        $token = $twillio_db->twillio_sec;

        $twilio = new Client($sid, $token);

        try {

            $service = $twilio->verify->v2->services
                ->create(settings()->site_title . " verification service");

            $verification = $twilio->verify->v2->services($service->sid)
                ->verifications
                ->create($to, "sms");
        } catch (Exception $e) {
            echo json_encode(array("action" => "failed", "err" => "Sorry, twillio seems busy"));
            return;
        }


        $this->db->where(array("code" => $post->c_code, "phone" => $post->phone))->delete("temp_phones");
        $this->db->insert(
            "temp_phones",
            array(
                "sid" => $service->sid,
                "code" => $post->c_code,
                "phone" => $post->phone,
                "code_text" => $post->c_code_text
            )
        );

        echo json_encode(array("action" => "success", "slip" => $this->db->insert_id()));
    }

    // public function resend_otp()
    // {
    //     $post = json_decode(file_get_contents("php://input"));
    //     if(empty($post))
    //     $post = (object) $_POST;

    //     $user = $this->do_auth($post);


    //     $sid = $user->sid;

    //     if(!$sid)
    //     {
    //         echo json_encode(array("action"=>"failed","err"=>"Invalid request"));
    //         return;
    //     }

    //     $country_code = $user->country_code;
    //     $phone =$user->phone;

    //     $to = "+" . ( (string) $user->country_code) . $user->phone;



    //     // Your Account SID and Auth Token from twilio.com/console
    //     $twillio_db = $this->db->where("id",1)->get("settings")->result_object()[0];
    //     $sid = $twillio_db->twillio_pub;
    //     $token = $twillio_db->twillio_sec;

    //     $twilio = new Client($sid, $token);


    //     try{

    //     $service = $twilio->verify->v2->services
    //                                   ->create("Cute Shop verification service");

    //     $verification = $twilio->verify->v2->services($service->sid)
    //                                ->verifications
    //                                ->create($to, "sms");
    //     }
    //     catch(Exception $e)
    //     {
    //         echo json_encode(array("action"=>"failed","err"=>"Sorry, twillio seems busy"));
    //         return;
    //     }
    //     $this->db->where( array("code"=>$post->c_code,"phone"=>$post->phone))->delete("temp_phones");
    //     $this->db->insert("temp_phones",
    //         array(
    //             "sid"=>$service->sid,
    //             "code"=>$post->c_code,
    //             "phone"=>$post->phone,
    //             "code_text"=>$post->c_code_text
    //         )
    //     );



    //     echo json_encode(array("action"=>"success","slip"=>$this->db->insert_id()));

    // }

    public function verify_otp()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;




        $slip = $post->slip;

        $temp_phone = $this->db->where("id", $slip)->get("temp_phones")->result_object()[0];



        $s_id = $temp_phone->sid;
        $code = $post->code;



        if (!$s_id) {
            echo json_encode(array("action" => "failed", "err" => "Invalid request"));
            return;
        }


        $twillio_db = $this->db->where("id", 1)->get("settings")->result_object()[0];
        $sid = $twillio_db->twillio_pub;
        $token = $twillio_db->twillio_sec;
        $twilio = new Client($sid, $token);

        try {

            $verification_check = $twilio->verify->v2->services($s_id)
                ->verificationChecks
                ->create($code, array('to' => '+' . $temp_phone->code . $temp_phone->phone));
        } catch (Exception $e) {
            echo json_encode(array("action" => "failed", "err" => "Invalid request, catch"));
            return;
        }

        if ($verification_check->status == "approved") {

            $user = $this->db->where(array("code" => $temp_phone->code, "phone" => $temp_phone->phone))->get("employees")->result_object()[0];

            if (!$user) {
                $arr = array(
                    "code" => $temp_phone->code,
                    "phone" => $temp_phone->phone,
                    "code_text" => $temp_phone->code_text,
                    "is_guest" => 0
                );

                if ($post->is_guest == 1) {
                    $user_logged = $this->do_auth($post);
                    $this->db->db->where("id", $user_logged->id)->update("employees", $arr);

                    $user_id = $user_logged->id;
                } else {
                    $this->db->insert("employees", $arr);

                    $user_id = $this->db->insert_id();
                }
            } else {
                $user_id = $user->id;
            }
            $this->db->where(array("code" => $temp_phone->c_code, "phone" => $temp_phone->phone))->delete("temp_phones");

            $this->do_sure_login($user_id);
        } else {
            echo json_encode(array("action" => "failed", "err" => "Invalid code"));
            return;
        }
    }



    public function signup()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $data = array(
            "email" => $post->email,
            "password" => md5($post->password),
            "created_at" => date("Y-m-d H:i:s")
        );






        $does_email_exists = $this->db->where('email', $data['email'])->count_all_results('employees') > 0 ? true : false;



        if ($data["email"] == "") {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Email is required",
                "error_type" => 1
            ));
            return;
        }




        if ($does_email_exists) {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Email already exists, please choose different one",
                "error_type" => 1
            ));
            exit;
        }



        if ($data["password"] == "") {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Please enter password",
                "error_type" => 1

            ));
            return;
        }

        $this->db->insert('employees', $data);
        $id = $this->db->insert_id();

        $rand = 1234;

        $this->do_sure_login($id);
    }
    public function update_account()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged =  $this->do_auth($post);

        $data = array(
            "first_name" => $post->firstName,
            "last_name" => $post->lastName,
            "job_title" => $post->jobTitle
        );
        $this->db->where("id", $user_logged->id)->update('employees', $data);

        $this->print_user_data($user_logged->id);
    }

    public function load_check_in()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged =  $this->do_auth($post);

        $today = date("Y-m-d");



        $todays_checks = $this->db->where("employee_id", $user_logged->id)->where("DATE(date)", $today)->order_by("id", "ASC")->get("checks")->result_object();

        $latest_status = 0; // nothing

        foreach ($todays_checks as $todays_check) {
            $latest_status = $todays_check->type;
        }

        $holiday_data = $this->db->where("DATE(date)", $today)->get("holidays")->result_object()[0];


        echo json_encode(array("action" => "success", "data" => array(
            "holiday_data" => $holiday_data,
            "is_holiday" => is_holiday($today),
            "status" => $latest_status,
            "last_check" => $todays_checks[count($todays_checks) - 1],
            "checks" => $todays_checks
        )));
    }

    public function send_late_push()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged =  $this->do_auth($post);


        $notif["data"] = (object) array();
        $notif["tag"] = "Updates";
        $notif["title"] = "Break Time Ended";
        $notif["msg"] = "Please get back to work, your break time has been ended";



        if ($user_logged->push_id != "")
            try {
                push_notif($user_logged->push_id, $notif);
            } catch (Exception $e) {
            }

        echo json_encode(array("action" => "success"));
    }


    public function load_leaves()
    {
        // POST INPUT : Token , PageCount;
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $pageSize = 10;
        $offset = ($post->pageCount - 1) * $pageSize;    
        
        $user_logged =  $this->do_auth($post);
        $totalRecords = $this->db->where("user_id", $user_logged->id)->where("status !=", 3)->count_all_results('leaves');
        $this->db->where("status !=", 3);
        $this->db->where("user_id", $user_logged->id)->order_by("id", "DESC");
        $this->db->limit($pageSize,$offset);
        $leaves = $this->db->get("leaves")->result_object();

        $to_return = array();
        foreach ($leaves as $leave) {
            $my_deparment = $this->db->where("id", $user_logged->department)->get("departments")->result_object()[0];
            $arr = array();
            $arr[] = $my_deparment;

            for ($i = 0; $i <= 20; $i++) {

                $my_deparment = $this->db->where("id", $my_deparment->parent)->get("departments")->result_object()[0];

                if (!$my_deparment) break;


                $arr[] = $my_deparment;
            }

            $i = 1;


            $text_status = "";
            foreach ($arr as $k => $ar) {

                $leave_it = $ar->approves_leaves == 0;

                // if(count($arr)==$k+1 && $ar->approves_leaves==1)  $leave_it=false;

                if ($leave_it) continue;


                $did_approve = $this->db->where("department_id", $ar->id)->where("leave_id", $leave->id)->get("leave_approvals")->result_object()[0];

                $text = " Pending";

                if ($did_approve) {
                    if ($did_approve->status == 1)
                        $text = " Approved at " . date("F d, H:i A", strtotime($did_approve->created_at));
                    else
                        $text = " Rejected at " . date("F d, H:i A", strtotime($did_approve->created_at));
                }

                if (strtolower($user_logged->job_title) == "hr" || (strtolower($ar->title) != strtolower($user_logged->job_title))) {
                    $text_status .= "\n" . ($i) . ". " . $ar->title . ": " . $text;
                    $i++;
                }
            }

            $s = array(
                "type" => getTypeText($leave->leave_type),
                "duration" => getDurationText($leave->leave_duration),
                "id" => $leave->id,
                "status" => $text_status,
                "leave_status" => $leave->status,
                "created_at" => date("d M Y, h:i A", strtotime($leave->created_at)),
                "reason" => $leave->reason,
                "start_date" => date("d M Y", strtotime($leave->start_date)),
                "end_date" => date("d M Y", strtotime($leave->end_date))
            );
            $to_return[] = $s;
        }

        echo json_encode(array("action" => "success", "leaves" => $to_return, "total"=>$totalRecords));
    }


    public function load_reports()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged =  $this->do_auth($post);

        $today = date("Y-m-d");

        if ($post->filter == "last_month") {

            // last_month

            $start_date = date('Y-m-d', strtotime('first day of last month'));
            $end_date = date('Y-m-d', strtotime('last day of last month'));
        } else if ($post->filter == "this_month") {

            // this_year

            $start_date = date('Y-m-01');

            $end_date = date("Y-m-d");
        } else if ($post->filter == "this_year") {

            // this_year

            $start_date = date('Y-01-01');

            $end_date = date("Y-m-d");
        } else if ($post->filter == "custom") {


            // custom

            $start_date = $post->date;
            $end_date = $post->date2 ? $post->date2 : date("Y-m-d");
        } else {


            $start_date = date('Y-m-d', strtotime('first day of this month'));
            $end_date = date("Y-m-d");
        }



        $total_days = 0;

        $diff = strtotime($end_date) - strtotime($start_date);

        $total_days = round($diff / (60 * 60 * 24));


        $final_arrr = array();


        for ($i = $total_days; $i >= 0; $i--) {


            $filter_date =  date("Y-m-d", strtotime(date('Y-m-d') . " -" . $i . " days"));


            $checks = $this->db->where("employee_id", $user_logged->id)->where("DATE(date)", $filter_date)->get("checks")->result_object();

            $check_in = "--";
            $lunch_in = "--";
            $lunch_out = "--";
            $check_out = "--";

            $tea_1_in = "--";
            $tea_1_out = "--";

            $tea_2_in = "--";
            $tea_2_out = "--";


            foreach ($checks as $check) {
                if ($check->type == 1) {
                    $check_in = date("h:i A", $check->stamp);
                }

                if ($check->type == 2) {
                    $check_out = date("h:i A", $check->stamp);
                }

                if ($check->type == 3) {
                    $lunch_in = date("h:i A", $check->stamp);
                }

                if ($check->type == 4) {
                    $lunch_out = date("h:i A", $check->stamp);
                }


                if ($check->type == 7) {
                    $tea_1_in = date("h:i A", $check->stamp);
                }
                if ($check->type == 8) {
                    $tea_1_out = date("h:i A", $check->stamp);
                }

                if ($check->type == 9) {
                    $tea_2_in = date("h:i A", $check->stamp);
                }
                if ($check->type == 10) {
                    $tea_2_out = date("h:i A", $check->stamp);
                }
            }

            $is_holiday = false;



            $today_day = date("l", strtotime($filter_date));
            // if(in_array($today_day, $recurrent_holidays))
            //     $is_holiday=true;


            $is_holiday = is_holiday($filter_date);

            if (count($checks) > 0)
                $status = "Present";
            else if ($is_holiday)
                $status =  "Holiday";
            else
                $status =  "Absent";


            $final_arrr[] = array(
                "day" => date("d M Y", strtotime($filter_date)) . ", " . $today_day,
                "status" => $status,
                "check_in" => $check_in,
                "lunch_in" => $lunch_in,
                "lunch_out" => $lunch_out,
                "check_out" => $check_out,
                "tea_1_in" => $tea_1_in,
                "tea_1_in" => $tea_1_in,
                "tea_2_in" => $tea_2_in,
                "tea_2_out" => $tea_2_out
            );
        }

        $date_range = date("l, d F Y", strtotime($start_date)) . " - " . date("l, d F Y", strtotime($end_date));











        echo json_encode(array("action" => "success", "data" => $final_arrr, "date_range" => $date_range));
    }


    public function load_graphs()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged =  $this->do_auth($post);

        $today = date("Y-m-d");


        $this_month = date("m");





        $total_days = 0;

        $diff = strtotime($end_date) - strtotime($start_date);

        $total_days = round($diff / (60 * 60 * 24));


        $final_arrr = array();


        for ($i = 6; $i >= 1; $i--) {


            $filter_date =  date("Y-m-d", strtotime(date('Y-m-d') . " -" . ($i * 30) . " days"));
            $filter_datev2 =  date("Y-m-d", strtotime(date('Y-m-d') . " -" . (($i - 1) * 30) . " days"));




            $checks = $this->db->where("employee_id", $user_logged->id)->where("DATE(date) >=", $filter_date)->where("DATE(date) <=", $filter_datev2)->where("type", 1)->get("checks")->result_object();
            $final_arrr[] = array(
                "label" => date("F", strtotime($filter_date)),
                "data" => count($checks)
            );
        }





        $checks = $this->db->where("employee_id", $user_logged->id)->get("checks")->result_object();

        $check_in = 0;
        $lunch_in = 0;
        $lunch_out = 0;
        $check_out = 0;

        $tea_1_in = 0;
        $tea_1_out = 0;

        $tea_2_in = 0;
        $tea_2_out = 0;


        foreach ($checks as $check) {
            if ($check->type == 1) {
                $check_in++;
            }

            if ($check->type == 2) {
                $check_out = date("h:i A", $check->stamp);
            }

            if ($check->type == 3) {
                $lunch_in = date("h:i A", $check->stamp);
            }

            if ($check->type == 4) {
                $lunch_out = date("h:i A", $check->stamp);
            }


            if ($check->type == 7) {
                $tea_1_in = date("h:i A", $check->stamp);
            }
            if ($check->type == 8) {
                $tea_1_out = date("h:i A", $check->stamp);
            }

            if ($check->type == 9) {
                $tea_2_in = date("h:i A", $check->stamp);
            }
            if ($check->type == 10) {
                $tea_2_out = date("h:i A", $check->stamp);
            }
        }














        echo json_encode(array("action" => "success", "data" => $final_arrr,));
    }





    public function do_check_in()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged =  $this->do_auth($post);

        $today = date("Y-m-d");

        $stamp = $post->stamp;

        $post_date = date("Y-m-d", $stamp);

        if ($post_date != $today) {
            echo json_encode(array("action" => "failed", "error" => "Sorry, you cannot update previous/next records"));
            return;
        }


        $site = $this->db->where("id", $user_logged->site)->get("sites")->result_object()[0];

        if ($site->lat != "" && $post->anyway != 1) {
            $distance = get_distance($post->lat, $post->lng, $site->lat, $site->lng);

            if ($distance > 500) {

                $kms = number_format(($distance), 2);
                echo json_encode(array("action" => "location", "error" => "You're " . $kms . " meters away from the site, please get there to perform this action"));
                return;
            }
        }


        $the_data = array(
            "employee_id" => $user_logged->id,
            "date" => $post_date,
            "created_at" => date("Y-m-d H:i:s", $stamp),
            "stamp" => $stamp,
            "site" => $user_logged->site,
            "type" => $post->status,
            "anyway" => $post->anyway,
            "reason" => $post->reason
        );

        //All the reasons are here
        $this->db->insert("checks", $the_data);




        $todays_checks = $this->db->where("employee_id", $user_logged->id)->where("DATE(date)", $today)->order_by("id", "ASC")->get("checks")->result_object();

        $latest_status = 0; // nothing

        foreach ($todays_checks as $todays_check) {
            $latest_status = $todays_check->type;
        }


        echo json_encode(array("action" => "success", "data" => array(
            "status" => $latest_status, "checks" => $todays_checks,
            "last_check" => $todays_checks[count($todays_checks) - 1],
        )));
    }
    public function social_connect()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;




        $data = array(

            "email" => $post->email,
            "name" => $post->name,
            "signup_type" => $post->type,
            "social_id" => $post->token,
            "password" => md5($post->username . time() . rand(05405, 4594059)),
            "created_at" => date("Y-m-d H:i:s"),

        );



        $already_user = $this->db->where('email', $data['email'])
            ->where('signup_type', $data['signup_type'])
            ->where('social_id', $data['social_id'])
            ->get('employees')->result_object()[0];




        if ($already_user) {
            $this->do_sure_login($already_user->id, true);
            return;
        }


        $this->db->insert('employees', $data);



        $id = $this->db->insert_id();

        $this->do_sure_login($id);
    }




    // public function forgot_pw()
    // {
    //     $post = json_decode(file_get_contents("php://input"));
    //     if(empty($post))
    //     $post = (object) $_POST;


    //     $email = $post->email;

    //     $user_logged = $this->db->where('email',$email)->get('employees')->result_object();

    //     if(empty($user_logged))
    //     {
    //         echo json_encode(array(
    //             "action"=>"failed",
    //             "error"=>"It seems this email is not registered with us",
    //             "email"=>$email,
    //         ));
    //         return;
    //     }
    //     $user_logged=$user_logged[0];

    //     // print_r($post);exit;

    //     // print_r(file_get_contents("php://input"));exit;


    //     $new_pass = gen_rand(8);



    //     $mmmsg = "Hi ".$user_logged->username.", your new password for Peace is: ".$new_pass;


    //     $this->load->library('email');

    //     $this->email->from(settings()->email, 'Peace');
    //     $this->email->to($post->email);

    //     $this->email->subject("Ping Request");
    //     $this->email->message($mmmsg);

    //     $x = $this->email->send();



    //     if($x)
    //     $this->db->where('id',$user_logged->id)->update('employees',array("password"=>md5($new_pass)));



    //     echo json_encode(array("action"=>"success","error"=>"Your password has been sent successfully","q"=>$this->db->last_query()));
    //     return;


    // }



    public function do_store_notifiation_key()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;


        $push_id = $post->notif_key;

        $user_logged = $this->do_auth($post);
        $data["push_id"] = $push_id;
        $this->db->where('id', $user_logged->id)->update('employees', $data);
        echo json_encode(array("action" => "success", "error" => "Your push_id has been updated successfully", "q" => $this->db->last_query()));
        return;
    }




    private function do_sure_login($id)
    {
        $user = $this->db->where('id', $id)->get('employees')->result_object();

        if (empty($user)) {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Invalid login credentials"

            ));
            return;
        }

        $user = $user[0];

        $login_data = array(
            "api_logged_sess" => md5(guid()),
            "api_logged_time" => date("Y-m-d H:i:s")
        );

        $this->db->where('id', $id)->update('employees', $login_data);


        $this->print_user_data($id);
    }



    private function print_user_data($id)
    {

        $user = $this->db->where('id', $id)->get('employees')->result_object();

        if (empty($user)) {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Invalid login credentials"

            ));
            return;
        }

        $about_page = $this->db->where("slug", "about")->get("pages")->result_object()[0];
        $settings = $this->db->get("settings")->result_object()[0];

        $user = $user[0];


        $site = $this->db->where('id', $user->site)->get('sites')->result_object()[0];
        $department = $this->db->where('id', $user->department)->get('departments')->result_object()[0];

        $iamparent = $this->db->where("id", $department->parent)->count_all_results("departments");


        echo json_encode(
            array(
                "action" => "success",
                "data" => array(
                    "id" => $user->id,
                    "job_title" => $user->job_title,
                    "first_name" => $user->first_name,
                    "last_name" => $user->last_name,
                    "token" => $user->api_logged_sess,
                    "email" => $user->email,
                    "leaves" => $user->leaves,
                    "isOfficeEmployee" => $user->isOfficeEmployee,
                    "department_id" => $user->department,
                    "name" => $user->first_name . " " . $user->last_name,
                    "country" => $user->country ? $user->country : "",
                    "state" => $user->state ? $user->state : "",
                    "city" => $user->city ? $user->city : "",
                    "s_address" => $user->s_address ? $user->s_address : "",
                    "zip" => $user->zip,
                    "code" => $user->code,
                    "profile_pic" => $user->profile_pic ? $user->profile_pic : "dummy_user.png",
                    "code_text" => $user->code_text,
                    "phone" => $user->phone ? $user->phone : "",
                    "created_at" => $user->created_at,
                    "currency" => get_currency(),
                    "contact_email" => $settings->email,
                    "show_tab" => $iamparent > 0 ? 1 : 0,
                    "balance" => $user->balance,
                    "site" => $site,
                    "canApproveLeave" => $department->dep_can_approve_leaves,
                    "canApproveAllowance" => $department->dep_can_approve_allowance
                )
            )
        );
    }

    private function currency()
    {
        $settings = $this->db->get("settings")->result_object()[0];

        return $settings->currency;
    }

    //Insert Petty Cash data into database

    public function insert_pettyCash()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $this->db->insert("pettycash", array(
            "emp_id" => (!empty($post['emp_id'])) ? $post['emp_id'] : 0,
            "NRIC" => (!empty($post['NRIC'])) ? $post['NRIC'] : 0,
            "food_allowance" => (!empty($post['food_allowance'])) ? $post['food_allowance'] : 0,
            "petrol_code" => (!empty($post['petrol_code'])) ? $post['petrol_code'] : 0,
            "MC" => (!empty($post['mc'])) ? $post['mc'] : 0,
            "site" => (!empty($post['site'])) ? $post['site'] : 0,
            "petrol" => (!empty($post['petrol'])) ? $post['petrol'] : 0,
            "diesel" => (!empty($post['diesel'])) ? $post['diesel'] : 0,
            "toll" => (!empty($post['toll'])) ? $post['toll'] : 0,
            "print_stationary" => (!empty($post['print_stationary'])) ? $post['print_stationary'] : 0,
            "misc_hardware" => (!empty($post['misc_hardware'])) ? $post['misc_hardware'] : 0,
            "pray_expense" => (!empty($post['pray_expense'])) ? $post['pray_expense'] : 0,
            "food" => (!empty($post['food'])) ? $post['food'] : 0,
            "tel" => (!empty($post['tel'])) ? $post['tel'] : 0,
            "medical" => (!empty($post['medical'])) ? $post['medical'] : 0,
            "general" => (!empty($post['general'])) ? $post['general'] : 0,
            "upkeep_bicycle" => (!empty($post['upkeep_bicycle'])) ? $post['upkeep_bicycle'] : 0,
            "upkeep_comp_motor" => (!empty($post['upkeep_comp_motor'])) ? $post['upkeep_comp_motor'] : 0,
            "upkeep_car" => (!empty($post['upkeep_car'])) ? $post['upkeep_car'] : 0,
            "upkeep_lorry" => (!empty($post['upkeep_lorry'])) ? $post['upkeep_lorry'] : 0,
            "upkeep_forklift" => (!empty($post['upkeep_forklift'])) ? $post['upkeep_forklift'] : 0
        ));
    }


    //Get leaves of Children
    public function get_leaves_of_children()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged =  $this->do_auth($post);
        $data = array();
        if ($user_logged) {
            $the_employee = $user_logged;
            $my_deparments = $this->db->where("id", $the_employee->department)->get("departments")->result_object();

            // Code by Talha

            $the_id;
            foreach ($my_deparments as $get_id) {
                $the_id = $get_id->id;
            }
            function getChildrenRecursively($the_id)
            {
                global $childArray;
                $ci = &get_instance();
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

            $this->db->where("id !=", $the_employee->id);
            $this->db->where_in("department ", $children_dep);
            $this->db->where("is_deleted", 0);
            $employees = $this->db->get("employees")->result_object();
            $the_arr = array(-1);

            foreach ($employees as $employee) {
                $the_arr[] = $employee->id;
            }

            $this->db->where("user_id !=", $the_employee->id);
            $this->db->where_in("user_id ", $the_arr);
            $leaves = $this->db->get("leaves")->result_object();
            foreach ($leaves as $leave) {
                $approvalStatus = 0;
                $approvedLeaves = $this->db->where("department_id", $the_employee->department)->where("leave_id", $leave->id)->get("leave_approvals")->result_object()[0];
                if ($approvedLeaves) {
                    $approvalStatus = $approvedLeaves->status;
                }
                $LeaveEmployee = $this->db->where("id", $leave->user_id)->get("employees")->result_object()[0];
                $LeaveDepartment = $this->db->where("id", $LeaveEmployee->department)->get("departments")->result_object()[0];
                $data[] = array(
                    'id' => $leave->id,
                    'leave_type' => $leave->leave_type,
                    'leave_duration' => $leave->leave_duration,
                    'start_date' => $leave->start_date,
                    'end_date' => $leave->end_date,
                    'reason' => $leave->reason,
                    'statusOfLeave' => $leave->status,
                    'updated_by' => $leave->updated_by,
                    'updated_at' => $leave->updated_at,
                    'created_at' => $leave->created_at,
                    'user_id' => $leave->user_id,
                    'is_deleted' => $leave->is_deleted,
                    'first_name' => $LeaveEmployee->first_name,
                    'last_name' => $LeaveEmployee->last_name,
                    'department' => $LeaveDepartment->title,
                    'approvedRejectedByLoggedInUser' => $approvalStatus
                );
            }
        } else {
            $result = $this->db->query(
                '
                SELECT *
                FROM leaves
                '
            );

            $leaves = $result->result_object();
        }
        echo json_encode($data);
    }

    //Change status of leaves
    public function change_status()
    {
        $post = json_decode(file_get_contents("php://input"));
        $id = $_POST["id"];
        $status = $_POST["status"];
        $department_id = $_POST["department_id"];

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

        for ($i = 0; $i <= 20; $i++) {

            $my_deparment = $this->db->where("id", $my_deparment->parent)->get("departments")->result_object()[0];
            if (!$my_deparment) break;
            $arr[] = $my_deparment;
        }

        $i = 1;
        $all_done = 0;
        $employeeFound = TRUE;
        $this->emergencyFlag = 0;

        $text_status = "";
        foreach ($arr as $k => $ar) {

            $leave_it = FALSE;
            if ($ar->approves_leaves == 0) {
                $leave_it = TRUE;
            }

            if ($leave_it) {
                continue;
            }
            $employeeFound = TRUE;

            $did_approve = $this->db->where("department_id", $ar->id)->where("leave_id", $id)->get("leave_approvals")->result_object()[0];
            $text = " Pending";
            if ($did_approve && $result->leave_type == 3) {
                $all_done = 1;
                $employeeFound = TRUE;
                $this->emergencyFlag = 1;
                // echo "<br>The emergency leave approved by: ". $ar->id;
                break;
            }
            if (!$did_approve) {
                $employeeFound = FALSE;
                $all_done = 0;
                // echo "<br>This employee not found in leave approvals table: ".$ar->id;
                break;
            } else if ($did_approve->status == 1 && $employeeFound == TRUE) {
                $all_done = 1;
                // echo "<br>Approved by: ".$ar->id;
            } else if ($did_approve->status == 2 && $employeeFound == TRUE) {
                $all_done = 2;
                // echo "<br>Rejected by: ".$ar->id;
                break;
            }

            $i++;
        }

        // echo "<br>The all done is: ".$all_done;
        // echo "<br>The Emergency Flag is: ".$this->emergencyFlag;
        // echo "<br>Employee found: ". $employeeFound;

        if ($all_done == 1 && $employeeFound == TRUE) {

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

        $approvedByParentOfEmployee = "";
        foreach ($arr as $k => $ar) {
            $leave_it = FALSE;
            if ($ar->approves_leaves == 0) {
                $leave_it = TRUE;
            }

            if ($leave_it) {
                continue;
            }
            // $approvedByParentOfEmployee = $ar->id;

            $approvedByParentOfEmployee = $this->db->where("department_id", $ar->id)->where("leave_id", $id)->get("leave_approvals")->result_object()[0];
        }
        echo json_encode(array(
            "action" => "Success",
            "error" => "Leave status updated successfully!",
            "status" => $approvedByParentOfEmployee->status
            // "Leave id"=> $id
        ));
        //        $this->session->set_flashdata('msg','Leave status updated successfully!');
        //        redirect('admin/leaves');
    }

    public function approvedLeavesByLoggedInUser()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object)$_POST;

        $user_logged = $this->do_auth($post);
        $data = array();
        if ($user_logged) {
            $the_employee = $user_logged;

            $statusOfLeaves = $this->db->where("department_id", $the_employee->department)->get("leave_approvals")->result_object();

            foreach ($statusOfLeaves as $leave) {
                $data[] = array(
                    'leave_id' => $leave->leave_id,
                    'department_id' => $leave->department_id,
                    'status' => $leave->status,
                    'is_employee' => $leave->is_employee
                );
            }

            echo json_encode($data);
        } else {
            echo json_encode(array(
                "alert" => "Please login first"
            ));
        }
    }


    public function login()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user =
            $this->db->group_start()
            ->where('email', $post->email)
            ->group_end()
            ->group_start()
            ->where('password', md5($post->password))
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->group_end()
            ->get('employees')
            ->result_object();

        if (empty($user)) {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Invalid login credentials"
            ));
            exit;
        }

        $this->do_sure_login($user[0]->id);
    }




    private function do_auth($post)
    {

        // if($post->is_guest==1)
        // {
        //     $user = 
        //     $this->db->where('guest_id',$post->guest_id)
        //     ->get('employees')
        //     ->result_object();



        //     if(empty($user) || $post->is_guest=="")
        //     {
        //         echo json_encode(array(
        //             "action"=>"failed",
        //             "error"=>"Invalid login credentials"
        //         ));
        //         exit;
        //     }


        //     return $user[0];
        // }



        $user =
            $this->db->where('api_logged_sess', $post->token)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->get('employees')
            ->result_object();



        if (empty($user) || $post->token == "") {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Invalid login credentials"
            ));
            exit;
        }

        return $user[0];
    }


    public function check_login()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        //      echo json_encode(array($post->token));exit;

        $user =
            $this->db->where('api_logged_sess', $post->token)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->get('employees')
            ->result_object();

        if (empty($user) || $post->token == "") {
            echo json_encode(array(
                "action" => "failed",
                "error" => "Invalid login credentials"
            ));
            exit;
        }
        $user = $user[0];

        $this->print_user_data($user->id);
    }


    public function public_image()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged = $this->do_auth($post);

        $final = $_FILES;
        $final_2 = $_POST;
        $final_3 = $post;




        $config['upload_path']          = './resources/uploads/' . $post->path;
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;


        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            echo json_encode(array("action" => "failed", "error" => strip_tags($this->upload->display_errors())));
        } else {
            $data = $this->upload->data();


            $image_data =   $this->upload->data();


            $this->load->library('image_lib');
            $configer =  array(
                'image_library'   => 'gd2',
                'source_image'    =>  $image_data['full_path'],
                'maintain_ratio'  =>  TRUE,
                'width'           =>  500,
                'height'          =>  500,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();

            // $this->db->where("id",$user_logged->id)->update("employees",array("profile_pic"=>$data["file_name"]));

            echo json_encode(array("action" => "success", "error" => "done", "filename" => $data["file_name"]));
        }
    }
    public function profile_pic()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged = $this->do_auth($post);

        $final = $_FILES;
        $final_2 = $_POST;
        $final_3 = $post;




        $config['upload_path']          = './resources/uploads/' . $post->path;
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;


        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            echo json_encode(array("action" => "failed", "error" => strip_tags($this->upload->display_errors())));
        } else {
            $data = $this->upload->data();


            $image_data =   $this->upload->data();


            $this->load->library('image_lib');
            $configer =  array(
                'image_library'   => 'gd2',
                'source_image'    =>  $image_data['full_path'],
                'maintain_ratio'  =>  TRUE,
                'width'           =>  500,
                'height'          =>  500,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();

            $this->db->where("id", $user_logged->id)->update("employees", array("profile_pic" => $data["file_name"]));

            echo json_encode(array("action" => "success", "error" => "done", "filename" => $data["file_name"]));
        }
    }

    public function get_important_data()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $settings = $this->db->get("settings")->result_object()[0];



        $lang = $this->db->where('id', $post->clang)->where('status', 1)->get("languages")->result_object()[0];

        if (!$lang) {
            $lang = dlang();
        }


        $imp_data = array(
            "currency" => get_currency(),
            "currency_position" => $settings->currency_position,
            "currency_space" => $settings->currency_space,
            "shipping_fee" => $settings->shipping_fee,
            "tax" => $settings->tax,
            "snapchat" => $settings->snapchat,
            "instagram" => $settings->instagram,
            "support_page" => $settings->support_page,
            "langs" => langs(),
            "active_lang" => $lang
        );

        echo json_encode(array(
            "action" => "success",
            "data" => $imp_data
        ));
    }


    public function get_profile()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $user_logged = $this->do_auth($post);

        $this->guest_id = $user_logged->id;
        $guest_id = $user_logged->id;
        $id = $post->id;

        $profile = $this->db->where("id", $id)->get("employees")->result_object()[0];


        $profile = $this->b_profile($profile, $user_logged->id);


        $has_reqs = $this->db->where("status", 0)->where("follow_id", $user_logged->id)->count_all_results("followers");

        $profile->has_reqs = $has_reqs;

        $profile->recordings = $this->get_recordings($id);

        echo json_encode(array("action" => "success", "data" => array("profile" => $profile)));
    }



    public function cancel_leave()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $user_logged = $this->do_auth($post);

        $this->guest_id = $user_logged->id;

        $the_leave = $this->db->where("id", $post->id)->where("DATE(start_date) >=", date("Y-m-d"))->get("leaves")->result_object()[0];

        if (!$the_leave) {
            echo json_encode(array("action" => "success", "error" => "You cannot cancel this leave now"));
            return;
        }


        $this->db->where("user_id", $user_logged->id)->where("id", $post->id)->update('leaves', array("status" => 3, "updated_by" => -1, "updated_at" => date("Y-m-d H:i:s")));

        echo json_encode(array("action" => "success"));
    }

    // public function delete_leave()
    // {
    //     $post = json_decode(file_get_contents("php://input"));
    //     if(empty($post))
    //         $post = (object) $_POST;
    //     $user_logged = $this->do_auth($post);

    //     $this->guest_id = $user_logged->id;

    //     // $the_leave = $this->db->where("id",$post->id)->where("DATE(start_date) >=",date("Y-m-d"))->get("leaves")->result_object()[0];
    //     // if(!$the_leave)
    //     // {
    //     //     echo json_encode(array("action"=>"success","error"=>"You cannot delete this leave now"));
    //     //     return;
    //     // }

    //     $this->db->where("user_id",$user_logged->id)->delete('leaves', array('id' => $post->id));

    //     echo json_encode(array("action"=>"success"));

    // }

    public function apply_leave()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged = $this->do_auth($post);

        $this->guest_id = $user_logged->id;

        // first check wether the applied leave is legal or not        

        $my_checks = $this->db->where("DATE(date)", $post->date)->get("checks")->result_object();
        if (count($my_checks) > 0 && $post->leaveType != 3) {
            echo json_encode(array("action" => "failed", "error" => "You cannot apply for leave for " . $post->date . ' as you have already checked in'));
            return;
        }

        // $my_reqs = $this->db->where("DATE(start_date)",$post->date)->get("leaves")->result_object();
        // if(count($my_checks)>0)
        // {
        //     echo json_encode(array("action"=>"failed","error"=>"You cannot apply for leave for ".$post->date.' as you have applied for the leave'));
        //     return;
        // }


        $leave = array(
            "leave_type" => $post->leaveType,
            "leave_duration" => $post->leaveDuration,
            "start_date" => $post->date,
            "end_date" => $post->date2,
            "reason" => $post->reason,
            "created_at" => date("Y-m-d H:i:s"),
            "status" => 0,
            "user_id" => $user_logged->id
        );


        $this->db->insert('leaves', $leave);

        $id = $this->db->insert_id();



        foreach ($post->docs as $doc) {
            $doc_data = array(
                "data_title" => $doc->name,
                "data_string" => $doc->url,
                "created_at" => date("Y-m-d H:i:s"),
                "created_by" => $user_logged->id,
                "leave_id" => $id
            );

            $this->db->insert("leave_files", $doc_data);
        }


        // after leave applied check for parents to whome notification is needed to send

        $t = 0;
        $times = 0;
        $my_dep = $this->db->where("id", $user_logged->department)->get("departments")->result_object()[0];
        $parent = $this->db->where("id", $my_dep->parent)->get("departments")->result_object()[0];
        if ($parent)
            while ($t != 5) {
                if ($parent->approves_leaves == 1) {
                    $employees = $this->db->where("department", $parent->id)->get("employees")->result_object();

                    $this->db->where('department', $parent->id);
                    $query = $this->db->get('employees');
                    $numberOfEmpl = $query->num_rows();
                    //$numberOfEmpl = $employees->count_all_results();
                    $myConst = 0;

                    foreach ($employees as $employee) {
                        if ($employee->push_id != "") {
                            $notif["data"] = (object) array();
                            $notif["tag"] = "Updates";
                            $notif["title"] = $user_logged->first_name . ' ' . $user_logged->last_name . ' applied for a leave application';
                            $notif["msg"] = "Please visit leave approval area on the panel to take the action";


                            try {
                                push_notif($employee->push_id, $notif);
                                $this->db->insert("pushes", array(
                                    "user_id" => $employee->id,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "title" => $notif['title'],
                                    "body" => $notif['msg'],
                                    "read" => 0
                                ));
                            } catch (Exception $e) {
                                $msg = $e;
                            }
                        }
                    }

                    $parent2 = $this->db->where("id", $parent->parent)->get("departments")->result_object()[0];
                    if (!$parent2) {
                        $t = 5;
                    } else {
                        $parent = $parent2;
                    }
                } else {
                    $parent2 = $this->db->where("id", $parent->parent)->get("departments")->result_object()[0];
                    if (!$parent2) {
                        $t = 5;
                    } else {
                        $parent = $parent2;
                    }
                }
            }

        // $countinue = true;
        // while ($countinue) {
        // }

        echo json_encode(array("action" => "success"));
    }
    
     public function apply_allowance()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged = $this->do_auth($post);

        if ($user_logged == null) {
            echo json_encode(array("action" => "failed", "error" => "user not authorized"));
        }

        $allowance = array(
            "user_id" => $user_logged->id,
            "site_id" => $post->siteId,
            "applied_date" => date("Y-m-d H:i:s"),
            "total_amount" => $post->totalAmount,
            "created_at" => date("Y-m-d H:i:s"),
            "status" => 0,
        );

        try {
            // INSERT INTO PettyCashForm 
            $this->db->insert('pettycash_form', $allowance);
            $pettycash_form_id = $this->db->insert_id();

            // INSERT INTO PettyCashForm Data
            foreach ($post->data as $data) {
                $data_to_insert = array(
                    "allowance_type" => $data->type,
                    "amount" => $data->amount,
                    "description" => $data->desc,
                    "created_at" => date("Y-m-d H:i:s"),
                    "pc_form_id" => $pettycash_form_id
                );
                $this->db->insert("pettycash_form_data", $data_to_insert);
            }

            //INSERT INTO PettCashForm Files 
            foreach ($post->docs as $doc) {
                $doc_data = array(
                    "data_title" => $doc->name,
                    "data_string" => $doc->url,
                    "created_at" => date("Y-m-d H:i:s"),
                    "pc_form_id" => $pettycash_form_id
                );
                $this->db->insert("pettycash_form_files", $doc_data);
            }
            
             // Send Notification to all authority departments
            $actionText1 = "Allowance Application";
            $actionText2 = $user_logged->first_name . " " . $user_logged->last_name . " has applied for allowance.Visit Allowance Approval Page on App";
            
            $allAuthoritydepartments = $this->db->where("dep_can_approve_allowance",1)->get("departments")->result_object();
            
            foreach($allAuthoritydepartments as $dep)
            {
                $allAuthorityEmployees = $this->db->where("department",$dep->id)->get("employees")->result_object();

                foreach($allAuthorityEmployees as $target_user)
                {
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
                            echo json_encode(array("action" => "success"));
                        }
                    }
                }
            }

            echo json_encode(array("action" => "success"));
        } catch (Exception $ex) {
            echo json_encode(array("action" => "failed", "error" => "server error"));
        }
    }

     public function get_employee_allowances()
    {
        // POST INPUT : Token , PageCount;
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $user_logged = $this->do_auth($post);

        if ($user_logged == null) {
            echo json_encode(array("action" => "failed", "error" => "user not authorized"));
        }

        try {
            $pageSize = 10;
            $offset = ($post->pageCount - 1) * $pageSize;
            $this->db->where("user_id", $user_logged->id);
            $this->db->where("is_deleted", 0);
            $this->db->order_by("id", "DESC");
            $this->db->limit($pageSize,$offset);
            $result = $this->db->get('pettycash_form')->result_object();

            $totalRecords = $this->db->where("user_id", $user_logged->id)->where("is_deleted", 0)->count_all_results('pettycash_form');

            $response_array = array();

            foreach ($result as $row) {
                $allowanceObject = new stdClass();
                $allowanceObject->appliedDate = $row->applied_date;
                $allowanceObject->totalAmount = $row->total_amount;
                $allowanceObject->status = $row->status;

                $this->db->where("pc_form_id", $row->id);
                $this->db->where("is_deleted", 0);
                $claims_result = $this->db->get("pettycash_form_data")->result_object();

                $claims_array = array();
                foreach ($claims_result as $c) {
                    $claimsObject = new stdClass();
                    $claimsObject->allowanceType = $c->allowance_type;
                    $claimsObject->amount = $c->amount;
                    $claimsObject->description = $c->description;
                    $claims_array[] = $claimsObject;
                }

                $allowanceObject->claims = $claims_array;
                $response_array[] = $allowanceObject;
            }
            echo json_encode(array("action" => "success", "employeeClaimsData" => $response_array , "total"=>$totalRecords));
        } catch (Exception $ex) {
            echo json_encode(array("action" => "failed", "error" => "server error"));
        }
    }

    public function get_pending_allowances()
    {
        // POST INPUT : Token 
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $user_logged = $this->do_auth($post);

        if ($user_logged == null) {
            echo json_encode(array("action" => "failed", "error" => "user not authorized"));
        }

        try {

            $this->db->where("status", 0);
            $this->db->where("is_deleted", 0);
            $this->db->order_by("id", "DESC");
            $result = $this->db->get('pettycash_form')->result_object();

            $response_array = array();

            foreach ($result as $row) {
                $allowanceObject = new stdClass();
                $allowanceObject->allowanceId = $row->id;
                $allowanceObject->appliedDate = $row->applied_date;
                $allowanceObject->totalAmount = $row->total_amount;
                $allowanceObject->status = $row->status;
                $user = $this->db->where("id",$row->user_id)->get('employees')->result_object()[0];
                $site = $this->db->where("id",$row->site_id)->get('sites')->result_object()[0];
                $allowanceObject->employee = $user->first_name . " " . $user->last_name;
                $allowanceObject->empId = $user->id;
                $allowanceObject->siteName = $site->title;

                $this->db->where("pc_form_id", $row->id);
                $this->db->where("is_deleted", 0);
                $claims_result = $this->db->get("pettycash_form_data")->result_object();

                $claims_array = array();
                foreach ($claims_result as $c) {
                    $claimsObject = new stdClass();
                    $claimsObject->allowanceType = $c->allowance_type;
                    $claimsObject->amount = $c->amount;
                    $claimsObject->description = $c->description;
                    $claims_array[] = $claimsObject;
                }

                $allowanceObject->claims = $claims_array;
                $response_array[] = $allowanceObject;
            }

            echo json_encode(array("action" => "success", "pendingAllowances" => $response_array));
        } catch (Exception $ex) {
            echo json_encode(array("action" => "failed", "error" => "server error"));
        }
    }

    public function allowance_action()
    {
        // POST INPUT : Token , AllowanceId , AllowanceStatus 
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $user_logged = $this->do_auth($post);

        $actionTakerDep = $this->db->where("id",$user_logged->department)->get("departments")->result_object()[0];

        if ($user_logged == null || $actionTakerDep->dep_can_approve_allowance != 1 ) {
            echo json_encode(array("action" => "failed", "error" => "user not authorized"));
        }

        try
        {
            $result = $this->db->where("id",$post->id)->get("pettycash_form")->result_object()[0];
            // first check if status has already been changed or not by admin
            if($result->status != 0)
            {
                echo json_encode(array("action" => "falied", "error" => "allowance status already changed by admin. Please refresh this page"));
                return;
            } 

            // apply action
            $this->db->where("id",$post->id)->update("pettycash_form",array("status"=>$post->status,"approved_by"=>$user_logged->id));

            // prepare notification
            $target_user = $this->db->where("id",$result->user_id)->get("employees")->result_object()[0];
            

            $actionText1="";
            $actionText2="";

            if($post->status == 1)
            {
                $actionText1 = $actionText1 . "Allowance Approved";
                $actionText2 = $actionText2 . "Your Allowance request has been approved by :" . $actionTakerDep->title;

            }else{
                $actionText1 = $actionText1 . "Allowance Rejected";
                $actionText2 = $actionText2 . "Your Allowance request has been rejected by :" . $actionTakerDep->title;
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
                    echo json_encode(array("action" => "success"));
                }
            }
            echo json_encode(array("action" => "success"));
        }catch(Exception $ex)
        {
            echo json_encode(array("action" => "failed", "error" => "server error"));
        }

    }

    public function get_employee_petrol_code()
    {
        // POST INPUT : Token 
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $user_logged = $this->do_auth($post);

        if ($user_logged == null) {
            echo json_encode(array("action" => "failed", "error" => "user not authorized"));
        }
        echo json_encode(array("action" => "success", "petrolCode" => $user_logged->petrolcode));
    }


    public function get_pushes()
    {
        // POST INPUT : token , pageCount
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $user_logged = $this->do_auth($post);

        $totalRecords = $this->db->where("user_id", $user_logged->id)->count_all_results('pushes');

        $pageSize = 10;
        $offset = ($post->pageCount - 1) * $pageSize;
        $this->db->where("user_id", $user_logged->id);
        $this->db->order_by("id", "DESC");
        $this->db->limit($pageSize,$offset);
        $pushes = $this->db->get('pushes')->result_object();
        $this->db->where("user_id", $user_logged->id)->update("pushes", array("read" => 1));
        echo json_encode(array("pushes" => $pushes, "action" => "success", "total"=>$totalRecords));
    }

    public function get_page()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;
        $lang_id = $post->lang_id;

        $this->db->where("slug", $post->slug);
        $this->db->where("lparent", 0);
        $this->db->where("status", 1);
        $this->db->where("is_deleted", 0);
        $page = $this->db->get('pages')->result_object()[0];
        $lang_page = $page;
        // if($page->lang_id!=$lang_id)
        // {
        //     $lang_page = $this->db->where("lparent",$page->id)->where("lang_id",$lang_id)->get("pages")->result_object()[0];
        // }
        $content = $lang_page->descriptions == "" ? $page->descriptions : $lang_page->descriptions;
        $content = strip_tags($content);
        $data = array(
            "title" => $lang_page->title == "" ? $page->title : $lang_page->title,
            "content" => $content,
        );
        echo json_encode(array("data" => $data, "action" => "success"));
    }
    public function private_doc()
    {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post))
            $post = (object) $_POST;

        $user_logged = $this->do_auth($post);

        $final = $_FILES;
        $final_2 = $_POST;
        $final_3 = $post;




        $config['upload_path']          = './resources/uploads/' . $post->path;
        $config['encrypt_name']        = true;
        $config['allowed_types']        = 'gif|jpg|png';


        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            echo json_encode(array("action" => "failed", "error" => strip_tags($this->upload->display_errors())));
        } else {
            $data = $this->upload->data();

            echo json_encode(array(
                "action" => "success", "error" => "done",
                "name" => $data["client_name"],
                "filename" => $data["file_name"]
            ));
        }
    }
}
