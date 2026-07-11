<?php
    require "../config/database.php";

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
            <div class="mb-3">
                <label for="forn-select" class="form-label">Ward</label>
                <select class="form-select" aria-label="Default select example" name="wards" onchange="this.form.submit()">
                    <?php
                        if(isset($_POST["wards"])){
                            $ward_id = $_POST["wards"];
                            $ward_query2 = "SELECT ward_name FROM ward WHERE ward_id = '$ward_id'";
                            $ward_result2 = mysqli_query($con, $ward_query2);
                            $ward2 = mysqli_fetch_assoc($ward_result2);
                            $ward2_name = $ward2['ward_name'];
                            echo '<option value="'.$ward_id.'" selected>'.$ward2_name.'</option>';
                        }else{
                    ?>
                    <option selected>Select Ward </option>
                    <?php
                        }
                        if(isset($_POST["lga"])){
                            $lga_id = $_POST["lga"];
                            $ward_query = "SELECT * FROM ward WHERE lga_id = '$lga_id'";
                            $ward_result = mysqli_query($con, $ward_query);
                            if(!$ward_result){
                                die("Error fetching Ward data: " . mysqli_error($con));
                            } else{             
                                  while($ward = mysqli_fetch_assoc($ward_result)){
                                    $wardname = $ward['ward_name'];
                                    $wardid = $ward['ward_id'];
                    ?>
                    <option value="<?php echo $wardid;?>"> <?php echo $wardname;?> </option>
                    <?php
                        }    
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="forn-select" class="form-label">Polling Unit</label>
                <select class="form-select" aria-label="Default select example" onchange="this.form.submit()" name="polling_unit">
                    <option selected>Select Polling Unit </option>
                    <?php 
                    if(isset($_POST["wards"])){
                       $ward_id = $_POST["wards"];
                       $polling_query = "SELECT * FROM polling_unit WHERE ward_id = '$ward_id'";
                        $polling_result = mysqli_query($con, $polling_query);
                        if(!$polling_result){
                            die("Error fetching Polling Unit data: " . mysqli_error($con));
                        } else{             
                              while($polling = mysqli_fetch_assoc($polling_result)){
                                $pollingname = $polling['polling_unit_name'];
                                $pollingid = $polling['uniqueid'];
                    
                ?>
                <option value="<?php echo $pollingid;?>"> <?php echo $pollingname;?> </option>
                <?php
                    }    
                    }
                }
                ?>
                </select>
            </div>
            
        </form>
</div>
<div class="container mt-5" >
    <h2>Polling Unit Results</h2>
     <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Party </th>
            <th scope="col">Score</th>
            </tr>
        </thead>

    <?php
        if(isset($_POST["polling_unit"])){
            $polling_unit_id = $_POST["polling_unit"];
            $polling_unit_query = "SELECT * FROM announced_pu_results where polling_unit_uniqueid = '$polling_unit_id'";
            $polling_unit_result = mysqli_query($con, $polling_unit_query);
            if(!$polling_unit_result){
                die("Error fetching Polling Unit data: " . mysqli_error($con));
            } else{  
                $n =1;           
                  while($polling_unit = mysqli_fetch_assoc($polling_unit_result)){
                    $party = $polling_unit['party_abbreviation'];
                    $score = $polling_unit['party_score'];
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
        }
    ?>
</table>
 
    </div>

    <div class="container mt-5">
        <a href="../index.php" class="btn btn-primary" >Back</a>
    </div>
    
</body>
</html>