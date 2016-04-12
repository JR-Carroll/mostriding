<?php

class Schedule extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function getSchedules($filterParams = array()) {
        try{
            $this->db->order_by("start_date", "desc");
            
            $filterParams['is_active'] = 1;
           
            if(isset($filterParams['course_code']) && $filterParams['course_code'] == ''){
                unset($filterParams['course_code']);
            }
            if(isset($filterParams['location_code']) &&$filterParams['location_code'] == ''){
                unset($filterParams['location_code']);
            }
            if(isset($filterParams['start_date']) && $filterParams['start_date'] == ''){
                unset($filterParams['start_date']);
            }
            if(isset($filterParams['schedules/filter']))
                unset($filterParams['schedules/filter']);
            //var_dump($filterParams);
            $query = $this->db->where($filterParams)->get('course_schedule');
            //var_dump($query);
            //die;
            $schedules = $query->result_array();
            
            if (count($schedules) > 0)
                return $schedules;
            else
                return array();
        
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
    public function getAvailableSchedules($filterParams = array()) {
        try{
            $this->db->order_by("start_date", "desc");
    
            $filterParams['is_active'] = 1;
             
            if(isset($filterParams['course_code']) && $filterParams['course_code'] == ''){
                unset($filterParams['course_code']);
            }
            if(isset($filterParams['start_date']) && $filterParams['start_date'] == ''){
                unset($filterParams['start_date']);
            }
            if(isset($filterParams['schedules/filter']))
                unset($filterParams['schedules/filter']);
            
            //var_dump($filterParams);
            $query = $this->db->where($filterParams)->get('course_schedule');
            $schedules = $query->result_array();
    
            if (count($schedules) > 0)
                return $schedules;
            else
                return array();
    
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
    
    
    public function getCourseScheduleByName($courseName){
        try{
            $query = $this->db
            ->select()
            ->where(array('name'=>$courseName))
            ->get('course_schedule');
            $courseSchedule = $query->result_array();
            
            if (count($courseSchedule) > 0) {
                return $courseSchedule[0];
            }else
                return false;
    
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
    public function saveCourseSchedule($details) {
        try {
            $details['updated_at'] = date("Y-m-d H:i:s");
            if ($details['course_schedule_id'] == '') {
                unset($details['course_schedule_id']);
                $res = $this->db->insert('course_schedule', $details);
                //$details['course_schedule_id'] = $this->db->insert_id();
                $res = $this->getCourseScheduleByName($details['name']);
                //$res = $details;
            }else{
               
                $status = $this->db
                ->where(array('course_schedule_id' => $details['course_schedule_id']))
                ->set($details)
                ->update('course_schedule');
                $res = $details;
            }
             
            return $res;
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
         
    }
    public function addCourseParticipant($details) {
        try {
            $details['updated_at'] = date("Y-m-d H:i:s");
            $res = $this->db->insert('course_schedule_participant', $details);
            $details['course_schedule_participant_id'] = $res;
            $res = $details;
            
            return $res;
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
         
    }
    public function addCourseGiftCertificatePurchases($details) {
        try {
            $details['updated_at'] = date("Y-m-d H:i:s");
            $res = $this->db->insert('course_gift_certificates', $details);
            $details['course_gift_certificates_id'] = $res;
            $res = $details;
    
            return $res;
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
         
    }
    
    public function getCourseSchedule($courseScheduleId){
        try{
            $query = $this->db
            ->select()
            ->where(array('course_schedule_id'=>$courseScheduleId))
            ->get('course_schedule');
            $courseInfo = $query->result_array();
            if (count($courseInfo) > 0) {
                return $courseInfo[0];
            }else
                return false;
    
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
    
  
    public function deleteCourseSchedule($courseScheduleId){
    try {
            $details = array();
            $details['is_active'] = 0;
            $status = $this->db
                ->where(array('course_schedule_id' => $courseScheduleId))
                ->set($details)
                ->update('course_schedule');
            
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
    public function deleteCourseParticipant($courseScheduleParticipantId){
        try {
            $details = array();
           // $details['is_active'] = 0;
            $status = $this->db
            ->where(array('course_schedule_participant_id' => $courseScheduleParticipantId))
            //->set($details)
            ->delete('course_schedule_participant');
    
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
    
    public function getRosters($courseScheduleId) {
        try{
            $this->db->order_by("updated_at", "desc");
            /*
            $query = $this->db->get('course_schedule_participant');
            $participants = $query->result_array();
    		*/
            
            $query = $this->db
            ->select()
            ->where(array('course_schedule_id'=>$courseScheduleId))
            ->get('course_schedule_participant');
            $participants = $query->result_array();
            
            if (count($participants) > 0)
                return $participants;
            else
                return array();
    
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
	
}
?>