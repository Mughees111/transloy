<?php

class Departments_model extends CI_Model{
	
	public function get_all_departments($field='id',$order = 'DESC')
	{
        $result = $this->db->query('
			SELECT *
			FROM departments
			WHERE is_deleted  = 0
			ORDER BY '.$field.' '.$order.'
			'
        );

        return $result;
	}

	public function get_all_trash_departments($field='id',$order = 'DESC')
	{
        $result = $this->db->query('
			SELECT *
			FROM departments
			WHERE is_deleted  = 1
			ORDER BY '.$field.' '.$order.'
			'
        );

        return $result;
	}

    public function get_all_active_departments($field='id',$order = 'DESC')
    {
        $result = $this->db->query('
			SELECT *
			FROM departments
			WHERE is_deleted  = 0
			AND status  = 1
			ORDER BY '.$field.' '.$order.'
			'
        );

        return $result;
    }
	public function get_department_by_title($title)
	{
        $result = $this->db->query('
			SELECT *
			FROM departments
			WHERE is_deleted  = 0
			AND title = "'.$title.'"
			'
        );

        return $result;
	}

	public function get_department_by_id($id){

        $result = $this->db->query('
			SELECT *
			FROM departments
			WHERE is_deleted  = 0
			AND id = '.$id.'
			ORDER BY id DESC
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
