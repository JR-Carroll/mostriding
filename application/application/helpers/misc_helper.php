<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $filename='', $stream=TRUE)
{
    require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}

if ( ! function_exists('isAuthenticated'))
{
    function isAuthenticated()
    {
          $ci =& get_instance();
          $userInfo = $ci->session->userdata('user_info') 
                    ?  $ci->session->userdata('user_info') 
                    : false;
          
		  if($userInfo !== false){
		      return true;
		  }	
		  redirect('users/login');
    }   
}
if ( ! function_exists('isUserAuthenticated'))
{
    function isUserAuthenticated()
    {
        $ci =& get_instance();
        $userInfo = $ci->session->userdata('user_info')
        ?  $ci->session->userdata('user_info')
        : false;

        if($userInfo !== false){
            return true;
        }
          return false;
    }
}

if ( ! function_exists('getRemainingSlots'))
{
    function getRemainingSlots($courseScheduleId)
    {
         $ci =& get_instance();
         $ci->load->model('schedule');
         $courseSchedule = $ci->schedule->getCourseSchedule($courseScheduleId);
         $rosters = $ci->schedule->getRosters($courseScheduleId);
         return $courseSchedule['available_slots'] - count($rosters);
    }
}

if ( ! function_exists('getCourseCodes'))
{
    function getCourseCodes()
    {
        $courseList = json_decode(COURSES);
        $listOfCourses = array();
        foreach($courseList as $courseInfo){
        
            $course = array();
            $course['code'] = $courseInfo->code;
            $course['name'] = $courseInfo->name;
            $course['price'] = $courseInfo->price;
          
            $listOfCourses[] = $course;
        }
        return $listOfCourses;
    }
}

if ( ! function_exists('getAvailableLocations'))
{
    function getAvailableLocations()
    {
        $locList = json_decode(LOCATIONS);
        $listOfLocations = array();
        foreach($locList as $locInfo){
        
            $loc = array();
            $loc['code'] = $locInfo->code;
            $loc['location'] = $locInfo->location;
          
            $listOfLocations[] = $loc;
        }
        return $listOfLocations;
    }
}

if ( ! function_exists('getCoursePrice'))
{
    function getCoursePrice($courseCode)
    {
        $courseList = json_decode(COURSES);
        foreach($courseList as $courseInfo){
        
            $course = array();
            if($courseInfo->code == $courseCode)
                return $courseInfo->price;
            
        }
        return 0;
    }
}

if ( ! function_exists('getLocationInfo'))
{
    function getLocationInfo($locationCode)
    {
        $locList = json_decode(LOCATIONS);
        foreach($locList as $locInfo){
        
            $loc = array();
            if($locationCode == $locInfo->code)
                return $locInfo->location;
          
        }
        return '';
    }
}
