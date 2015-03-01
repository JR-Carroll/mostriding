<div class="container-fliud"> 
    <section class="content-wraper">
    
	<h2>Add Participant (<?php echo $courseSchedule['name']?>)</h2>
	
    <div class="form">        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
		
		<form enctype="multipart/form-data" class="form-horizontal"
			id="courseScheduleForm" name="courseScheduleForm" method="post"
			action="<?php echo SUB_CONTEXT.'/schedules/addParticipant/'.$courseSchedule['course_schedule_id']?>">
			
			<div class="form-group">
				<label for="first_name" class="col-lg-3 control-label">First Name *</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="first_name"
						name="first_name"
						value="<?php if (isset($input['first_name'])) echo $input['first_name'];?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="last_name" class="col-lg-3 control-label">Last Name *</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="last_name"
						name="last_name"
						value="<?php if (isset($input['last_name'])) echo $input['last_name'];?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-lg-3 control-label">Email *</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="email"
						name="email"
						value="<?php if (isset($input['email'])) echo $input['email'];?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="phone" class="col-lg-3 control-label">Phone *</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="phone"
						name="phone"
						value="<?php if (isset($input['phone'])) echo $input['phone'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-5 control-label submitForm pull-right">
					<button class="btn btn-info" name="save">Save</button> <span
					class="or">OR</span> <a href="<?php echo SUB_CONTEXT.'/schedules/rosters/'.$courseSchedule['course_schedule_id']?>" class="cancel">Cancel</a>
				</label>
			</div>
		</form>
	</div>
</section>
</div>
