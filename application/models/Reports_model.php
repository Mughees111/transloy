<?php

class Reports_model extends CI_Model
{
   function fetch_date()
   {
       $this->db->select('date');
       $this->db->from('checks');
       $this->db->group_by('date');
       $this->db->order_by('date', 'DESC');
       return $this->db->get();
   }
   function fetch_chart_data($date)
   {
        $this->db->where('date', $date);
        $this->db->order_by('id', 'ASC');
        return $this->db->get('checks');
   }
   function bar_chart()
   {
        $query =  $this->db->query('SELECT COUNT(DISTINCT(employee_id)) as employee_count,date FROM checks  group by date');

        $record = $query->result();

        return json_encode($record);

   }

    public function get_employee_by_id($id){

        $result = $this->db->query('
			SELECT *
			FROM employees
			WHERE is_deleted  = 0
			AND id = '.$id.'
			'
        );

        if($result->num_rows()>0){

            return $result->row();
        }else{

            return false;

        }
    }

   function employee_attendance($id)
   {
       $total_days = 0;
       $start_date_query = $this->db->query('SELECT MIN(date) as min_date from checks WHERE employee_id="'.$id.'"');
       $start_date_result = $start_date_query->result();

       foreach ($start_date_result as $row)
       {
           $start_date = $row->min_date;
       }
       $end_date = date('Y/m/d');

//       echo "The start date: " .$start_date."<br>";
//       echo "The end date: " .$end_date."<br>";

       $diff = strtotime($end_date) - strtotime($start_date);

       $total_days = round($diff / (60 * 60 * 24));

//       echo "The total days: ".$total_days."<br>";
        $presents=0; $absents=0; $holidays=0;
        $data[]=array();
       for($i=$total_days; $i>=0; $i--)
       {
           $filter_date =  date("Y-m-d", strtotime( date( 'Y-m-d' )." -".$i." days"));
           //echo "The filter date: ".$filter_date."<br>";
           $checks = $this->db->where("employee_id",$_GET["employee_id"])->where("DATE(date)",$filter_date)->get("checks")->result_object();

//           $is_holiday = false;
           $holiday =$this->db->where("DATE(date)",$filter_date)->get("holidays")->result_object()[0];
//           if($holiday)
//           {
//               $is_holiday = true;
//           }

           if(count($checks)>0)
           {
//               echo "Present on date: ".$filter_date."<br>";
               $presents++;
           }
           elseif ($holiday)
           {
//               echo "Holiday on date: ".$filter_date."<br>";
               $holidays++;
           }
           else
           {
//               echo "Absent on date: ".$filter_date."<br>";
               $absents++;
           }
       }

       $total = $absents+$presents+$holidays;

       $data["labels"][] = array("presents","absents", "holidays");
       $data["data"][] = array($presents,$absents, $holidays);


       return json_encode($data);
   }
   //For presence trends
    function employeeAttendanceByDate($startDate, $endDate)
    {
        $query =  $this->db->query('SELECT COUNT(DISTINCT (employee_id)) as employee_count,date 
                                    FROM checks WHERE date >="'.$startDate.'" AND date <= "'.$endDate.'" 
                                    group by date');

        $record = $query->result();

        return json_encode($record);
    }
    public function departmentAttendance($dep_id)
    {
        $emps = $this->db->query('
			SELECT *
			FROM employees
			WHERE is_deleted  = 0
			AND department = '.$dep_id.'
			'
        );
        $results = $emps->result();

        $data = array();
        foreach($results as $result) {

            array_push($data, $result->id);

        }
        $ids = join("','",$data);
        $query =  $this->db->query("SELECT COUNT(DISTINCT (employee_id)) as employee_count,date 
                                    FROM checks WHERE employee_id IN ('$ids') 
                                    group by date");

        $attDept = $query->result();

        return json_encode($attDept);

    }

    function employee_attendance_byDate($id,$startDate, $endDate)
    {
        $diff = strtotime($endDate) - strtotime($startDate);
        $total_days = 0;
        $total_days = round($diff / (60 * 60 * 24));
        $presents = 0;
        $absents = 0;
        $holidays = 0;
        $data[] = array();
        $filter_date_list = array();
        $presentOnDate = array();
        for($i=0; $i<=$total_days; $i++){
            $filter_date =  date("Y-m-d", strtotime( $endDate." -".$i." days"));
            $checks = $this->db->where("employee_id",$id)->where("DATE(date)",$filter_date)->get("checks")->result_object();
            $holiday =$this->db->where("DATE(date)",$filter_date)->get("holidays")->result_object()[0];

            array_push($filter_date_list, $filter_date);
           if(count($checks)>0)
           {
               array_push($presentOnDate, $filter_date);
//               echo "Present on date: ".$filter_date."<br>";
               $presents++;
           }
           elseif ($holiday)
           {
//               echo "Holiday on date: ".$filter_date."<br>";
               $holidays++;
           }
           else
           {
//               echo "Absent on date: ".$filter_date."<br>";
               $absents++;
           }
        }
//    exit();

        $total = $absents + $presents + $holidays;

        $data["labels"][] = array("presents", "absents", "holidays");
        $data["data"][] = array($presents, $absents, $holidays);
//        $data["dates"][] = array($filter_date_list);
        $data["CheckedIn"][] = array($presentOnDate);


        return json_encode($data);
    }
}