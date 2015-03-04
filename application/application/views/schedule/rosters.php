<div class="container-fliud"> 
    <section class="content-wraper">
        <h2>Course Schedules Rosters (<?php echo $courseSchedule['name']?>)</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-12">
                
        <?php if(getRemainingSlots($courseSchedule['course_schedule_id']) != 0){?>
       
                <a style="margin-left: 10px;"  href="<?php echo SUB_CONTEXT.'/schedules/addRoster/'.$courseSchedule['course_schedule_id']?>" class="btn btn-info pull-right">Add New Particpant</a>
            
        <?php }else{?>
        <div class="alert alert-success">No More Course Schedule slots available</div>
        <?php }?>
            <a href="<?php echo SUB_CONTEXT.'/schedules/printRosters/'.$courseSchedule['course_schedule_id']?>" class="btn btn-info pull-right">Print Rosters</a>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-xs-12">            
                <?php if(count($rosters) == 0){?>
                No Participants
                <?php }else{?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                        	
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Confirmation Code</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rosters as $roster){?>
                        <tr>    
                            <td><?php echo $roster['first_name'].' '.$roster['last_name'];?></td>
                            <td><?php echo $roster['email'];?></td>
                            <td><?php echo $roster['phone'];?></td>
                            <td>&nbsp;<?php echo isset($roster['transaction_status']) ? $roster['transaction_status'] : '';?></td>                                                        
                            <td>
                                
                                <a data-course_schedule_id='<?php echo $roster['course_schedule_id']?>' data-course_schedule_participant_id='<?php echo $roster['course_schedule_participant_id']?>' href="javascript: void(0);" class="glyphicon glyphicon-remove btn-delete"></a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <?php }?>
            </div>
        </div>
        
    </section>
</div>
<script>
$(document).ready(function() {
   $('table').dataTable();
   $('.btn-delete').on('click', function(){
	   if(confirm("Are you sure want to delete this participant?")){
		   $.post('<?php echo SUB_CONTEXT.'/schedules/deleteParticipant'?>', 'course_schedule_participant_id='+$(this).data('course_schedule_participant_id') + '&course_schedule_id='+$(this).data('course_schedule_id'), function(data){
			   $('.main-body-content').html(data);
			   $('table').dataTable();
		   });
		   
	   }
   });
});
</script>