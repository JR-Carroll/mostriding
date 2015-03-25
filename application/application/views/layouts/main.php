<!DOCTYPE html>
<head>
<title>Admin</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->

<link href="/css/app/application.css" rel="stylesheet">
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/app/datepicker.css" rel="stylesheet">

<link rel="stylesheet" href="/css/app/jquery.dataTables.css"/>

<script src="/js/app/jquery-1.11.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script> 
<script src="/js/app/bootstrap-datepicker.js"></script> 
<script src="/js/app/jquery.dataTables.js"></script>
<script src="/js/app/jquery.blockUI.js"></script>
<script type="text/javascript" src="/js/app/jquery.sceditor.bbcode.min.js"></script>

</head>
<body>
<div class="container-fliud"> 
<div class="col-xs-12 main-body-content">
<input type="hidden" id="subContext" value="<?php echo SUB_CONTEXT?>"/>
<?php if(isUserAuthenticated()){?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">     
      <a class="navbar-brand" href="<?php echo SUB_CONTEXT.'/schedules'?>">Course Schedules</a>
    </div>
    <div class="navbar-header">     
      <a class="navbar-brand" href="<?php echo SUB_CONTEXT.'/schedules/displayCurrentSchedules'?>">Display Current Schedules</a>
    </div>
    
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo SUB_CONTEXT.'/users/logout'?>">Logout</a></li>
       
      </ul>

  </div><!-- /.container-fluid -->
</nav>
<?php }?>
<?php echo $content?>
</div>
</div>
</body>
</html>