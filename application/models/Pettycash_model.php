<?php

class Pettycash_model  extends CI_Model
{
    function getEveryRecord()
    {
        $this->db->where("is_deleted", 0);
        $this->db->order_by("id", "DESC");
        $result = $this->db->get('pettycash_form')->result_object();

        $response_array = array();

        foreach ($result as $row) {
            $allowanceObject = new stdClass();
            $allowanceObject->id = $row->id;
            $allowanceObject->empId = $row->user_id;
            $allowanceObject->siteId = $row->site_id;
            $allowanceObject->approvedBy = $row->approved_by;
            $allowanceObject->actionDate = $row->updated_at;
            $allowanceObject->appliedDate = $row->applied_date;
            $allowanceObject->totalAmount = $row->total_amount;
            $allowanceObject->status = $row->status;

            $this->db->where("pc_form_id", $row->id);
            $this->db->where("is_deleted", 0);
            $claims_result = $this->db->get("pettycash_form_data")->result_object();

            $text = "";
            foreach ($claims_result as $c) {
                
                $text = $text .  getAllowanceText($c->allowance_type) . "   :   " . " RM " . $c->amount . "</br>";
            }

            $allowanceObject->claims = $text;
            $response_array[] = $allowanceObject;
         }

         return $response_array;
    }
}