<?php 
if($courseSchedule === false){
?>
<div class="alert alert-danger">Course not available</div>
<?php 
}else if(getRemainingSlots($courseSchedule['course_schedule_id']) == 0 ){
?>
<div class="alert alert-danger">No More Slots Available</div>
<?php     
}else{
?>
Submit to payment gateway for registration

Course Id: <?php echo $courseSchedule['course_schedule_id']?>
Course Price: <?php echo number_format(getCoursePrice($courseSchedule['course_code']))?>
<?php     
}
?>