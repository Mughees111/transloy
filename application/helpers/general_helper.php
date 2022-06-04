<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
/**
 * function slug take a title|String and return URL|String
 *
 * @param {title|String}
 * @return {url|String}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function slug($title){

    $ci = &get_instance();

    $title = strtolower(trim($title));
    $title = preg_replace('/\s+/', ' ',  $title);
    $title = preg_replace("/[^A-Za-z0-9 ]/", '', $title );
    $title = str_replace(" ", '-', $title );
    $countter = 0;
    foreach($GLOBALS['PAGES_TABLES'] as $table){
        $result = $ci->db->query('
            SELECT *
            FROM '.$table.'
            WHERE slug LIKE "'.$title.'%"
          ');
        if($result->num_rows()>0)
            $countter = ($countter+$result->num_rows());
    }

    if($countter > 0)
        $slug = $title.'-'.($countter+1);
    else
        $slug = $title;

    return $slug;

}
/**
 * function auth authorizes the admin or redirects to login page.
 *
 *
 * @return {authorized|Boolean}
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function auth(){

    $ci = &get_instance();

    $is_login = $ci->session->userdata('is_Login');

    if($is_login === true){

        $admin_id = $ci->session->userdata('admin_id');
        $type = $ci->session->userdata('type');

        // if($type=="employee")
        // {

        // }


        $admin_data = get_admin_by_id($admin_id,$type);

        if($admin_data->num_rows() == 0){

            $ci->session->sess_destroy();

            redirect(base_url()."admin/login");

        }else{

            return false;

        }

    }else{

        redirect(base_url()."admin/login");


    }
}
/**
 * function is_session checks if user is logged in and went to login page,
 * this function redirects user to dashboard itself.
 *
 *
 * @return {authorized|Boolean}
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function is_session(){

    $ci = &get_instance();

    $is_login = $ci->session->userdata('is_Login');

    if($is_login === true){

        $admin_id = $ci->session->userdata('admin_id');
        $type = $ci->session->userdata('type');
        // echo $admin_id."admin"; exit;
        $admin_data = get_admin_by_id($admin_id,$type);

        if($admin_data->num_rows() == 0){

            $ci->session->sess_destroy();

            redirect(base_url()."admin/login");

        }else{

            redirect('admin/dashboard');

        }

    }else{

        return true;


    }
}

/**
 * function get_admin_by_id provides admin object by ID
 *
 * @param {$id|int}
 * @return {authorized|Object}
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function isEmployee()
{
    $ci = &get_instance();
    $type = $ci->session->userdata('type');
    return $type=="employee";
}

function getEmployee()
{
    $ci = &get_instance();
// 	$ci->session->unset();
    $type = $ci->session->userdata('type');
    $ci = &get_instance();

    $is_login = $ci->session->userdata('is_Login');

    if($is_login === true){

        $admin_id = $ci->session->userdata('admin_id');
        $type = $ci->session->userdata('type');
        // echo $admin_id."admin"; exit;
        $admin_data = get_admin_by_id($admin_id,$type);


        if($admin_data->num_rows() == 0){




            $ci->session->sess_destroy();

            redirect(base_url()."admin/login");

        }else{

            return $admin_data->result_object()[0];



        }

    }else{

        return false;
    }
}
function get_admin_by_id($id,$type="admin"){

    $ci = &get_instance();


    if($type=="employee")
    {
        $result = $ci->db->query('
		SELECT *
		FROM employees
		WHERE id = '.$id.'
	');
    }
    else{
        $result = $ci->db->query('
		SELECT *
		FROM admin
		WHERE id = '.$id.'
	');
    }



    return $result;
}
/**
 * function settings provides global settings from settings table
 *
 * @return {settings|Object}
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function settings(){

    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT *
		FROM settings
		WHERE id = 1
	');

    return $result->row();
}
/**
 * function get_field_value_by_id provides an object containing value for specific
 * field in specific table against specific id.
 *
 * @param {$field|String} name of field
 * @param {$table|String} name of table
 * @param {$id|int} id of row
 *
 * @return {$value|Object}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_field_value_by_id($field,$table,$id){

    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT '.$field.'
		FROM '.$table.'
		WHERE id = '.$id.'
	');

    $result = $result->row();

    return $result->$field;
}

/**
 * function get_dot_extension_comma_splited gets all extensions allowed in db and
 * returns them as comma splited. This function also puts dot (.) as prefix.
 *
 * @return {$extensions|array}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_dot_extension_comma_splited(){

    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT extension
		FROM attachment_type
		WHERE status = 1
		AND is_deleted = 0
	');
    $arr = array();
    foreach($result->result() as $ext){
        $arr[] = '.'.strtolower($ext->extension);
    }

    return implode(',',$arr);
}
/**
 * function get_extension_comma_splitted gets all extensions allowed in db and
 * returns them as comma splited.
 *
 * @return {$extensions|array}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_extension_comma_splited(){

    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT extension
		FROM attachment_type
		WHERE status = 1
		AND is_deleted = 0
	');
    $arr = array();
    foreach($result->result() as $ext){
        $arr[] = strtolower($ext->extension);
    }

    return implode(',',$arr);


}

/**
 * function get_extension_piped_splited gets all extensions allowed in db and
 * returns them as pipe splited.
 *
 * @return {$extensions|array}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_extension_piped_splited(){

    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT extension
		FROM attachment_type
		WHERE status = 1
		AND is_deleted = 0
	');
    $arr = array();
    foreach($result->result() as $ext){
        $arr[] = strtolower($ext->extension);
    }

    return implode('|',$arr);


}
/**
 * function get_extensions_by_extend takes a string name of an extension, checks
 * if this extension is allowed in db or not, returns the object got from db.
 *
 * @param {$ext|String}
 * @return {$result|Object}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_extensions_by_extend($ext){

    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT *
		FROM attachment_type
		WHERE status = 1
		AND is_deleted = 0
		AND extension = "'.$ext.'"
	');
    return $result;
}
/**
 * function get_attachment_by_id takes id as int and returns the attachement from
 * db as object
 *
 * @param {$id|int}
 * @return {$result|Object}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_attachment_by_id($id){

    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT *
		FROM attachments
		WHERE is_deleted = 0
		AND id = "'.$id.'"
	');


    return $result;

}
/**
 * function message_status_upadte updates status of messages. `is_read` = 1
 * this function takes array of ids of messages in conversation_messages table
 *
 * @param {$ids|array}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function message_status_upadte($ids){

    $ci = &get_instance();
    $ci->db->query('UPDATE `conversation_messages` SET `is_read` = 1 WHERE id IN ('.implode(',',$ids).')');
}

/**
 * function get_message_attachments takes ids of messages and returns objects
 * of message attachements
 *
 * @param {$ids|array}
 * @return {$attachments|Object}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_message_attachments($ids){
    $ci = &get_instance();

    $result = $ci->db->query('
		SELECT i.*,t.icon
		FROM attachments i
		LEFT JOIN attachment_type t
		ON i.attachment_type_id = t.id
		WHERE i.is_deleted = 0
		AND i.raw_file = 0
		AND i.id IN ('.$ids.')
	');


    return $result;
}

/**
 * function time_elapsed_string_header takes date time in Y-m-d H:i:s format and
 * return the string containing information of AGO format.
 *
 * @example time_elapsed_string_header("2019-01-16 00:00:00", false)
 * => "12 hours ago"
 *
 * @param {$datetime|string}
 * @param {$full|boolean}
 * @return {$friendly_format|String}
 *
 * @since 1.0
 * @author Unknown
 */
