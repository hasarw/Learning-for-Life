<?php
session_start();
if(!isset($_SESSION['member_username'])){

  header('HTTP/1.0 403 Forbidden');
      exit; // important to prevent further execution of the script
}

?>

<div class="container hidden-print" id="footer-area">
<div class="footer navbar-fixed-bottom">
<div id="footer">
      <div class="container">
        <p class="text-muted credit">World Vision Afghanistan | <a href="#"><b>Learning for Life Project - 2017</b></a> | Developed by Hekmatullah Sarwarzadah</p>

      </div>
    </div>
  </div>
</div>

</div> <!-- end of header div for margin -->
<!-- <script src="assets/js/angular.min.js"></script> -->


<script src="assets/js/angular.min.js"></script>


<script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="assets/js/umd/popper.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>


<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<!-- Pilly Library -->
<script type="text/javascript" src="assets/css/p/popeye.js"></script>
<!-- End of the Pilly Library -->

<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/date-js/date.js"></script>

<script type="text/javascript" src="assets/js/bootstrap-editable/xeditable.js"></script>



<script type="text/javascript" src="assets/js/dirPagination.js"></script>
<!-- <script type="text/javascript" src="assets/js/ui-bootstrap-tpls-2.3.1.min.js"></script> -->
<script type="text/javascript" src="assets/js/angular-filter.min.js"></script>

<!-- Chart.js is required by Angular-js chart -->
<!-- CDN: <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script> -->
<script src="assets/js/chart.js"></script>
<!-- Angular-chart is for charts and pie charts maybe -->
<script src="assets/js/chart/angular-chart.min.js"></script>

<script src="assets/js/angular-sanitize.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular-sanitize.js"></script> -->
<script src="assets/js/select.js"></script>

<script type="text/javascript" src="assets/slider/rzslider.min.js"></script>


<!-- Table to Excel shits -->
<script type="text/javascript" src="assets/js/excel/xls.core.js"></script>

<script type="text/javascript" src="assets/js/excel/FileSaver.js"></script>

<script type="text/javascript" src="assets/js/excel/tableexport.js"></script>


<!-- the datepicker -->
<!-- <script type="text/javascript" src="assets/js/datepicker/bootstrap-datepicker.min.js"></script> -->
<script type="text/javascript" src="assets/js/datepicker/moment.js"></script>
<script type="text/javascript" src="assets/js/datepicker/bootstrap-datetimepicker.js"></script>


<script type="text/javascript" src="assets/js/color-picker/bootstrap-colorpicker.js"></script>

<!-- Some library for table scroll and fix thead -->

<script type="text/javascript" src="assets/js/table-scroll/jquery.fixedheadertable.js"></script>

<!-- The End for Table thead scrolling -->

<script src="http://malsup.github.com/jquery.form.js"></script> 


<script type="text/javascript">
	
	$('#menu-toggle-1').click(function(){
    $(this).find('i').toggleClass('glyphicon glyphicon-menu-up').toggleClass('glyphicon glyphicon-menu-down');
});

$('#menu-toggle-2').click(function(){
    $(this).find('i').toggleClass('glyphicon glyphicon-menu-up').toggleClass('glyphicon glyphicon-menu-down');
});


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});



$(function () {
  $('[data-toggle="popover"]').popover()
})


  $( function() {

    $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });

  } );


  $( function() {

    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );

  $( function() {

    $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );

  $( function() {

    $( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );

    $( function() {

    $( "#datepicker5" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );

      $( function() {

    $( "#datepicker6" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );

</script>











