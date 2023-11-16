<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";
require_once "header.php";

//Load Query Functions 
$functions = new query_functions();

//Load sub-Activities 
$functions->test_select_activity();

//Load Activities
$functions->test_select_to_json();

//Load Indicator Tracking Table
$functions->select_all_itt();

?>

<div style="width: 100%">
<table style="width: 100%;">

    <thead class="fixedHeader">

    <tr>
        
      <th class="table-head-center" colspan="4">2016</th>
      <th class="table-head-center" colspan="12">2017</th>
      <th class="table-head-center" colspan="9">2018</th>

    </tr>

    </thead>

	<thead class="fixedHeader">

    <tr>

    <th>Activity Code</th>
<!-- 2016 -->
    <th class='activity_size_2016'>Oct</th>
    <th class='activity_size_2016'>Nov</th>
    <th class='activity_size_2016'>Dec</th>
<!-- 2017 -->
    <th class='activity_size_2017'>Jan</th>
    <th class='activity_size_2017'>Feb</th>
    <th class='activity_size_2017'>Mar</th>
    <th class='activity_size_2017'>Apr</th>
    <th class='activity_size_2017'>May</th>
    <th class='activity_size_2017'>Jun</th>
    <th class='activity_size_2017'>Jul</th>
    <th class='activity_size_2017'>Aug</th>
    <th class='activity_size_2017'>Sep</th>
    <th class='activity_size_2017'>Oct</th>
    <th class='activity_size_2017'>Nov</th>
    <th class='activity_size_2017'>Dec</th>
<!-- 2018 -->
    <th class='activity_size_2018'>Jan</th>
    <th class='activity_size_2018'>Feb</th>
    <th class='activity_size_2018'>Mar</th>
    <th class='activity_size_2018'>Apr</th>
    <th class='activity_size_2018'>May</th>
    <th class='activity_size_2018'>Jun</th>
    <th class='activity_size_2018'>Jul</th>
    <th class='activity_size_2018'>Aug</th>
    <th class='activity_size_2018'>Sep</th>
 
    </tr>

    </thead>




