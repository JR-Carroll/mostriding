<?php if($includeCss == 1){?>
<link href="/css/bootstrap.min.css" rel="stylesheet">
<?php }?>
<div class="col-xs-12">
<?php 
foreach(getCourseCodes() as $courseInfo){
?>
<h3 class="lead"><?php echo $courseInfo['code'].' - '.$courseInfo['name']?></h3>
<?php if(count($course_schedules[$courseInfo['code']]) == 0){?>
<p style="color: #fff">No Available Schedule</p>
<?php }else{?>
<table class="table table-condensed table-striped table-bordered schedule">
    <thead>
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Schedule</th>
            <th>Remaining Slots</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <?php foreach($course_schedules[$courseInfo['code']] as $scheds){?>
    <tr>
        <td><?php echo $scheds['name'];?></td>
        <td><?php echo $scheds['location_code']. ' - '.getLocationInfo($scheds['location_code']);?></td>
        <td><?php echo date('M d, Y', strtotime($scheds['start_date'])) . ' to ' .date('M d, Y', strtotime($scheds['end_date']))?><br />
        <?php echo $scheds['time_content']?>
        <?php 
        $remainingSlots = getRemainingSlots($scheds['course_schedule_id']);
        ?>
        </td>
        <td><?php echo $remainingSlots?></td>
        <td style="text-align: center">&nbsp;
        <?php if($remainingSlots != 0){?>
        <a href="<?php echo SUB_CONTEXT.'/schedules/register/'.$scheds['course_schedule_id']?>" class="btn btn-md fp-buttons orange-bkgrnd">Register</a>
        </td>
        <?php }?>
    </li>
    <?php }?>
</table>
<?php }?>
<?php    
}
?>
</div>
<style>
table.schedule tr th, table.schedule tr td{
	text-align: center;
	vertical-align: middle;
}
table.schedule tr th{
	background-color: #fff;
}
table.schedule tr td{
	font-size: 12px;
}
</style>