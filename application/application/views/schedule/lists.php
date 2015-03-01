<script src="/js/app/app.js"></script>
<div class="container-fliud"> 
    <section class="content-wraper">
        <h2>Course Schedules</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-12">
                <form id='filter-course'>
                <table cellspacing="10">
    	    		<tr>
    	    		<td> &nbsp;&nbsp;&nbsp; Filter: </td>
    			    	<td> 
    			    	&nbsp;&nbsp;&nbsp;
                    <select class="form-control" name="course_code">
    					   <option value="">Please Choose</option>
    					   <?php foreach(getCourseCodes() as $courseInfo){?>
    					       <option value="<?php echo $courseInfo['code']?>"><?php echo $courseInfo['code'].' - '.$courseInfo['name']?></option>
    					   <?php }?>
    				 </select>
    				 &nbsp;&nbsp;&nbsp;
    				 </td>
    				 <td>
    				 &nbsp;&nbsp;&nbsp;
    			     <select class="form-control" name="location_code">
    					   <option value="">Please Choose</option>
    					   <?php foreach(getAvailableLocations() as $locInfo){?>
    					       <option <?php echo isset($courseSchedule['location_code']) &&  $courseSchedule['location_code'] ==  $locInfo['code'] ? 'selected' : '' ?> value="<?php echo $locInfo['code']?>"><?php echo $locInfo['code'].' - '.$locInfo['location']?></option>
    					   <?php }?>
    				 </select>
    				 &nbsp;&nbsp;&nbsp;
    				 </td>
    				 <td>
    				 &nbsp;&nbsp;&nbsp;
    				  <input placeholder="Start Date" type="text" name="start_date" class="datepicker form-control" data-date-format="yyyy-mm-dd" 
    				      data-date="<?php if (isset($courseSchedule['start_date'])) echo $courseSchedule['start_date'];?>" 
    				      value="<?php if (isset($courseSchedule['start_date'])) echo $courseSchedule['start_date'];?>"
                         id="start_date" >
                         &nbsp;&nbsp;&nbsp;        
                     </td>    
                     <td>
                     &nbsp;&nbsp;&nbsp;     
                      <a href="javascript: MostRidingLib.filterCourse()" class="btn btn-info" >Go</a>
                      </td>
                      </tr>
                      </table>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a href="<?php echo SUB_CONTEXT?>/schedules/add" class="btn btn-info pull-right">Add New Schedule</a>
            </div>
        </div>
        <br />
        <div class="row" >
         <div class="col-xs-12" id="course-sched-list">
             <?php $this->load->view('schedule/_lists', array('course_schedules'=>$course_schedules));?>
        </div>
        </div>
    </section>
</div>