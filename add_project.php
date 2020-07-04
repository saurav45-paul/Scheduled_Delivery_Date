<?php

require_once('./helpers/initialize.php');

session_start();

$username = DATABASE_USER;
$password = DATABASE_PASSWORD;
$host = SERVER;
$database = DATABASE_NAME;

$con = mysqli_connect($host,$username,$password,$database);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit;
}

?>

<?php

function getProjectWordCount($date) {
    global $con;

    $sql = "SELECT SUM(number_of_words) AS value_sum FROM projects WHERE scheduled_date='$date'";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    
    if ($sum = $row["value_sum"]) {
        return $sum;
    }
    else {
        return 0;
    }

}

function calculateScheduledDate($numberOfWords, $date) {

    $wordCount = getProjectWordCount($date);
    $sum = $wordCount + $numberOfWords;

    if ($sum <= 1000) {
        return $date;
    }
    else {
        $nextDay = date('y-m-d', strtotime($date . ' +1 day'));
        return calculateScheduledDate($numberOfWords, $nextDay);
    } 
}


if(is_post_request()) {
    $topic = $_POST['topic_name'] ?? '';
    $number_of_words = intval($_POST['number_of_words']) ?? 0;
    $instructions = $_POST['instructions'] ?? '';

    if(is_blank($topic)) {
        $message = display_bootstrap_error('Please enter topic name.');
    }
    else if ($number_of_words <= 0) {
        $message = display_bootstrap_error('Number of words should be greater than 0.');
    }
    else if ($number_of_words > 1000) {
        $message = display_bootstrap_error('Number of words can not be greater than 1000.');
    }
    else if(is_blank($instructions)) {
        $message = display_bootstrap_error('Please enter additional informations.');
    }
    else {
        $today = date('y-m-d');
        $scheduled_date = calculateScheduledDate($number_of_words, $today);

        $insertquery = "insert into  projects (client_name, topic_name, number_of_words, instructions, scheduled_date)
        values('XYZ','$topic','$number_of_words','$instructions','$scheduled_date') ";

        $res =  mysqli_query($con,$insertquery);

        if($res) {
            $message = display_bootstrap_success('Project added successfully.');
        } else {
            $message = display_bootstrap_error('Something went wrong while adding project.');
        }
    }



    if (!$topic || $number_of_words || $instructions) {
        //$message = display_bootstrap_success('Enter All fields');
    }
    else {
        
    }


    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>List Project</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./styles/styles.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

    <body>

        <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
            <a class="navbar-brand" href="/">Project</a>
            </div>
            <ul class="nav navbar-nav">
            <li><a href="/">Home</a></li>
            </ul>
        </div>
        </nav>

        <div class='add_project'>

            <?php echo $message; ?>

            <h3>Add Project</h3>
            <hr>
            <form method="post" name="add_project" onsubmit="return onSubmit()">
                
                <div class="form-group">
                    <label for="text">Topic</label>
                    <input type="text" class="form-control" id="topic_name" name="topic_name">
                </div>
                
                <div class="form-group">
                    <label for="text">Number of words</label>
                    <input type="number" class="form-control" id="number_of_words" name="number_of_words">
                </div>

                <div class="form-group">
                    <label for="text">Additional Information</label>
                    <input type="text" class="form-control" id="instructions" name="instructions">
                </div>
                <input type="submit" class="btn btn-success" name="submit">
            </form>
        </div>
    </body>
</html>


