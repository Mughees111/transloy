<?php

class Employees_model extends CI_Model{
	
	public function get_all_employees($field='id',$order = 'DESC')
	{


		if(isEmployee())
		{
			$the_employee = getEmployee();



			$my_deparment = $this->db->where("id",$the_employee->department)->get("departments")->result_object()[0];


			if($my_deparment)
			{
				$arr = array(-1);



				for($i=0;$i<=20;$i++)
				{

					$my_deparment = $this->db->where("parent",$my_deparment->id)->get("departments")->result_object()[0];

					if(!$my_deparment) break;

					$arr[] = $my_deparment->id;
				}


			}
			else{
				return [];
			}


			$this->db->where("id !=",$the_employee->id);
			$this->db->where_in("department",$arr);
			$this->db->where("is_deleted",0);
			$r=$this->db->get("employees")->result_object();
			return $r;
		}
		else{
	        $result = $this->db->query('
				SELECT *
				FROM employees
				WHERE is_deleted  = 0
				ORDER BY '.$field.' '.$order.'
				'
	        );

        	return $result->result_object();

	    }


	}
	public function get_all_trashed_employees($field='id',$order = 'DESC')
	{
        $result = $this->db->query('
			SELECT *
			FROM employees
			WHERE is_deleted  = 1
			ORDER BY '.$field.' '.$order.'
			'
        );

        return $result;

	}

    public function get_all_active_employees($field='id',$order = 'DESC')
    {
        $result = $this->db->query('
			SELECT *
			FROM employees
			WHERE is_deleted  = 0
			AND status  = 1
			ORDER BY '.$field.' '.$order.'
			'
        );

        return $result;

    }
	public function get_employee_by_email($email)
	{
        $result = $this->db->query('
			SELECT *
			FROM employees
			WHERE is_deleted  = 0
			AND email = "'.$email.'"
			'
        );

        return $result;

	}


	public function get_employee_by_employee_id($employee_id)
	{
        $result = $this->db->query('
			SELECT *
			FROM employees
			WHERE is_deleted  = 0
			AND employee_id = "'.$employee_id.'"
			'
        );

        return $result;

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
}


?>
