<link href="/css/bootstrap.min.css" rel="stylesheet">
<?php 
foreach(getCourseCodes() as $courseInfo){
?>
<h3><?php echo $courseInfo['code'].' - '.$courseInfo['name']?></h3>
<?php if(count($course_schedules[$courseInfo['code']]) == 0){?>
No Available Schedule
<?php }else{?>
<ul>
    <?php foreach($course_schedules[$courseInfo['code']] as $scheds){?>
    <li>
        <b>Name</b>:&nbsp;<?php echo $scheds['name'];?><br />
        <b>Schedule</b>:&nbsp;<?php echo date('M d, Y', strtotime($scheds['start_date'])) . ' to ' .date('M d, Y', strtotime($scheds['end_date']))?>
        <?php echo $scheds['time_content']?><br />
        <?php 
        $remainingSlots = getRemainingSlots($scheds['course_schedule_id']);
        ?>
        <b>Available Slots</b>:&nbsp;<?php echo $remainingSlots?><br />
        <?php if($remainingSlots != 0){?>
        <a href="<?php echo SUB_CONTEXT.'/schedules/register/'.$scheds['course_schedule_id']?>" class="btn btn-info">Register</a>
        <?php }?>
    </li>
    <?php }?>
</ul>
<?php }?>
<?php    
}
?>