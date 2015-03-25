<div class="row">
    <div class="col-xs-12">            
        <?php if(count($course_schedules) == 0){?>
        No Results
        <?php }else{?>
        <table class="table table-condensed table-striped data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Course</th>
                    <th>Location</th>
                    <th>Trainer Name</th>
                    <th>Available Slots</th>
                    <th>Remaining Slots</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($course_schedules as $schedInfo){?>
                <tr>    
                    <td><?php echo $schedInfo['name'];?></td>
                    <td><?php echo $schedInfo['start_date'];?></td>
                    <td><?php echo $schedInfo['end_date'];?></td>
                    <td><?php echo $schedInfo['course_code'];?></td>
                    <td><?php echo $schedInfo['location_code'];?></td>
                    <td><?php echo $schedInfo['trainer_name'];?></td>
                    <td><?php echo $schedInfo['available_slots'];?></td>
                    <td><?php echo getRemainingSlots($schedInfo['course_schedule_id']);?></td>                            
                    <td>
                        <a href="<?php echo SUB_CONTEXT.'/schedules/rosters/'.$schedInfo['course_schedule_id']; ?>">Rosters</a>
                        &nbsp;
                        <a href="<?php echo SUB_CONTEXT.'/schedules/edit/'.$schedInfo['course_schedule_id']; ?>">Edit</a>
                        &nbsp;
                        <a data-course_schedule-id='<?php echo $schedInfo['course_schedule_id']?>' href="javascript: void(0);" class="glyphicon glyphicon-remove btn-delete"></a>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        <?php }?>
    </div>
</div>