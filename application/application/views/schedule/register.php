<?php 
if($isGC === false && $courseSchedule === false){
?>
<div class="alert alert-danger">Course not available</div>
<?php 
}else if($isGC === false && $courseSchedule !== false && getRemainingSlots($courseSchedule['course_schedule_id']) == 0 ){
?>
<div class="alert alert-danger">No More Slots Available</div>
<?php     
}else{
?>
<!-- 
Submit to payment gateway for registration

Course Id: <?php echo $courseSchedule['course_schedule_id']?>
Course Price: <?php echo number_format(getCoursePrice($courseSchedule['course_code']))?>
 -->
<div class="container-fliud"> 
  <div class="row" style="text-align: center">
    <br />
  <img style="text-align: center" border="0" src="http://bit.ly/ISUR8X">
  </div>
    <section class="content-wraper">
    <?php if($courseSchedule !== false){?>
	<h2>Register: (<?php echo $courseSchedule['name']?> - <?php echo '$'.number_format(getCoursePrice($courseSchedule['course_code']), 2)?>)</h2>
	<?php }else{?>
	<h2>Buy Gift Certificate: (<?php echo getCourseName($courseCode)?> - <?php echo '$'.number_format(getCoursePrice($courseCode), 2)?>)</h2>
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
			action="<?php echo SUB_CONTEXT.'/order/payment'?>">
			<input type="hidden" name="course_schedule_id" value="<?php echo $courseSchedule['course_schedule_id']?>"/>
			<input type="hidden" name="course_code" value="<?php echo $courseCode?>"/>
			<input type="hidden" name="isGC" value="<?php echo $isGC ? '1' : '0'?>"/>
			<?php if($courseSchedule !== false){?>
			<div class="form-group">
				<label for="schedule" class="col-lg-3 control-label">Schedule *</label>
				<div class="col-lg-6">
					<label  class="control-label"><?php echo date('M d, Y', strtotime($courseSchedule['start_date'])) . ' to ' .date('M d, Y', strtotime($courseSchedule['end_date']))?></label>
				</div>
			</div>
			<?php }?>
			
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
				<label for="address" class="col-lg-3 control-label">Complete Address *</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="address"
						name="address"
						value="<?php if (isset($input['address'])) echo $input['address'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="cardNumber" class="col-lg-3 control-label">Card # *</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="cardNumber"
						name="cardNumber"
						value="<?php if (isset($input['cardNumber'])) echo $input['cardNumber'];?>" />
				</div>
			</div>
			<div class="form-group" style="margin-bottom: 0px">
				<label for="expDate" class="col-lg-3 control-label">Exp Date *</label>
				<div class="col-lg-2 form-group" style="margin-left:1px">
						<select id="exp_month" name='exp_month' class="form-control">
							<option value="01">01 - January</option>
							<option value="02">02 - February</option>
							<option value="03">03 - March</option>
							<option value="04">04 - April</option>
							<option value="05">05 - May</option>
							<option value="06">06 - June</option>
							<option value="07">07 - July</option>
							<option value="08">08 - August</option>
							<option value="09">09 - September</option>
							<option value="10">10 - October</option>
							<option value="11">11 - November</option>
							<option value="12">12 - December</option>
						</select>
					</div>
					<div class="col-lg-2  form-group">
						<select id="exp_year" name="exp_year" class="form-control">
							<?php for($i = Date('Y'); $i<Date('Y') + 10; $i++){?>
								<option value="<?php echo substr($i, -2);?>"><?php echo $i?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-md-3 form-group">
						
					</div>
			</div>
			<div class="form-group">
				<label for="cvc" class="col-lg-3 control-label">CVC*</label>
				<div class="col-lg-2">
					<input type="text" class="form-control" id="cvc"
						name="cvc"
						value="<?php if (isset($input['cvc'])) echo $input['cvc'];?>" />
				</div>
			</div>
			

			<div class="form-group">
				<label class="col-lg-5 control-label submitForm pull-right">
					<button class="btn btn-info" name="save"><?php echo $isGC ? 'Buy' : 'Register'?></button> <span
					class="or">OR</span> <a href="/schedule.html" class="cancel">Cancel</a>
				</label>
			</div>
		</form>
	</div>
</section>
</div>

<?php     
}
?>