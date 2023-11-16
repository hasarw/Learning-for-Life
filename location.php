<?php
require_once "db.php";
include_once "header.php";
require_once "query_functions.php";

$functions = new query_functions();

?>

<div class="container">


<!-- Data Table Here -->
<div class="row" id="row-table">
  <div class="table-responsive">

<table class="table table-bordered table-condensed table-hover table-location">

  <tr class="location_th">
    <th>Province</th>
    <th>District</th>
    <th>Villages</th>
    <th>Male</th>
    <th>Female</th>
  </tr>

  <tr>
    <td rowspan="3">Herat <span class="badge"> <?php echo $functions -> countBeneficiary("beneficiary_district","'Karookh','Gozarah','Enjil'"); ?></span></td>
    <td>Gozarah <span class='top label label-success' data-toggle="tooltip" title="Number of Beneficiary in Gozarah" data-original-title="Tooltip on right"><?php echo $totalBeneficiaries = $functions -> countBeneficiary("beneficiary_district","'Gozarah'"); ?></span></td>
  <td>

      <?php
      foreach (($functions -> countVillages("Gozarah")) as $x) {
        echo "<li>".$x['beneficiary_village']." <span class='badge'>  ".$x['total']."</span></li>";
      }
      ?>

    </td>

    <?php
    foreach (($functions -> getGender("Gozarah")) as $x) {
      $CountGender = $x['genderCount'];
      $percent = number_format((($CountGender/$totalBeneficiaries)*100),1)." %";
      echo "<td>".$CountGender." <span class='label label-primary'>".$percent."</span></td>";
    }
      ?>
  </tr>

  <tr>
    <td>Enjil <span class='label label-success'><?php echo $totalBeneficiaries = $functions -> countBeneficiary("beneficiary_district","'Enjil'"); ?></span></td>
    <td>

      <?php

      foreach (($functions -> countVillages("Enjil")) as $x) {
        echo "<li>".$x['beneficiary_village']." <span class='badge'>  ".$x['total']."</span></li>";
      }

        ?>

    </td>

    <?php
    foreach (($functions -> getGender("Enjil")) as $x) {
      $CountGender = $x['genderCount'];
      $percent = number_format((($CountGender/$totalBeneficiaries)*100),1)." %";
      echo "<td>".$CountGender." <span class='label label-primary'>".$percent."</span></td>";
    }
      ?>
  </tr>
  <tr>
    <td>Karookh <span class='label label-success'><?php echo $totalBeneficiaries = $functions -> countBeneficiary("beneficiary_district","'Karookh'"); ?></span></td>
    <td>

      <?php

      foreach (($functions -> countVillages("Karookh")) as $x) {
        echo "<li>".$x['beneficiary_village']." <span class='badge'>  ".$x['total']."</span></li>";
      }

        ?>

    </td>

    <?php
    foreach (($functions -> getGender("Karookh")) as $x) {
      $CountGender = $x['genderCount'];
      $percent = number_format((($CountGender/$totalBeneficiaries)*100),1)." %";
      echo "<td>".$CountGender." <span class='label label-primary'>".$percent."</span></td>";
    }
      ?>
  </tr>

  <tr>
  <td rowspan="3">Badgis <span class="badge"> <?php echo $functions -> countBeneficiary("beneficiary_district","'Moqor','Qala-e-Now'"); ?></span></td>
    <td>Moqor <span class='label label-success'><?php echo $totalBeneficiaries = $functions -> countBeneficiary("beneficiary_district","'Moqor'"); ?></td>
    <td>

      <?php

      foreach (($functions -> countVillages("Moqor")) as $x) {
        echo "<li>".$x['beneficiary_village']." <span class='badge'>  ".$x['total']."</span></li>";
      }

        ?>

    </td>

    <?php
    foreach (($functions -> getGender("Moqor")) as $x) {
      $CountGender = $x['genderCount'];
      $percent = number_format((($CountGender/$totalBeneficiaries)*100),1)." %";
      echo "<td>".$CountGender." <span class='label label-primary'>".$percent."</span></td>";
    }
      ?>
  </tr>
  <tr>
    <td>Qala-e-Now <span class='label label-success'><?php echo $totalBeneficiaries = $functions -> countBeneficiary("beneficiary_district","'Qala-e-Now'"); ?></span></td>
    <td>

      <?php

      foreach (($functions -> countVillages("Qala-e-Now")) as $x) {
        echo "<li>".$x['beneficiary_village']." <span class='badge'>  ".$x['total']."</span></li>";
      }

        ?>

    </td>

    <?php
    foreach (($functions -> getGender("Qala-e-Now")) as $x) {
      $CountGender = $x['genderCount'];
      $percent = number_format((($CountGender/$totalBeneficiaries)*100),1)." %";
      echo "<td>".$CountGender." <span class='label label-primary'>".$percent."</span></td>";
    }
      ?>

  </tr>
</table>
</div>
</div> <!-- end of row-table -->

</div>

<?php require_once "footer.php"; ?>
