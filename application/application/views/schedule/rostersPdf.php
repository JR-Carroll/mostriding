<div class="container-fliud"> 
    <section class="content-wraper">
        <h2>Course Information</h2>
        <div class="row">
        <p>Name: <?php echo $courseSchedule['name']?></p>
        <p>Course: <?php echo $courseSchedule['course_code']?></p>
        <p>Location: <?php echo $courseSchedule['location_code']?></p>
        <p>Start Date: <?php echo $courseSchedule['start_date']?></p>
        <p>End Date: <?php echo $courseSchedule['end_date']?></p>
        <p>Trainer Name: <?php echo $courseSchedule['trainer_name']?></p>
        </div>
         <h2>Course Schedules Rosters</h2>
        <div class="row">
            <div class="col-xs-12">            
                <?php if(count($rosters) == 0){?>
                No Participants
                <?php }else{?>
                <table class="table table-condensed table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Confirmation Code</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rosters as $roster){?>
                        <tr>    
                            <td><?php echo $roster['first_name'].' '.$roster['last_name'];?></td>
                            <td><?php echo $roster['email'];?></td>
                            <td><?php echo $roster['phone'];?></td>
                            <td>&nbsp;<?php echo isset($roster['transaction_status']) ? $roster['transaction_status'] : '';?></td>                                                                                   
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <?php }?>
            </div>
        </div>
        
    </section>
</div>