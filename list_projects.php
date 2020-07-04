<?php

require_once('./helpers/initialize.php');

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
      <style>
  .footer{
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: black;
      color: white;
      text-align: center;

  }
  </style>
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

    <div class='view_projects'>
      <h2>On-Going Projects</h2>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Topic</th>
            <th>Number of Words</th>
            <th>Instructions</th>
            <th>Scheduled Delivery Date</th>
          </tr>
        </thead>
        
        <?php
            $fetchQuery = "SELECT * FROM projects ORDER BY scheduled_date  ";
            
            $result = mysqli_query($con, $fetchQuery);

            while($row = mysqli_fetch_assoc($result)) {

               $scheduled_date = $row["scheduled_date"];
               $formatted = date('jS F Y', strtotime($scheduled_date));
                echo "<tr><td>" . $row["topic_name"]. "</td>
                            <td>" . $row["number_of_words"]. "</td>
                            <td>" . $row["instructions"]. "</td>
                            <td>" . $formatted. "</td>
                        </tr>";
            }
          
            mysqli_free_result($result);
            mysqli_close($con);
        ?>
        </table>
    </div>
    <div class="footer" >
            <p>Created by : Saurav Paul</p> <p>Email : Saurav.paul45@gmail.com</p> <p>GitHub : https://github.com/saurav45-paul</p>
            </div>

  </body>
</html>