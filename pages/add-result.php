<?php
    require "../config/database.php";
    $ward_unique_id = "";
    if(isset($_POST["lga"])){
        $lga_id = $_POST["lga"];
        $lga2_query = "SELECT lga_name FROM lga WHERE lga_id = '$lga_id'";
        $lga2_result = mysqli_query($con, $lga2_query);
        $lga2 = mysqli_fetch_assoc($lga2_result);
        $lga2_name = $lga2['lga_name'];
    }

    if(isset($_POST["send"])){
        $lga_id = $_POST["lga"];
        $ward_id = $_POST["wards"];
        $polling_id = $_POST["polling_id"];
        // $unique_ward_id = $_POST["unique_ward_id"];
        $Unit_name = $_POST["Unit_name"];

        $insert_query = "INSERT INTO polling_unit (polling_unit_id, ward_id, lga_id, uniquewardid, polling_unit_number, polling_unit_name, polling_unit_description, lat, `long`, entered_by_user, date_entered, user_ip_address) VALUES ('$polling_id', '$ward_id', '$lga_id', NULL, NULL, '$Unit_name', NULL, NULL, NULL, NULL, NULL, NULL)";
        
        if(mysqli_query($con, $insert_query)){
            echo "<script>alert('Polling Unit added successfully!');</script>";
            $_SESSION['unique_id'] = mysqli_insert_id($con);
            echo "<script>window.location.href = 'add-score.php';</script>";
        } else {
            echo "<script>alert('Error adding Polling Unit: " . mysqli_error($con) . "');</script>";
        }
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
        <h2> Add a New Polling Unit</h2>
        <form name="my-form" action="" method="post">
            <div class="mb-3">
                <label for="forn-select" class="form-label">Local Government</label>
                <select class="form-select" aria-label="Default select example" name="lga" onchange="this.form.submit()" required>
                    <?php
                        
                        if(isset($lga2_name)){
                            echo '<option value="'.$lga_id.'" selected>'.$lga2_name.'</option>';
                            unset($lga2_name);
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
                <select class="form-select" aria-label="Default select example" name="wards" onchange="this.form.submit()" required>
                    <?php
                        if(isset($_POST["wards"])){
                            $ward_id = $_POST["wards"];
                            $ward_query2 = "SELECT ward_name, uniqueid FROM ward WHERE ward_id = '$ward_id'";
                            $ward_result2 = mysqli_query($con, $ward_query2);
                            $ward2 = mysqli_fetch_assoc($ward_result2);
                            $ward2_name = $ward2['ward_name'];
                            $ward_unique_id = $ward2['uniqueid'];
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
                <label for="polling_id" class="form-label">Polling unit Id</label>
                <input type="text" class="form-control" id="polling_id" name="polling_id" placeholder="" required>
            </div>

            <div class="mb-3">
                <label for="polling_id" class="form-label">Unique Ward Id</label>
                <input type="text" class="form-control" id="polling_id" name="unique_ward_id" value="<?php echo $ward_unique_id;?>" disabled required>
            </div>

            <div class="mb-3">
                <label for="polling_id" class="form-label">Polling Unit Name</label>
                <input type="text" class="form-control" id="polling_id" name="Unit_name" placeholder="" required>
            </div>
            
            <button type="submit" class="btn btn-primary" name="send">Submit</button>
        </form>
</div>

    <div class="container mt-5">
        <a href="../index.php" class="btn btn-primary" >Back</a>
    </div>
    
</body>
</html>