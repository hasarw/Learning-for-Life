<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";
require_once "header.php";

$functions = new query_functions();

?>

    <div class="container">

    <div class="row">
    <div id="container">
    <div class="col-md-12">
    <div class="table-responsive">
    <table class="table table-bordered table-center table-timeline">

    <tbody class="table-graph">
    <tr class="">
    <th rowspan="2">#</th>
    <th rowspan="2">Activity</th>
    <!-- <th rowspan="2">Desc</th> -->

    <!-- <th rowspan="2">Description</th> -->
    <th colspan="3">2016</th>
    <th colspan="12">2017</th>
    <!-- <th colspan="9">2018</th> -->
    </tr>

    <tr>
    <td class="td-width">Oct</td>
    <td class="td-width">Nov</td>
    <td class="td-width">Dec</td>

    <td class="td-width">Jan</td>
    <td class="td-width">Feb</td>
    <td class="td-width">Mar</td>
    <td class="td-width">Apr</td>
    <td class="td-width">May</td>
    <td class="td-width">Jun</td>
    <td class="td-width">Jul</td>
    <td class="td-width">Aug</td>
    <td class="td-width">Sep</td>
    <td class="td-width">Oct</td>
    <td class="td-width">Nov</td>
    <td class="td-width">Dec</td>

    </tr>


    <?php
    require_once "db.php";
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $sql = "SELECT tbl_activity.`activity_table_id`, tbl_activity.`activity_table_id`, tbl_activity.`activity_base_date`, tbl_activity.`activity_name`, tbl_activity.`activity_id`
    FROM `tbl_activity`";

    $result = $conn->query($sql);

    $count = 1;

    //
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $counter = 0;

          $activity_table_id = $row['activity_table_id'];
          $table_id = $row['activity_table_id'];
          $title = $row['activity_id'];
          $name = $row['activity_name'];
          $base_date = $row['activity_base_date'];

          echo "<tr>
          <td>$count</td>
          <td><a class='red-tooltip' href='activity_edit.php?activity_id=$activity_table_id' data-toggle='tooltip' title='$name'>$title</a></td>";



          foreach ($functions->get_sub_activity($table_id) as $key => $value) {

            $start_date = $value['sub_activity_start_date'];
            $end_date = $value['sub_activity_end_date'];
            $cost = $value['sub_activity_cost'];

            $srart_month = $functions->get_baseline_activity($base_date, $start_date);


            $date1 = $start_date;
            $date2 = $end_date;

            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);

            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);

            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);

            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
            if($srart_month > 1){
            echo "<td class='td-empty' colspan='$srart_month'></td>";
            }
            echo "<td class='td-filled' colspan='$diff'><a class='red-tooltip' href='#' data-toggle='tooltip' title='The Cost is: $cost'>100%</a></td>";

            $base_date = $date2;
          }

          echo "</tr>";

          $count++;
        }
      }

      $conn->close();
      ?>



    </tbody>

    </table>
    </div>
    </div>
    </div>
    </div>




    </div>


<?php require_once "footer.php"; ?>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

</script>
