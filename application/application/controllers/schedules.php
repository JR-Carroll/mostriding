<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * New class for handling email templates for the application
 */
class Schedules extends CI_Controller {
	
	

    function __construct() {
        parent::__construct();
		$this->load->model('schedule');
        
       
    }
    /*
     * Shows the list of email templates to the user
     */
    public function index() {
        
        if (isAuthenticated()) {  
                      
            $data['course_schedules'] = $this->schedule->getSchedules();
            
            $data['content'] = $this->load->view('schedule/lists', $data, true);

            $this->load->view('layouts/main', $data);
        }
    }
    public function filter() {
        if (isAuthenticated()) {
            $filterParams = $_REQUEST;
            $data['course_schedules'] = $this->schedule->getSchedules($filterParams);
    
            $this->load->view('schedule/_lists', $data);    
        }
    }
    public function displayCurrentSchedules(){
        $courseCodes = getCourseCodes();
        foreach($courseCodes as $courseInfo){
            $filterParams = array();
            $filterParams['course_code'] = $courseInfo['code'];
            $filterParams['start_date >='] = date('y-m-d');
            $data['course_schedules'][$courseInfo['code']] = $this->schedule->getAvailableSchedules($filterParams);
        }
        $data['includeCss'] = 1;
        if(isset($_REQUEST['includeCss']) && $_REQUEST['includeCss'] == '0'){
        	$data['includeCss'] = 0; 
        }
        $this->load->view('schedule/availableScheds', $data);
    }
    public function register($courseScheduleId){
        $data['isGC'] = false;
        $data['courseCode'] = '';
        $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);        
        $data['content'] = $this->load->view('schedule/register', $data, true);
        $this->load->view('layouts/main', $data);
    }
    public function buyCertificate($courseCode){
        $price = getCoursePrice($courseCode);
        if($price !== 0){
            $data['courseSchedule'] = false;
            $data['isGC'] = true;
            $data['courseCode'] = $courseCode;
            $data['content'] = $this->load->view('schedule/register', $data, true);
        }else{
            $data['content'] = $this->load->view('schedule/invalid', array(), true);
        }
        $this->load->view('layouts/main', $data);
    }
    /*
     * Brings the user to the add new email template page
     */
    public function add() {
        if (isAuthenticated()) {
            $data['courseSchedule'] = array();
            
            $data['content'] = $this->load->view('schedule/_form', $data, true);            
            $this->load->view('layouts/main', $data);          
        }
    }
    /*
     * Allows the user to edit an email template
     */
    public function edit($courseScheduleId) {
        if (isAuthenticated()) {
            $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
            $data['content'] = $this->load->view('schedule/_form', $data, true);            
            $this->load->view('layouts/main', $data);       
        } 
    }
    
    public function rosters($courseScheduleId) {
        if (isAuthenticated()) {
            $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
            $data['rosters'] = $this->schedule->getRosters($courseScheduleId);
            $data['content'] = $this->load->view('schedule/rosters', $data, true);
            $this->load->view('layouts/main', $data);
        }
    }
    
    public function printRosters($courseScheduleId) {
        if (isAuthenticated()) {
            $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
            $data['rosters'] = $this->schedule->getRosters($courseScheduleId);
            $html = $this->load->view('schedule/rostersPdf', $data, true);
            pdf_create($html, 'rosters.pdf');
        }
    }
    
    
    public function addRoster($courseScheduleId) {
        if (isAuthenticated()) {
            $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
            $data['content'] = $this->load->view('schedule/addParticipant', $data, true);
            $this->load->view('layouts/main', $data);
        }
    }
    /*
     * Deletes the specific email templates from the system 
     */
    public function delete() {
    	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    		redirect('schedules');
    	}
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isAuthenticated()) {
                $courseScheduleId = $_POST['course_schedule_id'];
                $this->schedule->deleteCourseSchedule($courseScheduleId);
                $data['success'] = 'Course Schedule Deleted Successfully';
                $data['course_schedules'] = $this->schedule->getSchedules();
                $this->load->view('schedule/lists', $data);
                
            } 
        }
    }
    public function deleteParticipant() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('schedules');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isAuthenticated()) {
                $courseScheduleParticipantId = $_POST['course_schedule_participant_id'];
                $courseScheduleId = $_POST['course_schedule_id'];
                $this->schedule->deleteCourseParticipant($courseScheduleParticipantId);
                $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
                $data['success'] = 'Participant Deleted Successfully';
                $data['rosters'] = $this->schedule->getRosters($courseScheduleId);
                $this->load->view('schedule/rosters', $data);
    
            }
        }
    }
    public function shouldbeInteger($str)
    {
        if ($str == '' || !is_numeric($str))
        {
            $this->form_validation->set_message('shouldbeInteger', 'The %s field should be an integer');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function addParticipant($courseScheduleId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('schedules');
        }
        if (isAuthenticated()) {
            $input = $this->input->post();
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
             
            //template has errors
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
                $data['input'] = $input;
            }else {
                //template is for saving
                $data['success'] = 'Course Schedule Participant Added Successfully';
                
                 
                $participant = array();
                $participant = $input;
                $participant['course_schedule_id'] = $courseScheduleId;
                unset($participant['save']);
                $res = $this->schedule->addCourseParticipant($participant);
            }
    
    
            $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
            $data['content'] = $this->load->view('schedule/addParticipant', $data, true);
            $this->load->view('layouts/main', $data);
        }
    }
    /*
     * This is used to to update/create new email template on the sytem
     * It validates the user input for uniqueness and if there are valid email addresses
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('schedules');
        }
        if (isAuthenticated()) {
            $input = $this->input->post();
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('course_code', 'Course', 'trim|required');
            $this->form_validation->set_rules('location_code', 'Location', 'trim|required');
            $this->form_validation->set_rules('trainer_name', 'Trainer Name', 'trim|required');
            $this->form_validation->set_rules('available_slots', 'Available Slots', 'trim|required|callback_shouldBeInteger');
            $this->form_validation->set_rules('time_content', 'Time Content', 'trim|required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
            $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
                       
            $courseSchedule = $this->schedule->getCourseScheduleByName($input['name']);
            //template has errors
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
                $data['courseSchedule'] = $input;
            } else if(($input['course_schedule_id'] == '' &&  $courseSchedule !== false) || ($input['course_schedule_id'] != '' && $courseSchedule !== false && $courseSchedule['course_schedule_id'] != $input['course_schedule_id'] )) {
            	//template name is not unique
            	$data['error'] = 'Course Name not unique, please try again';
            	$data['courseSchedule'] = $input;
            }else {
            	//template is for saving
               	$data['success'] = 'Course Schedule Saved Successfully';
               
               	$courseSchedule = array();
               	$courseSchedule = $input;
               	unset($courseSchedule['save']);
               	$res = $this->schedule->saveCourseSchedule($courseSchedule);
               
                $data['courseSchedule'] = $res;
            }
            
            
            $data['content'] = $this->load->view('schedule/_form', $data, true);            
            $this->load->view('layouts/main', $data);      
        }
    }
}
