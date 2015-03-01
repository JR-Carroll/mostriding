<script src="/js/app/app.js"></script>
<link rel="stylesheet" href="/css/app/jquery.sceditor.default.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="/css/app//themes/default.min.css" type="text/css" media="all" />
 
<div class="container-fliud"> 
    <section class="content-wraper">
    <?php if(isset($courseSchedule['course_schedule_id'])){?>
	<h2>Edit Course Schedule</h2>
	<?php }else{?>
	<h2>Add Course Schedule</h2>
	<?php }?>
	
    <div class="form">        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
		
		<form enctype="multipart/form-data" class="form-horizontal"
			id="courseScheduleForm" name="courseScheduleForm" method="post"
			action="<?php echo SUB_CONTEXT?>/schedules/update">

			<input type="hidden" name="course_schedule_id"
				value="<?php if (isset($courseSchedule['course_schedule_id'])) echo $courseSchedule['course_schedule_id'];?>" />
			<div class="form-group">
				<label for="name" class="col-lg-3 control-label">Name *</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="name"
						name="name"
						value="<?php if (isset($courseSchedule['name'])) echo $courseSchedule['name'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label for="course_code" class="col-lg-3 control-label">Course*</label>
				<div class="col-lg-6">					
					<select class="form-control" name="course_code">
					   <option value="">Please Choose</option>
					   <?php foreach(getCourseCodes() as $courseInfo){?>
					       <option <?php echo isset($courseSchedule['course_code']) && $courseSchedule['course_code'] ==  $courseInfo['code'] ? 'selected' : '' ?> value="<?php echo $courseInfo['code']?>"><?php echo $courseInfo['code'].' - '.$courseInfo['name']?></option>
					   <?php }?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="location_code" class="col-lg-3 control-label">Location*</label>
				<div class="col-lg-6">					
					<select class="form-control" name="location_code">
					   <option value="">Please Choose</option>
					   <?php foreach(getAvailableLocations() as $locInfo){?>
					       <option <?php echo isset($courseSchedule['location_code']) &&  $courseSchedule['location_code'] ==  $locInfo['code'] ? 'selected' : '' ?> value="<?php echo $locInfo['code']?>"><?php echo $locInfo['code'].' - '.$locInfo['location']?></option>
					   <?php }?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="trainer_name" class="col-lg-3 control-label">Trainer name*</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="trainer_name"
						name="trainer_name"
						value="<?php if (isset($courseSchedule['trainer_name'])) echo $courseSchedule['trainer_name'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label for="available_slots" class="col-lg-3 control-label">Available Slots*</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="available_slots"
						name="available_slots"
						value="<?php if (isset($courseSchedule['available_slots'])) echo $courseSchedule['available_slots'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label for="start_date" class="col-lg-3 control-label">Start Date</label>
				<div class="col-lg-6">				
                    <input type="text" name="start_date" class="datepicker form-control" data-date-format="yyyy-mm-dd" data-date="<?php if (isset($courseSchedule['start_date'])) echo $courseSchedule['start_date'];?>" value="<?php if (isset($courseSchedule['start_date'])) echo $courseSchedule['start_date'];?>"
                     id="start_date" readonly="">                                    
                </div>
			</div>
			<div class="form-group">
				<label for="end_date" class="col-lg-3 control-label">End Date</label>
				<div class="col-lg-6">
					
				    <input type="text" name="end_date" class="datepicker form-control" data-date-format="yyyy-mm-dd" data-date="<?php if (isset($courseSchedule['end_date'])) echo $courseSchedule['end_date'];?>" value="<?php if (isset($courseSchedule['end_date'])) echo $courseSchedule['end_date'];?>"
                     id="end_date" readonly="">                     
                </div>
			</div>
			
			
			<div class="form-group">
				<label for="time_content" class="col-lg-3 control-label">Time Display</label>
				<div class="col-lg-6">
					<textarea rows="10" cols="50" name="time_content" id="time_content"
						class="form-control"><?php if (isset($courseSchedule['time_content'])) echo $courseSchedule['time_content']; ?></textarea>                    
                </div>
			</div>

			<div class="form-group">
				<label class="col-lg-5 control-label submitForm pull-right">
					<button class="btn btn-info" name="save">Save</button> <span
					class="or">OR</span> <a href="<?php echo SUB_CONTEXT.'/schedules'?>" class="cancel">Cancel</a>
				</label>
			</div>
		</form>
	</div>
</section>
</div>
