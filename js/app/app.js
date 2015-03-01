$(document).ready(function() {
   $('.data-table').dataTable();
   $('.btn-delete').on('click', function(){
	   if(confirm("Are you sure want to delete this course?")){
		   $.post($('#subContext').val()+ '/schedules/delete', 'course_schedule_id='+$(this).data('course_schedule-id'), function(data){
			   $('.main-body-content').html(data);
			   $('.data-table').dataTable();
		   });
		   
	   }
   });
   $('.datepicker').each(function(){
	   $(this).datepicker().on('changeDate', function(ev){                 
	   $(this).datepicker('hide');
	   });
   });
   
   $("textarea").sceditor({
		plugins: 'xhtml',
		style: '/css/app/jquery.sceditor.default.min.css'
	});

});
var MostRidingLib = {
	filterCourse : function(){
		MostRidingLib.startSpinner();
		$.post($('#subContext').val()+'/schedules/filter', $('#filter-course').serialize(), function(dataHtml){
			$('#course-sched-list').html(dataHtml);
			$('.data-table').dataTable();
			MostRidingLib.stopSpinner();
		});
	},
	startSpinner : function(){
		$.blockUI({ message: '<h1><img src="/imgs/busy.gif" /> Processing request...</h1>' }); 
	},
	stopSpinner : function(){
		  $.unblockUI(); 
	},
	showAvailableScheds : function(){
		$.get('/application/index.php/schedules/displayCurrentSchedules', '', function(dataHtml){
			console.log(dataHtml);
		});
	}
}