<?php
    require "../config/database.php";
    date_default_timezone_set('Africa/Lagos');
    if(isset($_SESSION['unique_id'])){
    $pollingUnitId = $_SESSION['unique_id'];
    }
    if(isset($_POST['send'])){
        $scores = [

            "PDP" => $_POST["PDP"],
            "ACN" => $_POST["ACN"],
            "DPP" => $_POST["DPP"],
            "PPA" => $_POST["PPA"]

        ];

        $today = date("Y-m-d H:i:s");

        foreach($scores as $party => $score){
        if ($score === "" || !is_numeric($score) || $score < 0) {
        echo "Invalid score for $party.";
    }
    elseif($pollingUnitId < 0){
        echo "Invalid unique id";
    }
    else{
        $score_query = "INSERT INTO announced_pu_results
        (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered)
        VALUES
        ('$pollingUnitId','$party','$score','','$today')";
        if(mysqli_query($con, $score_query)){
           unset($_SESSION['unique_id']);
           echo "<script>alert('Score Added');</script>";
            echo "<script>window.location.href = 'add-result.php';</script>";
        } else {
            echo "<script>alert('Error adding Polling Unit: " . mysqli_error($con) . "');</script>";
        }
    }
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

    <div class="container mb-5 mt-5" >
        <h2> Add Score for parties</h2>
        <form name="my-form" action="" method="post">
            <?php
                $get_party_query = "SELECT * from party ORDER BY id ASC LIMIT 4";
                $get_party_result = mysqli_query($con, $get_party_query);
                        if(!$get_party_result){
                            die("Error fetching Party data: " . mysqli_error($con));
                        } else{ 
                            while($get_party = mysqli_fetch_assoc($get_party_result)){
            ?>
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon3"><?php echo $get_party['partyname']; ?> </span>
                    <input type="number" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" name="<?php echo $get_party['partyname']; ?>">
                </div>
            </div>

            <?php 
                    }            
                }
            ?>

            <div class="mb-3">
                <label for="polling_id" class="form-label">User</label>
                <input type="text" class="form-control" id="polling_id" name="Unit_name" placeholder="Input User's name" required>
            </div>
            
            <button type="submit" class="btn btn-primary" name="send">Submit</button>
        </form>
</div>
    
</body>
</html>