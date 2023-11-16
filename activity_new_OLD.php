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

    <div class="container">

    <div class="row" ng-app="MyApp">
    <div class="someClass" ng-controller="myCtrl" ng-cloak >
    <div class="container">

<!-- The table is not dynamic. I draw it from here. -->
  
    <div class="col-md-12">
    <div class="row">
    <div class="col-md-12">


<div class="canvas-text">
  <h2>Budget and Expenses Chart</h2>
  <hr>
</div>

<canvas id="line" class="chart chart-line" chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-dataset-override="datasetOverride" chart-click="onClick" chart-colors="colors">
</canvas><hr>

      </div>
      </div>
      </div>
      </div>
 
    <!-- <div class="table-responsive table-overflow" style="max-height: 500px"> -->
    <!-- <table class="table table-bordered table-timeline-tracker" style="width: 100%"> -->

  <div class="divActivity">

       <button class='btn btn-sm btn-info' id="menu-toggle-1" data-toggle='collapse' data-target='#budget_table'>Show Budget and Expenses Table <i class='glyphicon glyphicon glyphicon-menu-down'></i></button>

  </div>

    <div class="divActivity" style="display: none;">
     <button class="btn btn-info btn-space" id="btn-action" data-toggle="modal" data-target="#modal_fresh_activity">Options</button>
   </div>


    <div class="table-responsive collapse" id="budget_table" style="height: 600px; margin-top: 20px">
    
      <table class="table table-fixed table-striped table-condensed tableScroll table-hover" name="table" style="width: 2000px; overflow-y:scroll;">

    <thead class="fixedHeader"> 

    <tr class="activity_colorfull_head_tr">
        
      <th class="table-head-center" colspan="4">2016</th>
      <th class="table-head-center" colspan="12">2017</th>
      <th class="table-head-center" colspan="9">2018</th>

    </tr>


    <tr>

    <th class='activity_td_text'>Activity Code</th>
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
<tbody style="overflow-y: scroll;">

    <?php 

    foreach ($functions->test_select() as $key => $value) {
   
      //Send the activity ID to the function activitiesModal
      //The function will search among all activities which allready loaded in a json file
      //Send back all needed to the modal via $scope variables
      //This process is the same for all functions here, below.

      echo "<tr><td class='activity_td_text' data-toggle='tooltip' title='".$value['description']."'><a href='#' data-toggle='modal' data-target='#ModalActivity' ng-click='activitiesModal(".$value['id'].")' style='width:2%'>".$value['title']."</a></td>";


      ////////////////////////////////////////////////

      foreach ($functions->get_activity_color_bdg_exp($value['id']."".$value['oct']) as $key => $get_value) {

        $get_act_color = $get_value['test_color'];
        $get_act_budget = $get_value['act_budget'];
        $get_act_expense = $get_value['act_spend'];
        $act_budget_percent = $get_value['act_budget_percent'];
      
      }
 
      echo "<td class='activity_size' style='background: -webkit-linear-gradient(".$get_act_color.", #ffffff);' ng-click='showActivities(".$value['id']."".$value['oct'].")' data-toggle='modal' data-target='#myModal'>".$act_budget_percent."</td>";

      $oct_budget += $functions->get_activity_budget($value['id']."".$value['oct']);
      $oct_expense += $functions->get_activity_expense($value['id']."".$value['oct']);

      ////////////////


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

    echo "<thead class='fixedHeader'>";


     echo "<tr class='tr-colorfull-first'><td class='activity_td_text'><b>Budget</b></td>";
     echo "<td><span class='label label-primary'>".number_format($oct_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($nov_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($decm_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($jan_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($feb_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($mar_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($apr_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($may_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($jun_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($jul_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($aug_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($sep_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($oct_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($nov_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($dec_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($jan_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($feb_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($mar_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($apr_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($may_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($jun_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($jul_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($aug_2_budget)." $</span></td>";
     echo "<td><span class='label label-primary'>".number_format($sep_2_budget)." $</span></td>";

     $total_budget = $oct_budget + $nov_budget + $decm_budget + $jan_budget + $feb_budget + $mar_budget + $apr_budget + $may_budget + $jun_budget + $jul_budget + $aug_budget + $sep_budget + $oct_2_budget + $nov_2_budget + $dec_2_budget + $jan_2_budget + $feb_2_budget + $mar_2_budget + $apr_2_budget + $may_2_budget + $jun_2_budget + $jul_2_budget + $aug_2_budget + $sep_2_budget;
     
     echo "<td><span class='label label-default'>".number_format($total_budget)." $</span></td></tr>";


     echo "<tr class='tr-colorfull-second'><td class='activity_td_text'><b>Expense</b><br/><b>% Exp</b></td>";
     echo "<td><span class='label label-warning'>".number_format($oct_expense)." $</span>
     <span class='label label-danger'>".$functions->calculate_percentage_tracker($oct_budget, $oct_expense)."</span>
     </td>";
     echo "<td><span class='label label-warning'>".number_format($nov_expense)." $</span>
     <span class='label label-danger'>".$functions->calculate_percentage_tracker($nov_budget, $nov_expense)."</span>
     </td>";

     echo "<td><span class='label label-warning'>".number_format($decm_expense)." $</span>
     <span class='label label-danger'>".$functions->calculate_percentage_tracker($decm_budget, $decm_expense)."</span>     
     </td>";

     echo "<td><span class='label label-warning'>".number_format($jan_expense)." $</span>
<span class='label label-danger'>".$functions->calculate_percentage_tracker($jan_budget, $jan_expense)."</span>  
     </td>";

     echo "<td><span class='label label-warning'>".number_format($feb_expense)." $</span>
<span class='label label-danger'>".$functions->calculate_percentage_tracker($jan_budget, $jan_expense)."</span> 
     </td>";


     echo "<td><span class='label label-warning'>".number_format($mar_expense)." $</span>
     <span class='label label-danger'>".$functions->calculate_percentage_tracker($mar_budget, $mar_expense)."</span> 

     </td>";

     echo "<td><span class='label label-warning'>".number_format($apr_expense)." $</span>
          <span class='label label-danger'>".$functions->calculate_percentage_tracker($apr_budget, $apr_expense)."</span> 
     </td>";

      echo "<td><span class='label label-warning'>".number_format($may_expense)." $</span>
          <span class='label label-danger'>".$functions->calculate_percentage_tracker($may_budget, $may_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($jun_expense)." $</span>
          <span class='label label-danger'>".$functions->calculate_percentage_tracker($jun_budget, $jun_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($jul_expense)." $</span>
         <span class='label label-danger'>".$functions->calculate_percentage_tracker($jul_budget, $jul_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($aug_expense)." $</span>
         <span class='label label-danger'>".$functions->calculate_percentage_tracker($aug_budget, $aug_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($sep_expense)." $</span>
         <span class='label label-danger'>".$functions->calculate_percentage_tracker($sep_budget, $sep_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($oct_2_expense)." $</span>
         <span class='label label-danger'>".$functions->calculate_percentage_tracker($oct_2_budget, $oct_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($nov_2_expense)." $</span>
         <span class='label label-danger'>".$functions->calculate_percentage_tracker($nov_2_budget, $nov_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($dec_2_expense)." $</span>
              <span class='label label-danger'>".$functions->calculate_percentage_tracker($dec_2_budget, $dec_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($jan_2_expense)." $</span>
              <span class='label label-danger'>".$functions->calculate_percentage_tracker($jan_2_budget, $jan_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($feb_2_expense)." $</span>
             <span class='label label-danger'>".$functions->calculate_percentage_tracker($feb_2_budget, $feb_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($mar_2_expense)." $</span>
               <span class='label label-danger'>".$functions->calculate_percentage_tracker($mar_2_budget, $mar_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($apr_2_expense)." $</span>
               <span class='label label-danger'>".$functions->calculate_percentage_tracker($apr_2_budget, $apr_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($may_2_expense)." $</span>
                     <span class='label label-danger'>".$functions->calculate_percentage_tracker($may_2_budget, $may_2_expense)."</span> 
      </td>";
      echo "<td><span class='label label-warning'>".number_format($jun_2_expense)." $</span>
                    <span class='label label-danger'>".$functions->calculate_percentage_tracker($jun_2_budget, $jun_2_expense)."</span>
      </td>";
      echo "<td><span class='label label-warning'>".number_format($jan_2_expense)." $</span>
                    <span class='label label-danger'>".$functions->calculate_percentage_tracker($jan_2_budget, $jan_2_expense)."</span>
      </td>";
      echo "<td><span class='label label-warning'>".number_format($aug_2_expense)." $</span>
                          <span class='label label-danger'>".$functions->calculate_percentage_tracker($aug_2_budget, $aug_2_expense)."</span>
      </td>";
      echo "<td><span class='label label-warning'>".number_format($sep_2_expense)." $</span>
                  <span class='label label-danger'>".$functions->calculate_percentage_tracker($sep_2_budget, $sep_2_expense)."</span>
      </td>";

      $total_expense = $oct_expense + $nov_expense + $decm_expense + $jan_expense +$feb_expense + $mar_expense + $apr_expense + $may_expense + $jun_expense + $jul_expense + $aug_expense + $sep_expense + $oct_2_expense + $nov_2_expense + $dec_2_expense + $jan_2_expense + $feb_2_expense+ $mar_2_expense + $apr_2_expense + $may_2_expense + $jun_2_expense + $jan_2_expense + $aug_2_expense + $sep_2_expense;

      echo "<td><span class='label label-default'>".number_format($total_expense)." $</span><br>";

      echo "<span class='label label-danger'>".$functions->calculate_percentage_tracker($total_budget, $total_expense)."</span></td>";

      echo "</tr><tr>
      <td class='activity_td_text'><b>% Var</b></td>
      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($oct_budget, $oct_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($nov_budget, $nov_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($decm_budget, $decm_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($jan_budget, $jan_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($feb_budget, $feb_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($mar_budget, $mar_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($apr_budget, $apr_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($may_budget, $may_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($jun_budget, $jun_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($jul_budget, $jul_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($aug_budget, $aug_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($sep_budget, $sep_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($oct_2_budget, $oct_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($nov_2_budget, $nov_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($dec_2_budget, $dec_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($jan_2_budget, $jan_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($feb_2_budget, $feb_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($mar_2_budget, $mar_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($apr_2_budget, $apr_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($may_2_budget, $may_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($jun_2_budget, $jun_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($jan_2_budget, $jan_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($aug_2_budget, $aug_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($sep_2_budget, $sep_2_expense)-100)." %</span></td>

      <td><span class='label label-danger'>".abs($functions->calculate_percentage_tracker($total_budget, $total_expense)-100)." %</span></td>

      </tr>
      </thead>";

      $var_oct_expense = ($oct_expense-$oct_budget);
      $var_nov_expense = ($nov_expense-$nov_budget);
      $var_decm_expense = ($decm_expense-$decm_budget);
      $var_jan_expense = ($jan_expense-$jan_budget);
      $var_feb_expense = ($feb_expense-$feb_budget);
      $var_mar_expense = ($mar_expense-$mar_budget);
      $var_apr_expense = ($apr_expense-$apr_budget);
      $var_may_expense = ($may_expense-$may_budget);
      $var_jun_expense = ($jun_expense-$jun_budget);
      $var_jul_expense = ($jul_expense-$jul_budget);
      $var_aug_expense = ($aug_expense-$aug_budget);
      $var_sep_expense = ($sep_expense-$oct_2_budget);
      $var_oct_2_expense = ($oct_2_expense-$sep_2_budget);
      $var_nov_2_expense = ($nov_2_expense-$nov_2_budget);
      $var_dec_2_expense = ($dec_2_expense-$dec_2_budget);
      $var_jan_2_expense = ($jan_2_expense-$jan_2_budget);
      $var_feb_2_expense = ($feb_2_expense-$jul_2_budget);
      $var_mar_2_expense = ($mar_2_expense-$mar_2_budget);
      $var_apr_2_expense = ($apr_2_expense-$apr_2_budget);
      $var_may_2_expense = ($may_2_expense-$may_2_budget);
      $var_jun_2_expense = ($jun_2_expense-$jun_2_budget);
      $var_jan_2_expense = ($jan_2_expense-$jan_2_budget);
      $var_aug_2_expense = ($aug_2_expense-$aug_2_budget);
      $var_sep_2_expense = ($sep_2_expense-$sep_2_budget);


    ?>
    </tbody>
    </table>
    </div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-activity">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal_header"><b>{{act_name}}</b></h4>
      </div>
      <div class="modal-body">

      <form class="form-horizontal" method="POST" action="activity_new.php">


      <div class="form-group" hidden>
      <label class="control-label col-md-3" for="act_id">Activity ID:</label>
      <div class="col-md-8">
      <input type="text" ng-model="act_id" class="form-control" id="act_id" name="act_id" value="" />
      </div>
      </div>


      <div class="form-group" hidden>
      <label class="control-label col-md-3" for="act_idnum">Number:</label>
      <div class="col-md-8">
      <input type="text" ng-model="act_id_num" class="form-control" id="act_id_num" name="act_id_num" value="" />
      </div>
      </div>


      <div class="form-group">
      <label class="control-label col-md-3" for="act_name">Name:</label>
      <div class="col-md-8">
      <input type="text" ng-model="act_name" class="form-control" id="act_name" name="act_name"/>
      </div>
      </div>


      <div class="form-group">
      <label class="control-label col-md-3" for="act_desc">Desciption:</label>
      <div class="col-md-8">
      <textarea class="form-control" ng-model="act_desc" ng-model="act_desc" name="act_desc" id="act_desc" value=""></textarea>
      </div>
      </div>


      <div class="form-group">
      <label class="control-label col-md-3" for="act_start_date">Start Date:</label>
      <div class="col-md-8">
      <input type="text" ng-model="act_start_date" class="form-control act_start_date" id="datepicker2" name="act_start_date" />
      </div>
      </div>


      <div class="form-group">
      <label class="control-label col-md-3" for="act_due_date">Due Date:</label>
      <div class="col-md-8">
      <input type="text" ng-model="act_due_date" class="form-control act_due_date" id="datepicker3" name="act_due_date" />
      </div>
      </div>


      <div class="form-group">
      <label class="control-label col-md-3" for="act_budget">Budget:</label>
      <div class="col-md-8">
      <input type="text" ng-model="act_budget" class="form-control" id="act_budget" name="act_budget" />
      </div>
      </div>


      <div class="form-group">
      <label class="control-label col-md-3" for="act_percent">Spend:</label>
      <div class="col-md-8">
      <input type="text" ng-model="act_spend" class="form-control" id="act_spend" name="act_spend" />
      </div>
      </div>


      <div class="form-group">
      <label class="control-label col-md-3" for="act_complete">Completion:</label>
      <div class="col-md-8">
      <p id="act_complete" ng-model="act_complete" name="act_complete"></p>
      </div>
      </div>

      <div class="form-group">
      <label class="control-label col-md-3" for="act_color">Color:</label>
      <div class="col-md-8">
 
      <div id="cp2" class="input-group colorpicker-component">
        <input type="text" value="" ng-model="act_color" class="form-control act_color" id="act_color" name="act_color" />
        <span class="input-group-addon"><i></i></span>
      </div>

      </div>
      </div>

      <div class="form-group">
        <button type="button" class="btn btn-block" ng-click="clean_form_activity()" >Clear</button>
      </div>

      <!-- End of the body -->
      </div>
      <!-- End of the body -->

      <div class="modal-footer">
      <input type="submit" class="btn btn-default" value="Update Changes" name="act_update">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>



<!-- Oun k migoft -->

<!-- Modal For Activities -->
<div id="ModalActivity" class="modal fade modal-font_details" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header modal-header-activity">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal_header"><b>Activity {{activity_title}}</b></h4>
      </div>

      <div class="modal-body">

        <form class="form-horizontal" method="POST" action="activity_new.php">

<!--      Target
          Achivemnt
          Varience-->

        <div class="form-group" hidden>
        <label class="control-label col-md-3" for="act_id_2">Activity ID:</label>
        <div class="col-md-8">
        <input type="text" ng-model="act_id_2" class="form-control" id="act_id_2" name="act_id_2" value="" />
        </div>
        </div>

        <div class="form-group">
        <label class="control-label col-md-3" for="activity_title">Activity Title:</label>
        <div class="col-md-8">
        <input type="text" ng-model="activity_title" name="activity_title" class="form-control" value="" />
        </div>
        </div>

        <div class="form-group">
        <label class="control-label col-md-3" for="act_output">Output:</label>
        <div class="col-md-8">
        <input type="text" ng-model="activity_output" name="activity_output" class="form-control" value="" disabled />
        </div>
        </div>

        <div class="form-group">
        <label class="control-label col-md-3" for="act_outcome">Outcome:</label>
        <div class="col-md-8">
        <input type="text" ng-model="activity_outcome" name="activity_outcome" class="form-control" value="" disabled />
        </div>
        </div>


        <div class="form-group">
        <label class="control-label col-md-3" for="act_start_date">Start Date:</label>
        <div class="col-md-8">
        <input type="text" name="activity_start_date" ng-model="activity_start_date" class="form-control" id="datepicker5" name="" />
        </div>
        </div>


        <div class="form-group">
        <label class="control-label col-md-3" for="activity_due_date">Due Date:</label>
        <div class="col-md-8">
        <input type="text" name="activity_due_date" ng-model="activity_due_date" class="form-control" id="datepicker6" />
        </div>
        </div>


        <div class="form-group">
        <label class="control-label col-md-3" for="act_description">Description:</label>
        <div class="col-md-8">
        <textarea ng-model="activity_description" name="activity_description" class="form-control" value=""></textarea>
        </div>
        </div>

        

        <div class="" style="text-align: right;">
        <input type="submit" class="btn btn-default" name="activity_apply" value="Apply Changes" />
        <br/>
        </div>
</form>
      <hr>
      <p><b>Indicator Tracking Table (ITT)</b></p>
        <a href="" class="btn btn-primary" ng-click="showDetails = ! showDetails">{{toggleText}}</a><br/>

        <div class="itt-plate" style="margin: 20px">

        <table class="table" ng-hide="showDetails" ng-animate="box">

        <tr>
          <th>Quarter</th>
          <th>Target</th>
          <th>Achievement</th>
          <th>Variance</th>
          <th>Remove</th>
        </tr>

        <tr ng-repeat="val in select_all_itt | filter: { itt_act_id : act_id_2 }:true">
          <td>Quarter {{$index + 1}}</td>
          <!-- <td>{{val.itt_target}}</td> -->
          <td>    
          <a href="#" editable-text="val.itt_target"
          onbeforesave="updateTarget(val.itt_id,$data)">{{ val.itt_target || "empty" }}</a><br/>
          </td>

          <td>    
          <a href="#" editable-text="val.itt_ach"
          onbeforesave="updateAchieve(val.itt_id,$data)">{{ val.itt_ach || "empty" }} </a><br/>
          </td>

          <!-- <td>{{val.itt_ach}}</td> -->
          <td>{{((val.itt_ach * 100) / val.itt_target) | number:2}} %</td>
          <td><a href="#" class="btn btn-danger" ng-click="delete_itt(val.itt_id)" >Remove</a></td>
        </tr>

        </table>



      <div class="add_itt_section" ng-show="showDetails" ng-animate="box">
      <form method="POST" action="activity_new.php">
        <div class="form-group">
          <label class="control-label col-md-3 align-left" for="act_id">Target:</label>
          <div class="col-md-8">
          <input type="text" ng-model="activity_target" name="activity_target" class="form-control" value="" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 align-left" for="act_id">Achievement:</label>
          <div class="col-md-8">
          <input type="text" ng-model="activity_achievement" name="activity_achievement" class="form-control" value="" /><br/>
          </div>
        </div>

        <button type="submit" ng-click="submit_new_itt(activity_target,activity_achievement,act_id_2)" class="btn btn-primary btn-block">Add</button><br/>
        </form>
      </div>


        <div class="" style="text-align: right;">
        <input type="submit" class="btn btn-default" name="activity_apply" value="Save" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

        </div>
      </div>

    </div>

  </div>
</div>

<!-- END -->


<!-- Modal For Activities / Options -->
<div id="modal_fresh_activity" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header modal-header-activity">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal_header"><b>Activity Options</b></h4>
      </div>

      <div class="modal-body">

<!-- Remove Activity -->

      <a href="#" data-toggle="collapse" data-target="#activity-table-remove">Remove Activities</a><br/>

      <div class="table-responsive collapse" id="activity-table-remove">
      <table class="table table-compact">
          
          <?php
          foreach ($functions->test_select() as $key => $value) {
          echo "<tr><td>".$value['title']."</td><td><a class='' ng-click='removeActivity(".$value['id'].")'>Delete</td></tr>";
          }

          ?>
        
      </table>
      </div>

<!-- End Remove Activity -->

<!-- /////////////////////////////////////////////// -->
               
      <br/>
         <a href="#" data-toggle="collapse" data-target="#activity-table-add">Add Activity</a><br/>
      <div class="form-style collapse" id="activity-table-add">
        <form class="form-horizontal" method="POST" action="activity_new.php">

        <div class="form-group">
          <label class="col-md-3 control-label">Output:</label>
          <div class="col-md-8">
              <select class="form-control"  style='height:auto'; name="activity_output_id">
              
          <?php foreach ($functions->select_all_output() as $key => $value) {
          echo "<option value='".$value['output_id']."'>".$value['output_desc']."</option>"; } ?>
    
              </select>

              <br/>
          </div>
        </div>

        <div class="form-group">

        <label class="control-label col-md-3" for="activity_title">Title:</label>
        <div class="col-md-8">
        <input type="text" ng-model="new_activity_title" name="new_activity_title" class="form-control" value="" />
        <br/>
        </div>

        </div>

        <div class="" style="text-align: right;">
        <input type="submit" class="btn btn-default" name="new_activity_insertion" value="Save" />
        </div>

        </form>

      </div>

<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->


<!-- Output ADD -->

      <br/>
         <a href="#" data-toggle="collapse" data-target="#output-add">Add Output</a><br/>
      <div class="form-style collapse" id="output-add">
        <form class="form-horizontal">

        <div class="form-group">
          <label class="col-md-3 control-label">Outcome:</label>
          <div class="col-md-8">

              <select class="form-control" ng-model='output_outcome_id'  style='height:auto'; name="activity_output_id">
              
          <?php foreach ($functions->select_all_outcome() as $key => $value) {
          echo "<option value='".$value['outcome_id']."'  >".$value['outcome_desc']."</option>"; } ?>
    
              </select>

              <br/>
          </div>
        </div>

        <div class="form-group">

        <label class="control-label col-md-3" for="activity_title">Output Title:</label>

        <div class="col-md-8">
        <input type="text" ng-model="new_output_title" name="new_output_title" class="form-control" value="" />
        <br/>
        </div>

        </div>

        <div class="" style="text-align: right;">
        <input type="submit" ng-click="new_output_insertion(output_outcome_id ,new_output_title)" class="btn btn-default" name="new_output_insertion" value="Save" />
        </div>

        </form>

      </div>

<!-- End of Adding Output -->

<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////// -->

<!-- Remove output -->

   <br/>
         <a href="#" data-toggle="collapse" data-target="#output-remove">Remove Output</a><br/>
      <div class="form-style collapse" id="output-remove">
        
        <div class="table-responsive">
          <table class="table">

            <tr>
              <th>Output</th>
              <th>Option</th>
            </tr>
              
              <?php

              foreach ($functions->select_all_outputs() as $key => $value) {
                echo "<tr><td>".$value['output_desc']."</td>";
                echo "<td><a href='#' class='btn btn-sm' ng-click=\"remove_output(".$value['output_id'].")\" >Remove</a></td></tr>";
              }

              ?>


          </table>
        </div>

      </div>

<!--  -->


<!-- Add/Remove Outcome -->


      <br/>
         <a href="#" data-toggle="collapse" data-target="#outcome-add">Add Outcome</a><br/>
      <div class="form-style collapse" id="outcome-add">
        <form class="form-horizontal">

        <div class="form-group">

        <label class="control-label col-md-3">Title:</label>
        <div class="col-md-8">
        <input type="text" ng-model="new_outcome_title" name="new_outcome_title" class="form-control" value="" />
        <br/>
        </div>

        </div>

        <div class="" style="text-align: right;">
        <input type="submit" ng-click="new_outcome_insertion(new_outcome_title)" class="btn btn-default" name="new_outcome_title" value="Save" />
        </div>

        </form>

      </div>

<!-- End of Add Remove -->

<!-- Remove Outcome  -->


<br/>
         <a href="#" data-toggle="collapse" data-target="#outcome-remove">Remove Outcome</a><br/>
      <div class="form-style collapse" id="outcome-remove">

       <table class="table">

            <tr>
              <th>Output</th>
              <th>Option</th>
            </tr>
              
              <?php

              foreach ($functions->select_all_outcome() as $key => $value) {
                echo "<tr><td>".$value['outcome_desc']."</td>";
                echo "<td><a href='#' class='btn btn-sm' ng-click=\"remove_outcome(".$value['outcome_id'].")\" >Remove</a></td></tr>";
              }

              ?>


          </table>

      </div>


<!-- End of Remove Outcome -->
<!-- End of Options -->
      </div>
    </div>

  </div>
</div>

<!-- END -->

    </div>
    </div>

<!-- END OF CONTROLER -->
    </div>
    <?php
/////////////////////////////////////// ///////// /////////// //////////// /////////
    require_once "footer.php";

    $oct_per = (int)$functions->calculate_percentage_tracker($oct_budget, $oct_expense);





     ?>
  
<script>
    $(document).ready(function() {

      $('#menu-toggle-1').click(function(){
        $(this).find('i').toggleClass('glyphicon glyphicon-menu-up').toggleClass('glyphicon glyphicon-menu-down');
    });

    });
    



    $(function() {
        $('#cp2').colorpicker();
    });
</script>


<script type="text/javascript">
  
  $("#btn-show-table").click(function(){
    $("#bedget-table").css("display","block");
    $("#btn-show-table").hide();

  });


</script>



<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.js"></script> -->


<!-- Angular js file included here -->
<!-- <script type="text/javascript" src="assets/js/activity.js"></script> -->
<!-- Becareful about this file     -->

<script type="text/javascript">

$(".table-click").click(function(){

   var idOrgin = ($(this).attr('id'));
   var title = '#t'+idOrgin;
   $(title).text('idOrgin');

});

</script>

<script type="text/javascript">

$('#myTable02').fixedHeaderTable({
  altClass: 'odd',
});


</script>

<script>

   
var mod = angular.module("MyApp", ['xeditable','chart.js']);

mod.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});



mod.controller('myCtrl', ['$scope', '$http', function ($scope, $http) {

///////////////////////////////////////////////////////////////////////////////

      var request2 = $http({
      method: "get",
      url : "json/activity_details.json"
      });

      request2.then(function(response){
      $scope.activities = response.data;
      });

////////////////////////////////////////////////////////////////////////////////

      var getActivityDetails = $http({
      method: "get",
      url : "json/sub_activities.json"
      });

      getActivityDetails.then(function(response){
      $scope.sub_activities = response.data;
      });

/////////////////////////////////////////////////////////////////////////////////
      
      var getAllItt = $http({
      method: "get",
      url : "json/select_all_itt.json"
      });

      getAllItt.then(function(response){
      $scope.select_all_itt = response.data;
      });

///////////////////////////////////////////////////////////////////////////////

  $scope.labels = ["Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct-17", "Nov-17", "Dec-17", "Jan-18", "Feb-18", "Mar-18", "Apr-18", "May-18", "Jun-18", "Jul-18", "Aug-18", "Sep-18"];

  $scope.series = ['Budget', 'Exp', 'Var'];

  $scope.colors = ["#ff4d4d", "#0055ff", "#990099"];

  $scope.data = [[<?php echo (int)$oct_budget; ?>,<?php echo (int)$nov_budget; ?>,<?php echo (int)$decm_budget; ?>,<?php echo (int)$jan_budget; ?>,<?php echo (int)$feb_budget; ?>,<?php echo (int)$mar_budget; ?>,<?php echo (int)$apr_budget; ?>,<?php echo (int)$may_budget; ?>,<?php echo (int)$jun_budget; ?>,<?php echo (int)$jul_budget; ?>,<?php echo (int)$aug_budget; ?>,<?php echo (int)$sep_budget; ?>,<?php echo (int)$oct_2_budget; ?>,<?php echo (int)$nov_2_budget; ?>,<?php echo (int)$dec_2_budget; ?>,<?php echo (int)$jan_2_budget; ?>,<?php echo (int)$feb_2_budget; ?>,<?php echo (int)$mar_2_budget; ?>,<?php echo (int)$apr_2_budget; ?>,<?php echo (int)$may_2_budget; ?>,<?php echo (int)$jun_2_budget; ?>,<?php echo (int)$jul_2_budget; ?>,<?php echo (int)$aug_2_budget; ?>,<?php echo (int)$sep_2_budget; ?>],[<?php echo (int)$oct_expense; ?>,<?php echo (int)$nov_expense; ?>,<?php echo $decm_expense; ?>,<?php echo (int)$jan_expense; ?>,<?php echo (int)$feb_expense; ?>,<?php echo (int)$mar_expense; ?>,<?php echo (int)$apr_expense; ?>,<?php echo (int)$may_expense; ?>,<?php echo (int)$jun_expense; ?>,<?php echo (int)$jul_expense; ?>,<?php echo (int)$aug_expense; ?>,<?php echo (int)$sep_expense; ?>,<?php echo (int)$oct_2_expense; ?>,<?php echo (int)$nov_2_expense; ?>,<?php echo (int)$dec_2_expense; ?>,<?php echo (int)$jan_2_expense; ?>,<?php echo (int)$feb_2_expense; ?>,<?php echo (int)$mar_2_expense; ?>,<?php echo (int)$apr_2_expense; ?>,<?php echo (int)$may_2_expense; ?>,<?php echo (int)$jun_2_expense; ?>,<?php echo (int)$jan_2_expense; ?>,<?php echo (int)$aug_2_expense; ?>,<?php echo (int)$sep_2_expense; ?>],[ <?php echo (int)$var_oct_expense.",".(int)$var_nov_expense.",".(int)$var_decm_expense.",".(int)$var_jan_expense.",".(int)$var_feb_expense.",".(int)$var_mar_expense.",".(int)$var_apr_expense.",".(int)$var_may_expense.",".(int)$var_jun_expense.",".(int)$var_jul_expense.",".(int)$var_aug_expense.",".(int)$var_sep_expense.",".(int)$var_oct_2_expense.",".(int)$var_nov_2_expense.",".(int)$var_dec_2_expense.",".(int)$var_jan_2_expense.",".(int)$var_feb_2_expense.",".(int)$var_mar_2_expense.",".(int)$var_apr_2_expense.",".(int)$var_may_2_expense.",".(int)$var_jun_2_expense.",".(int)$var_jan_2_expense.",".(int)$var_aug_2_expense.",".(int)$var_sep_2_expense; ?>]];

  $scope.options = {legend: {display: true, position: 'bottom'}};

  
///////////////////////////////////////////////////////////////////////////////

    $scope.showActivities = function(name) { 

      $scope.act_id = '';
      // $scope.act_id_num = '';
      $scope.act_name = '';
      $scope.act_desc = '';
      $scope.act_start_date = '';
      $scope.act_due_date = ''; 
      $scope.act_budget = '';
      $scope.act_spend = '';
      $scope.act_color = '';
      $scope.act_complete = '';

      angular.forEach($scope.activities, function(value){
      
      if(value.test_id_num == name){

        // clean anything first

      $scope.act_id = '';
      $scope.act_id_num = '';
      $scope.act_name = '';
      $scope.act_desc = '';
      $scope.act_start_date = '';
      $scope.act_due_date = ''; 
      $scope.act_budget = '';
      $scope.act_spend = '';
      $scope.act_color = '';
      $scope.act_complete = '';

      // assign variables then

      $scope.act_id = value.test_id;
      $scope.act_id_num = value.test_id_num;
      $scope.act_name = value.test_title;
      $scope.act_desc = value.test_desc;
      $scope.act_start_date = value.test_start_date;
      $scope.act_due_date = value.act_due_date; 
      $scope.act_budget = value.act_budget;
      $scope.act_spend = value.act_spend;
      $scope.act_color = value.test_color;


      var myEl = angular.element( document.querySelector( '#act_complete' ) );
      myEl.html((value.act_spend * 100)/value.act_budget+' %'); 

      $scope.act_complete = $filter('number')(value.act_spend, 2);

      myE1.html(act_complete);
      
      }else{
        var myEl = angular.element( document.querySelector( '#act_id_num' ) );
      myEl.val(name);
      
      }

      });
  
    };

//// another function for activities details ///////////////////////////////////
    
    

      $scope.clean_form_activity = function() { 

    
      $scope.act_name = '';
      $scope.act_desc = '';
      $scope.act_start_date = '';
      $scope.act_due_date = ''; 
      $scope.act_budget = '';
      $scope.act_spend = '';
      $scope.act_color = '';

      var myEl = angular.element( document.querySelector( '#act_complete' ) );
      myEl.html(''); 

      // $scope.act_complete = $filter('number')(value.act_spend, 2);

    };


////////////////////////////////////////////////////////////////////////////////


    $scope.activitiesModal = function(num) { 

      //Target
      //Achivemnt
      //Varience

        $scope.activity_title = '';
        $scope.activity_start_date = '';
        $scope.activity_due_date = '';
        $scope.activity_target = '';
        $scope.activity_achievement = '';
        $scope.activity_varience = '';
        $scope.activity_description = '';


      angular.forEach($scope.sub_activities, function(value){
      
      if(value.id == num){

      // assign variables then

        $scope.act_id_2 = value.id;
        $scope.activity_title = value.title;

        $scope.activity_output = value.output_desc;
        $scope.activity_outcome = value.outcome_desc;

        $scope.activity_start_date = value.start_date;
        $scope.activity_due_date = value.end_date;
        // $scope.activity_target = value.target;
        // $scope.activity_achievement = value.achievement;
        // $scope.activity_varience = value.variance;
        $scope.activity_description = value.description;

      }

      });

    };

//// Toggle for Button Text Onclick ///////////////////////////////////////////////////

 $scope.showDetails = false;
    
    $scope.$watch('showDetails', function(){
        $scope.toggleText = $scope.showDetails ? 'ITT List' : 'New Quarter';
    })

//Insert New Quarter in ITT Table /////////////////////////////////////////////////////

$scope.submit_new_itt = function(val_1,val_2,val_3) {

      $http({
      method: 'POST',
      url: 'activity/insert_itt.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {target: val_1, achievement: val_2, act_id: val_3}
      }).then(function () {

      });

};


////////////////////////////////////////////////////////////////////////////////////////

 $scope.updateTarget = function(id, name) { 

      $http({
      method: 'POST',
      url: 'activity/changeTarget.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id, target: name}
      }).then(function () {

      });

    };
    
////////////////////////////////////////////////////////////////////////////////////////

 $scope.updateAchieve = function(id, name) { 
 
    $http({
      method: 'POST',
      url: 'activity/updateAchieve.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id, achieve: name}
      }).then(function () {

      });

    };

////////////////////////////////////////////////////////////////////////////////////////

  $scope.delete_itt = function(id) { 
  
    $http({
      method: 'POST',
      url: 'activity/delete_itt.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });

    };




///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
/// removeActivity ////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////



  $scope.removeActivity = function(id) { 

    $http({
      method: 'POST',
      url: 'activity/remove_Activity.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };

//////////////////////////////////////////////////////////////////////////////////////

$scope.new_output_insertion = function(outcome_id, output_desc) { 


    $http({
      method: 'POST',
      url: 'activity/add_output.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: outcome_id, name: output_desc}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };



/////////////////////////////////////////////////////////////////////////////////////

$scope.remove_output = function(id) { 


    $http({
      method: 'POST',
      url: 'activity/remove_output.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };

/////////////////////////////////////////////////////////////////////////////////////

$scope.new_outcome_insertion = function(output_desc) { 
   
    $http({
      method: 'POST',
      url: 'activity/add_outcome.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {name: output_desc}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };



/////////////////////////////////////////////////////////////////////////////////////

$scope.remove_outcome = function(id) { 


    $http({
      method: 'POST',
      url: 'activity/remove_outcome.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };

/////////////////////////////////////////////////////////////////////////////////////


}]);

</script>
  




<?php

if(isset($_POST['act_update'])){

    $act_id = $_POST['act_id'];
    $act_id_num = $_POST['act_id_num'];

    // echo "<script>alert(".$act_id."-".$act_id_num.");</script>";

    $act_name = $_POST['act_name'];
    $act_desc = $_POST['act_desc'];
    $act_start_date = $_POST['act_start_date'];
    $act_due_date = $_POST['act_due_date'];
    $act_budget = $_POST['act_budget'];
    $act_percent = $_POST['act_spend'];
    $act_color = $_POST['act_color'];

    if($act_id > 0){
      // Update the previus insertion
      $functions->update_activity_details($act_id, $act_id_num, $act_name, $act_desc, $act_start_date, $act_due_date, $act_budget, $act_percent, $act_color);
      echo "<script>window.location.replace('activity_new.php')</script>";
      

    }else{
      // Insert a new row
      $functions->add_activity_details($act_id, $act_id_num, $act_name, $act_desc, $act_start_date, $act_due_date, $act_budget, $act_percent, $act_color);
      echo "<script>window.location.replace('activity_new.php')</script>";
      
    }

}

// Update Activity Details - by clicking on the activity name we can update the fields in the database.

if(isset($_POST['activity_apply'])){

    $act_id = $_POST['act_id_2'];
    $act_title = $_POST['activity_title'];
    $act_start_date = $_POST['activity_start_date'];
    $act_due_date = $_POST['activity_due_date'];
    $act_desc = $_POST['activity_description'];
    $act_target = "0";
    $act_achievement = "0";
    $act_varience = "0";
    
      // Insert a new row
      $functions->update_activity($act_id, $act_title, $act_start_date, $act_due_date, $act_target, $act_achievement, $act_varience, $act_desc);

      echo "<script>window.location.replace('activity_new.php')</script>";

}

// Add Activity by clikcing on the add button in the top of the form

if(isset($_POST['new_activity_insertion'])){

    $act_name = $_POST['new_activity_title'];
    $act_output_id = $_POST['activity_output_id'];

      // Insert a new row
      $functions->add_fresh_activity($act_name, $act_output_id);

      echo "<script>window.location.replace('activity_new.php')</script>";

}

?>