function time_elapsed_string_header($datetime, $full = false) {


    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
/**
 * function check_role take the role in integer and checks if role is in user's
 * sessions or user is super admin
 *
 * @param {$role|number}
 * @return {$result|boolean}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function check_role($role)
{
    $ti = &get_instance();
    // print_r($ti->session->userdata('admin_roles'));exit;

    $type = $ti->session->userdata('type');

    if($type=="employee")
    {
        $the_employee = $ti->session->userdata('admin_id');
        $the_employee = $ti->db->where("id",$the_employee)->get("employees")->result_object()[0];

        $the_department = $ti->db->where("id",$the_employee->department)->get("employees")->result_object()[0];

        if(in_array($role, employees_only()))
        {
            return true;
        }

        return false;
    }

    if(in_array($role,$ti->session->userdata('admin_roles')) || in_array(-1,$ti->session->userdata('admin_roles')))
        return true;
    return false;

}
/**
 * function get_role_name returns the role name of give role number
 *
 * @param {$role|number}
 * @return {$result|string}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_role_name($role)
{
    $roles = get_all_roles();
    foreach ($roles as $key => $value) {
        # code...
        if($key==$role)
            return $value;
    }
}
/**
 * function get_all_roles returns array of all available roles in the system
 *
 * @return {$result|array}
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function get_all_roles()
{
    return $arr = array(
        '-1'=>'Super Admin',
        '1'=>'Send Push',
        '2'=>'Settings',
        '3'=>'Admins',
        '4'=>'Construction Sites',
        '5'=>'Holidays',
        '6'=>'Pages',
        '7'=>'Employees',
        '8'=>'Leaves',
        '9'=>'Managers',
        '10'=>'Departments',
        '11'=>'Teams'
    );
}
function employees_only()
{
    return $arr = array(
        // '4',
        '7',
        '8',
        // '11'
    );
}
/**
 * view_products_section_helper takes id of category, returns view with
 * dropdown to select a product from. This function is basically developed
 * for adding an offer and editing an offer page. Whenever user change the category
 * selection, this function is being hit by AJAX call and thus returns the updated
 * products dropdown under that category
 *
 *
 * @param  number  $id      id of selected category
 * @param  integer $prodcut already selected product if it is otherwise 0
 * @return view           	the view of product selection HTML
 *
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function view_products_section_helper($id,$prodcut=0){
    $ti = &get_instance();
    $ti->data['prodcut']=$product;
    // $ti->data
    $categories = $ti->db->where("parent",$id)->get('categories')->result_object();
    $cat_ids = array($id);
    foreach($categories as $cat_id)
    {
        $cat_ids[] = $cat_id->id;
    }


    $ti->data['products']=$ti->db->where_in('category',$cat_ids)->where('is_deleted',0)->get('products');
    if(!empty($ti->data['products']->result_object()))

        echo $ti->load->view('backend/offers/products_dropdown_view',$ti->data,true);

    else
        echo "<div class='easy' style='padding:10px; font-size:19px; color:red;'>No products found under this category, please <a href='".base_url()."admin/add-product'>add</a> few products under this category to create an offer"."</div>";
}
/**
 * total_customers returns total active customers in the system
 * @return integer number of customers
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function total_customers()
{
    $ti = &get_instance();
    return $ti->db->where('is_deleted',0)->count_all_results('users');
}
/**
 * total_brands returns total active brands in the system
 * @return integer number of brands
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function total_brands()
{
    $ti = &get_instance();
    return $ti->db->where('lparent',0)->where('is_deleted',0)->count_all_results('brands');
}
/**
 * total_products returns total active products in the system
 * @return integer number of products
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function total_products()
{
    $ti = &get_instance();
    return $ti->db->where('lparent',0)->where('is_deleted',0)->count_all_results('products');
}
/**
 * total_orders returns total active orders in the system
 * @return integer number of orders
 *
 * @since 1.0
 * @author DeDevelopers
 * @copyright Copyright (c) 2019, DeDevelopers, https://dedevelopers.com
 */
function total_orders()
{
    $ti = &get_instance();
    return $ti->db->where('is_deleted',0)->count_all_results('orders');
}
/**
 * takaes table name and returns total  count of rows based on is_deleted
 * or not as second perimeter (boolean)
 * @param  string  $table      name of table
 * @param  boolean $trash_only is getting for trash
 * @return integer              count of data
 */
function count_listing($table,$trash_only=false)
{
    $ti = &get_instance();
    if($trash_only)
    {
        $ti->db->where('is_deleted',1);
    }
    else
    {
        $ti->db->where('is_deleted',0);

    }

    return $ti->db->count_all_results($table);

}
function lang_select()
{
    $ti = &get_instance();
    return $ti->load->view("backend/common/lang_select");
}
function dlang()
{
    $ti = &get_instance();
    return $ti->db->where('is_default',1)->get('languages')->result_object()[0];
}
function langs()
{
    $ti = &get_instance();
    return $ti->db->where("status",1)
        ->where("is_deleted",0)
        ->order_by("is_default","DESC")
        ->get('languages')->result_object();
}
function with_currency($bill)
{
    $ti = &get_instance();

    $currency = $ti->db->where("id",1)->get("settings")->result_object()[0];

    if(!$currency) return "$".$bill;

    $currency_space = $currency->currency_space==1?" ":"";

    if($currency->currency_position==1)
    {
        return $currency->currency.$currency_space.$bill;
    }
    else
    {
        return $bill.$currency_space.$currency->currency;
    }
}
function guid()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function get_currency()
{
    $ti = &get_instance();

    $currency = $ti->db->where("id",1)->get("settings")->result_object()[0];

    return $currency->currency?$currency->currency:"$";
}
function push_notif($push_id,$notif)
{
    $ti = &get_instance();


    if($push_id=="") return false;

    require './vendor/autoload.php';
    $interestDetails = [$notif["tag"], $push_id];


    //  $expo = \ExponentPhpSDK\Expo::normalSetup();


    //  $expo->subscribe($interestDetails[0], $interestDetails[1]);

    // Build the notification data
    $notification = ['title'=>$notif["title"],'body' =>$notif["msg"],"data"=>json_encode($notif["data"])];

    // echo "<pre>";
    // var_dump($notification);
    // exit;


//	  $x = $expo->notify($interestDetails, $notification);

//	  $expo->unsubscribe($interestDetails[0], $interestDetails[1]);

    //var_dump($x);exit;

    $payload = array(
        'to' => $interestDetails,
        'sound' => 'default',
        'title' =>$notif["title"],
        'body' =>  $notif["msg"],
        'data' =>json_encode($notif["data"])
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 600,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Accept-Encoding: gzip, deflate",
            "Content-Type: application/json",
            "cache-control: no-cache",
            "host: exp.host"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "Error #:" . $err;
        // exit;
    } else {
        return $response;
        //exit;
    }

    //  return  $x;
}
function gen_rand($length = 10) {
    $characters = '0123456789abcdfghijklmnopqrstuvwxyzABCDEFGHIJLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function recurrent_holidays()
{
    $ci = &get_instance();

    $holidays=$ci->db->where("recurrent",1)->get("holidays")->result_object();

    $days = array();

    foreach($holidays as $holiday)
        $days[] = $holiday->day;

    return $days;
}
function get_leave_type($leave_code)
{
  switch($leave_code)
  {
      case 1:
        return "Annual Leave";
      case 2:
        return "Sick Leave";
      case 3:
        return "Emergency Leave";
      case 4:
        return "Hospitalization Leave";
      case 5:
        return "Marriage Leave";
      case 6:
        return "Maternity Leave";
      case 7:
        return "Compassionate Leave";
      default:
        return "Leave";        
  }
}
function is_holiday($date,$site_id=0)
{
    $ci = &get_instance();

    $holiday =$ci->db->where("DATE(date)",$date)->get("holidays")->result_object()[0];

    if($holiday) {
        return true;
    }

    $the_day = date("l",strtotime($date));
    $the_day_date = date("d",strtotime($date));
    $the_month_date = date("m",strtotime($date));

    $holiday =$ci->db->where("day",$the_day)->where("recurrent",1)->get("holidays")->result_object()[0];


    if($holiday) {
        return true;
    }

    $monthly = $ci->db->where("DAY(date)",$the_day_date)->where("monthly",1)->get("holidays")->result_object()[0];


    if($monthly) {
        return true;
    }

    $yearly = $ci->db->where("MONTH(date)",$the_month_date)->where("DAY(date)",$the_day_date)->where("yearly",1)->get("holidays")->result_object()[0];

    if($yearly) {
        return true;
    }


    if($site_id!=0)
    {
        $site = $ci->db->where("id",$site_id)->get("sites")->result_object()[0];

        $this_opens = 0;
        $this_closes = 0;

        $day = strtolower($the_day);

        if($site->$day==0) {
            return true; // holiday
        }
    }

//    echo "The last return if nothing is triggered <br>";
    return false;
}
function percent($a,$b,$p=true)
{
    $x = ($a/$b) * 100;

    $x = number_format($x,0);

    if($p) $x .= "%";

    return $x;
}
function ago($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function type_to_text($type=1){
    if($type==1) return "Checked In";
    if($type==2) return "Checked Out";
    if($type==3) return "Break In";
    if($type==4) return "Break Out";
    if($type==5) return "Leave";
    if($type==6) return "Absent";
}
function print_atten($data,$employee,$colored=false)
{
    $ci = &get_instance();

    $dataa["atten"] = $data;
    $dataa["employee"] = $employee;
    $dataa["colored"] = $colored;


    return $ci->load->view("backend/common/live_atten_elem",$dataa,true);
}
function get_employees_ids_on_site($site=0)
{

    $ci = &get_instance();
    $users_on_this_site = $ci->db->where("site",$site)->where("status",1)->where("is_deleted",0)->get("employees")->result_object();

    $users_on_this_site_arr = array(-1);

    foreach($users_on_this_site as $users_on_this_sit)
    {
        $users_on_this_site_arr[] = $users_on_this_sit->id;
    }


    return $users_on_this_site_arr;
}
function secs_to_mins($time_in_seconds)
{
    $hours = $time_in_seconds / 3600;
    $hours = ( (int) $hours);
    $minutes = ($time_in_seconds / 60) % 60;

    $hours = number_format($hours,0);

    return $hours . " hrs and ".$minutes . " mins";
}
function getTypeText($type=1)
{


    $leaves = array(
        array(
            "title"=> "Annual Leave",
            "type"=> 1
        ),
        array(
            "title"=> "Sick Leave",
            "type"=> 2
        ),
        array(
            "title"=> "Emergency Leave",
            "type"=> 3
        ),
        array(
            "title"=> "Hospitalization Leave",
            "type"=> 4
        ),
        array(
            "title"=> "Marriage Leave",
            "type"=> 5
        ),
        array(
            "title"=> "Maternity Leave",
            "type"=> 6
        ),
        array(
            "title"=> "Compassionate Leave",
            "type"=> 7
        )
    );

    foreach($leaves as $leave) if($leave["type"]==$type) return $leave["title"];
}

function getDurationText($type=1)
{


    $leaves = array(
        array(
            "title"=> "Half Day 9am to 1pm",
            "type"=> 1
        ),
        array(
            "title"=> "Half Day 1pm to 5pm",
            "type"=> 2
        ),
        array(
            "title"=> "Full Day",
            "type"=> 3
        )
    );

    foreach($leaves as $leave) if($leave["type"]==$type) return $leave["title"];

    return "N/A";


}
/**
 * Calculates the great-circle distance between two points, with
 * the Vincenty formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function get_distance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    return $angle * $earthRadius;
}
function approves_leaves($p,$c)
{
    $ci = &get_instance();

    if($p->approves_leaves==1) return " (Leave)";

    return "";

    if($c->parent==$p->id && $c->approves_leaves) return " (Leave)";
    else {
        $childs = $ci->db->where("parent",$p->id)->get("departments")->result_object()[0];


        if($childs->approves_leaves==1) return " (Leave)";
    }
    return "";
}

function getAllowanceText($type)
{
  switch($type)
  {
      case 0 : return "Food";
      case 1 : return "Petrol"; 
      case 2 : return "Diesel"; 
      case 3 : return "Print & Stationary"; 
      case 4 : return "Misc. Hardware"; 
      case 5 : return "Praying Expenditure"; 
      case 6 : return "Tel."; 
      case 7 : return "Medical"; 
      case 8 : return "General"; 
      case 9 : return "Upkeep Bicycle"; 
      case 10 : return "Upkeep Company Motor"; 
      case 11 : return "Upkeep Car"; 
      case 12 : return "Upkeep Lorry"; 
      case 13 : return "Upkeep ForkLift"; 
  }
}