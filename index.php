<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Submission 1 Microsoft Azure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <style type="text/css">
        body { background-image: url("cartographer.png");
        background-color: #fff;
                color: #333; font-size: .85em; margin: 20; padding: 20;
                font-family: "Sagoe UI", Verdana, Helvetica, Sans-Serif;}

                h1, h2, h3,{color: #212e53; margin-bottom: 0; padding-bottom: 0;}
                h1{font-size: 2em; color: #000; font-family: Montserrat Thin; text-align: center;
                margin-top: 2em;}
                h2{font-size: 1.75em;}
                h3{font-size: 1.2em;}
                th{font-size: 1.2em; text-align: left; border: none; padding-left:0;}
                td{padding: 0.25em 2em 0.25em 0em; border: 0 none;}
    </style>
</head>
<body>
    <h1>Register Here!</h1>
    <p style="font-style:italic; font-family: Montserrat Thin; color:#000; text-align:center;">Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
    <form method="post" action="index.php" enctype="multipart/form-data">
            Name  <input type="text" name="name" id="name"/></br></br>
            Email <input type="text" name="email" id="email"/></br></br>
            Job <input type="text" name="job" id="job"/></br></br>
            <input type="submit" name="submit" value="Submit" />
            <input type="submit" name="load_data" value="Load Data" />
    </form>

    <?php
        $host = "eko8757server.database.windows.net";
        $user = "eko8575";
        $pass = "Nadado123";
        $db = "submissiondicodingappserver";

        try {
            $conn = new PDO("sqlsrv:Server = $host; Database = $db", $user, $pass);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        if (isset($_POST['submit'])) {
            try {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $job = $_POST['job'];
                $date = date("Y-m-d");

                $sql_insert = "INSERT INTO Registration (name, email, job, date) 
                            VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $name);
                $stmt->bindValue(2, $email);
                $stmt->bindValue(3, $job);
                $stmt->bindValue(4, $date);
                $stmt->execute();
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
            echo "<h3>Your're registered!</h3>";
        } else if (isset($_POST['load_data'])) {
            try {
                $sql_select = "SELECT * FROM Registration";
                $stmt = $conn->query($sql_select);
                $registrants = $stmt->fetchAll();
                if (count($registrants) > 0) {
                    echo "<h2>People who are registered:</h2>";
                    echo "<table>";
                    echo "<tr><th>Name</th>";
                    echo "<th>Email</th>";
                    echo "<th>Job</th>";
                    echo "<th>Date</th></tr>";
                    foreach($registrants as $registrants) {
                        echo "<tr><td>".$registrant['name']."</td>";
                        echo "<td>".$registrant['email']."</td>";
                        echo "<td>".$registrant['job']."</td>";
                        echo "<td>".$registrant['date']."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<h3>No one is currently registered.</h3>";
                }
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
        }
    ?>
</body>
</html>
