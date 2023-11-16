<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";
require_once "header.php";

$functions = new query_functions();

// this function is loading all the data from Task table on the database into a json file.
$functions -> getAllTask();

?>

<div ng-app="taskModule">
<div ng-controller="ctrlTask">

    <div class="container" ng-cloak>
      <div class="row">

      <div class="col-md-7">
      	<!-- Get the task list form the Database and show them here -->
      	<div class="task-preview">

      	<div style="float: left;">
        <a href='#' class='btn btn-sm btn-info' data-toggle='modal' data-target='#show_data_form'>Add a Term</a>
      	</div>
		
		<div style="float: right">
		<label>Order by: </label>
      	<select id="select_order">
      		<option value="1">All Tasks</option>
      		<option value="2">Completed</option>
      		<option value="3">In Progress</option>
          <option value="4">My Task</option>
      	</select>

		</div>

      		<table class="table">

      		<tr ng-repeat="t in tasks">

      			<td><p class="task_title" ng-model="task_title" ng-click="task_details(t.task_desc)"><b>{{t.task_title}}</b> <span class="text-danger">{{t.task_priority | taskPriority}} </span><br/><span class="text-success">Due: {{t.task_due_date}}</span></p>

      	
      			<br/>
      			</td>

      			<td>
      			
      			<span class="text-success" style="font-size: 10pt">Issue date: {{t.task_issue_date}}</span>

      			</td>
      		</tr>
      		</table>
      	</div>

      </div>

      <div class="col-md-4">
      	<!-- In the event of clicking on the task, this section will providing task description, issue and expire dates, owner and implentor of the task -->
      	<div class="task-description">
      	<h4>Details</h4>
      	<p class="show-description" ng-show="task_details_text">Click on tasks to view details.</p>
      	
      	{{task_details_text}}
      	<br/>
      	<p ng-show="task_details_text"> Edit | Comment | Complete | Archive </p>
      	</div>

      </div>

    </div>
    </div>

    </div>
    </div>




<!-- Modal - Update User details -->
<div class="modal fade" id="show_data_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title modal-title-title">New Task</h4>
          </div>
            <div class="modal-body">

              <form name="myForm" action="task.php" method="post">

                <div class="form-group">
                  <label for="title">Task Name:</label>
                  <input type="text" class="form-control" id="title" name="task_name" ng-model="abbreviation" required />
                </div>

                <div class="form-group">
                  <label for="title">Description:</label>
                  <textarea class="form-control" id="desc" rows="4" cols="50" name="task_desc"></textarea>
                  <!-- <input type="text" class="form-control" id="desc" name="defination" ng-model="defination" required /> -->
                </div>

                <div class="form-group">
                  <label for="title">Priority:</label>
                  <select class="form-control" name="task_priority" style="height: 40px">
                    <option value="1">High</option>
                    <option value="2">Medium</option>
                    <option value="3">Low</option>
                  </select>
                </div>

                <div class="input-group date" data-provide="datepicker">
                    <input type="text" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>

                <div class="form-group">
                  <label for="title">Assign to:</label>
                  <input type="text" class="form-control" id="title" name="task_name" value="" required />
                </div>

                <div class="form-group">
                  <button class="btn btn-info" name="submit">Submit</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->








<?php require_once "footer.php"; ?>
<script type="text/javascript" src="assets/js/task.js"></script>

<script type="text/javascript">
  
  $('.datepicker').datepicker();
</script>

<?php

if(isset($_POST['submit'])){

  $task_name = $_POST['task_name'];
  $task_desc = $_POST['task_desc'];
  $task_priority = $_POST['task_priority'];

  $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

  $sql = "INSERT INTO `tbl_task`(`task_id`, `task_title`, `task_desc`, `task_issue_date`, `task_due_date`, `task_owner`, `task_implementer`, `task_priority`, `Task_status`) VALUES (null, '$task_name', '$task_desc', '$task_issue_date', '$task_due_date', '$task_owner', '$task_implementer', '$task_priority', '$Task_status')";

  if ($conn->query($sql) === TRUE) {
      echo "<script>window.location = 'task.php';</script>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}

?>