<!--     <tbody class="fixedContent">

    </tbody>
 -->





    <?php

    echo "<tbody class='scrollContent'>";

    foreach ($functions->test_select() as $key => $value) {
   
      //Send the activity ID to the function activitiesModal
      //The function will search among all activities which allready loaded in a json file
      //Send back all needed to the modal via $scope variables
      //This process is the same for all functions here, below.

      echo "<tr><td data-toggle='tooltip' title='".$value['description']."'><a href='#' data-toggle='modal' data-target='#ModalActivity' ng-click='activitiesModal(".$value['id'].")' style='width:2%'>".$value['title']."</a></td>


      <td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['oct']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['oct'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['oct'])."</td>";

      $oct_budget += $functions->get_activity_budget($value['id']."".$value['oct']);
      $oct_expense += $functions->get_activity_expense($value['id']."".$value['oct']);



      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['nov']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['nov'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['nov'])."</td>";

      $nov_budget += $functions->get_activity_budget($value['id']."".$value['nov']);
      $nov_expense += $functions->get_activity_expense($value['id']."".$value['nov']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['decm']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['decm'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['decm'])."</td>";

      $decm_budget += $functions->get_activity_budget($value['id']."".$value['decm']);
      $decm_expense += $functions->get_activity_expense($value['id']."".$value['decm']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['jan']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['jan'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['jan'])."</td>";

      $jan_budget += $functions->get_activity_budget($value['id']."".$value['jan']);
      $jan_expense += $functions->get_activity_expense($value['id']."".$value['jan']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['feb']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['feb'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['feb'])."</td>";


      $feb_budget += $functions->get_activity_budget($value['id']."".$value['feb']);
      $feb_expense += $functions->get_activity_expense($value['id']."".$value['feb']);



      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['mar']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['mar'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['mar'])."</td>";

      $mar_budget += $functions->get_activity_budget($value['id']."".$value['mar']);
      $mar_expense += $functions->get_activity_expense($value['id']."".$value['mar']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['apr']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['apr'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['apr'])."</td>";

      $apr_budget += $functions->get_activity_budget($value['id']."".$value['apr']);
      $apr_expense += $functions->get_activity_expense($value['id']."".$value['apr']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['may']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['may'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['may'])."</td>";

      $may_budget += $functions->get_activity_budget($value['id']."".$value['may']);
      $may_expense += $functions->get_activity_expense($value['id']."".$value['may']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['jun']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['jun'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['jun'])."</td>";

      $jun_budget += $functions->get_activity_budget($value['id']."".$value['jun']);
      $jun_expense += $functions->get_activity_expense($value['id']."".$value['jun']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['jul']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['jul'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['jul'])."</td>";

      $jul_budget += $functions->get_activity_budget($value['id']."".$value['jul']);
      $jul_expense += $functions->get_activity_expense($value['id']."".$value['jul']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['aug']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['aug'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['aug'])."</td>";

      $aug_budget += $functions->get_activity_budget($value['id']."".$value['aug']);
      $aug_expense += $functions->get_activity_expense($value['id']."".$value['aug']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['sep']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['sep'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['sep'])."</td>";

      $sep_budget += $functions->get_activity_budget($value['id']."".$value['sep']);
      $sep_expense += $functions->get_activity_expense($value['id']."".$value['sep']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['oct_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['oct_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['oct_2'])."</td>";

      $oct_2_budget += $functions->get_activity_budget($value['id']."".$value['oct_2']);
      $oct_2_expense += $functions->get_activity_expense($value['id']."".$value['oct_2']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['nov_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['nov_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['nov_2'])."</td>";

      $nov_2_budget += $functions->get_activity_budget($value['id']."".$value['nov_2']);
      $nov_2_expense += $functions->get_activity_expense($value['id']."".$value['nov_2']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['dec_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['dec_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['dec_2'])."</td>";

      $dec_2_budget += $functions->get_activity_budget($value['id']."".$value['dec_2']);
      $dec_2_expense += $functions->get_activity_expense($value['id']."".$value['dec_2']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['jan_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['jan_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['jan_2'])."</td>";

      $jan_2_budget += $functions->get_activity_budget($value['id']."".$value['jan_2']);
      $jan_2_expense += $functions->get_activity_expense($value['id']."".$value['jan_2']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['feb_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['feb_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['feb_2'])."</td>";

      $feb_2_budget += $functions->get_activity_budget($value['id']."".$value['feb_2']);
      $feb_2_expense += $functions->get_activity_expense($value['id']."".$value['feb_2']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['mar_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['mar_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['mar_2'])."</td>";

      $mar_2_budget += $functions->get_activity_budget($value['id']."".$value['mar_2']);
      $mar_2_expense += $functions->get_activity_expense($value['id']."".$value['mar_2']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['apr_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['apr_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['apr_2'])."</td>";

      $apr_2_budget += $functions->get_activity_budget($value['id']."".$value['apr_2']);
      $apr_2_expense += $functions->get_activity_expense($value['id']."".$value['apr_2']);


      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['may_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['may_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['may_2'])."</td>";

      $may_2_budget += $functions->get_activity_budget($value['id']."".$value['may_2']);
      $may_2_expense += $functions->get_activity_expense($value['id']."".$value['may_2']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['jun_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['jun_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['jun_2'])."</td>";

      $jun_2_budget += $functions->get_activity_budget($value['id']."".$value['jun_2']);
      $jun_2_expense += $functions->get_activity_expense($value['id']."".$value['jun_2']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['jul_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['jul_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['jul_2'])."</td>";

      $jul_2_budget += $functions->get_activity_budget($value['id']."".$value['jul_2']);
      $jul_2_expense += $functions->get_activity_expense($value['id']."".$value['jul_2']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['aug_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['aug_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['aug_2'])."</td>";

      $aug_2_budget += $functions->get_activity_budget($value['id']."".$value['aug_2']);
      $aug_2_expense += $functions->get_activity_expense($value['id']."".$value['aug_2']);

      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$functions->get_activity_color($value['id']."".$value['sep_2']).", #ffffff);' ng-click='showActivities(".$value['id']."".$value['sep_2'].")' data-toggle='modal' data-target='#myModal'>".$functions->get_activity_percent($value['id']."".$value['sep_2'])."</td>";

      $sep_2_budget += $functions->get_activity_budget($value['id']."".$value['sep_2']);
      $sep_2_expense += $functions->get_activity_expense($value['id']."".$value['sep_2']);

      echo "</tr>
      ";


    }

echo "</tbody>";

    ?>


</table>
</div>