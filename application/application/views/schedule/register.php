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
				<label for="schedule" class="col-lg-3 control-label">Schedule</label>
				<div class="col-lg-6">
					<label  class="control-label"><?php echo date('M d, Y', strtotime($courseSchedule['start_date'])) . ' to ' .date('M d, Y', strtotime($courseSchedule['end_date']))?></label>
				</div>
			</div>
			<?php }?>
			
			<h2><center>Billing Information</center></h2>
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
				<label for="email" class="col-lg-3 control-label">Email </label>
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
				<label for="address" class="col-lg-3 control-label">Street Address</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="street_address"
						name="street_address"
						value="<?php if (isset($input['street_address'])) echo $input['street_address'];?>" />
				</div>
			</div>
			<div class="form-group">
			    <label for="address" class="col-lg-3 control-label">City</label> 
			    
				
				<div class="col-lg-6">
				    <div class="col-xs-4" style="padding-left: 0px">
					<input type="text" class="form-control" id="city"
						name="city"
						value="<?php if (isset($input['city'])) echo $input['city'];?>" />
					</div>
					<div class="col-xs-4">
    				<label for="address" class="col-lg-3 control-label">State</label>
    				<div class="col-lg-9">    				
    					<select class="form-control" id="state"
    						name="state">
                        	<option value="AL">Alabama</option>
                        	<option value="AK">Alaska</option>
                        	<option value="AZ">Arizona</option>
                        	<option value="AR">Arkansas</option>
                        	<option value="CA">California</option>
                        	<option value="CO">Colorado</option>
                        	<option value="CT">Connecticut</option>
                        	<option value="DE">Delaware</option>
                        	<option value="DC">District Of Columbia</option>
                        	<option value="FL">Florida</option>
                        	<option value="GA">Georgia</option>
                        	<option value="HI">Hawaii</option>
                        	<option value="ID">Idaho</option>
                        	<option value="IL">Illinois</option>
                        	<option value="IN">Indiana</option>
                        	<option value="IA">Iowa</option>
                        	<option value="KS">Kansas</option>
                        	<option value="KY">Kentucky</option>
                        	<option value="LA">Louisiana</option>
                        	<option value="ME">Maine</option>
                        	<option value="MD">Maryland</option>
                        	<option value="MA">Massachusetts</option>
                        	<option value="MI">Michigan</option>
                        	<option value="MN">Minnesota</option>
                        	<option value="MS">Mississippi</option>
                        	<option value="MO">Missouri</option>
                        	<option value="MT">Montana</option>
                        	<option value="NE">Nebraska</option>
                        	<option value="NV">Nevada</option>
                        	<option value="NH">New Hampshire</option>
                        	<option value="NJ">New Jersey</option>
                        	<option value="NM">New Mexico</option>
                        	<option value="NY">New York</option>
                        	<option value="NC">North Carolina</option>
                        	<option value="ND">North Dakota</option>
                        	<option value="OH">Ohio</option>
                        	<option value="OK">Oklahoma</option>
                        	<option value="OR">Oregon</option>
                        	<option value="PA">Pennsylvania</option>
                        	<option value="RI">Rhode Island</option>
                        	<option value="SC">South Carolina</option>
                        	<option value="SD">South Dakota</option>
                        	<option value="TN">Tennessee</option>
                        	<option value="TX">Texas</option>
                        	<option value="UT">Utah</option>
                        	<option value="VT">Vermont</option>
                        	<option value="VA">Virginia</option>
                        	<option value="WA">Washington</option>
                        	<option value="WV">West Virginia</option>
                        	<option value="WI">Wisconsin</option>
                        	<option value="WY">Wyoming</option>
                        </select>	
    				</div>
    				</div>
    				<div class="col-xs-4">
    				<label for="address" class="col-lg-3 control-label">Zip</label>
    				<div class="col-lg-9">
    					<input type="text" class="form-control" id="zip"
    						name="zip"
    						value="<?php if (isset($input['zip'])) echo $input['zip'];?>" />
    				</div>
    				</div>
    					
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
			<?php if($isGC == 1){?>
			<center><h2>Optional/Additional Information</h2></center>
			<div class="form-group">
				<label for="student_name" class="col-lg-3 control-label">Student Name</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="student_name"
						name="student_name"
						value="<?php if (isset($input['student_name'])) echo $input['student_name'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="student_address" class="col-lg-3 control-label">Student Street Address</label>
				<div class="col-lg-6">
				<input type="text" class="form-control" id="student_street_address"
					name="student_street_address"
					value="<?php if (isset($input['student_street_address'])) echo $input['student_street_address'];?>" />
			</div>
			</div>
			<div class="form-group">
			    <label for="student_address" class="col-lg-3 control-label">Student City</label> 
			    
				
				<div class="col-lg-6">
				    <div class="col-xs-4" style="padding-left: 0px">
					<input type="text" class="form-control" id="student_city"
						name="student_city"
						value="<?php if (isset($input['student_city'])) echo $input['student_city'];?>" />
					</div>
					<div class="col-xs-4">
    				<label for="student_address" class="col-lg-3 control-label">Student State</label>
    				<div class="col-lg-9">    				
    					<select class="form-control" id="student_state"
    						name="student_state">
                        	<option value="AL">Alabama</option>
                        	<option value="AK">Alaska</option>
                        	<option value="AZ">Arizona</option>
                        	<option value="AR">Arkansas</option>
                        	<option value="CA">California</option>
                        	<option value="CO">Colorado</option>
                        	<option value="CT">Connecticut</option>
                        	<option value="DE">Delaware</option>
                        	<option value="DC">District Of Columbia</option>
                        	<option value="FL">Florida</option>
                        	<option value="GA">Georgia</option>
                        	<option value="HI">Hawaii</option>
                        	<option value="ID">Idaho</option>
                        	<option value="IL">Illinois</option>
                        	<option value="IN">Indiana</option>
                        	<option value="IA">Iowa</option>
                        	<option value="KS">Kansas</option>
                        	<option value="KY">Kentucky</option>
                        	<option value="LA">Louisiana</option>
                        	<option value="ME">Maine</option>
                        	<option value="MD">Maryland</option>
                        	<option value="MA">Massachusetts</option>
                        	<option value="MI">Michigan</option>
                        	<option value="MN">Minnesota</option>
                        	<option value="MS">Mississippi</option>
                        	<option value="MO">Missouri</option>
                        	<option value="MT">Montana</option>
                        	<option value="NE">Nebraska</option>
                        	<option value="NV">Nevada</option>
                        	<option value="NH">New Hampshire</option>
                        	<option value="NJ">New Jersey</option>
                        	<option value="NM">New Mexico</option>
                        	<option value="NY">New York</option>
                        	<option value="NC">North Carolina</option>
                        	<option value="ND">North Dakota</option>
                        	<option value="OH">Ohio</option>
                        	<option value="OK">Oklahoma</option>
                        	<option value="OR">Oregon</option>
                        	<option value="PA">Pennsylvania</option>
                        	<option value="RI">Rhode Island</option>
                        	<option value="SC">South Carolina</option>
                        	<option value="SD">South Dakota</option>
                        	<option value="TN">Tennessee</option>
                        	<option value="TX">Texas</option>
                        	<option value="UT">Utah</option>
                        	<option value="VT">Vermont</option>
                        	<option value="VA">Virginia</option>
                        	<option value="WA">Washington</option>
                        	<option value="WV">West Virginia</option>
                        	<option value="WI">Wisconsin</option>
                        	<option value="WY">Wyoming</option>
                        </select>	
    				</div>
    				</div>
    				<div class="col-xs-4">
    				<label for="student_address" class="col-lg-3 control-label">Student Zip</label>
    				<div class="col-lg-9">
    					<input type="text" class="form-control" id="student_zip"
    						name="student_zip"
    						value="<?php if (isset($input['student_zip'])) echo $input['student_zip'];?>" />
    				</div>
    				</div>
    					
				</div>
			</div>
			<div class="form-group">
				<label for="student_phone" class="col-lg-3 control-label">Student Phone</label>
				<div class="col-lg-2">
					<input type="text" class="form-control" id="student_phone"
						name="student_phone"
						value="<?php if (isset($input['student_phone'])) echo $input['student_phone'];?>" />
				</div>
			</div>
            <?php }?>

			<div class="form-group">
				<label class="col-lg-6 control-label submitForm">
					<button class="btn btn-info" name="save"><?php echo $isGC ? 'Buy' : 'Register'?></button> <span
					class="or">OR</span> <button class="btn btn-danger" name="cancel"><a style="color:#fff;" href="/schedule.html" class="cancel">Cancel</a></button>
				</label>
			</div>

		</form>
	</div>
</section>
</div>

<?php     
}
?>