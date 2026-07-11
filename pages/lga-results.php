<?php
    require "../config/database.php";
    $lga_id = "";
    if(isset($_POST["lga"])){
        $lga_id = $_POST["lga"];
        $lga2_query = "SELECT lga_name FROM lga WHERE lga_id = '$lga_id'";
        $lga2_result = mysqli_query($con, $lga2_query);
        $lga2 = mysqli_fetch_assoc($lga2_result);
        $lga2_name = $lga2['lga_name'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Bincom</title>
</head>
<body>

    <div class="container mb-5" >
        <h2> Check Polling Unit Result</h2>
        <form name="my-form" action="" method="post">
            <div class="mb-3">
                <label for="forn-select" class="form-label">Local Government</label>
                <select class="form-select" aria-label="Default select example" name="lga" onchange="this.form.submit()">
                    <?php
                        
                        if(isset($lga2_name)){
                            echo '<option value="'.$lga_id.'" selected>'.$lga2_name.'</option>';
                        }else{
                    ?>
                    <option selected>Select LGA </option>
                    
                    <?php
                    }
                        $lga_query = "SELECT * FROM lga";
                        $lga_result = mysqli_query($con, $lga_query);
                        if(!$lga_result){
                            die("Error fetching LGA data: " . mysqli_error($con));
                        } else{             
                              while($lga = mysqli_fetch_assoc($lga_result)){
                            
                    ?>
                    <option value="<?php echo $lga['lga_id'];?>"> <?php echo $lga['lga_name'];?> </option>
                    <?php
                        }    
                        }
                    ?>
                    
                </select>
            </div>

        </form>
</div>
<div class="container mt-5" >
    <h2>Total Result</h2>
     <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Party </th>
            <th scope="col">Score</th>
            </tr>
        </thead>

    <?php
        $Total_query = "SELECT apr.party_abbreviation, SUM(apr.party_score) AS total_score FROM announced_pu_results apr JOIN polling_unit pu ON apr.polling_unit_uniqueid = pu.uniqueid WHERE pu.lga_id = '$lga_id' GROUP BY apr.party_abbreviation";
        $Total_result = mysqli_query($con, $Total_query);
        if(!$Total_result){
            die("Error fetching Total Result data: " . mysqli_error($con));
        } else{    
            $n = 1;         
              while($Total = mysqli_fetch_assoc($Total_result)){
                $party = $Total['party_abbreviation'];
                $score = $Total['total_score'];
                

    ?>

  <tbody>
    <tr>
      <th scope="row"><?php echo $n; ?></th>
      <td><?php echo $party; ?></td>
      <td><?php echo $score; ?></td>
    </tr>

  </tbody>
  <?php
        $n++;
                 }
                 }
    ?>
</table>
 
    </div>
    <div class="container mt-5">
        <a href="../index.php" class="btn btn-primary" >Back</a>
    </div>
</body>
</html>