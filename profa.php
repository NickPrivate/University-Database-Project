<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>CSUF 332 Project</title>

    <link rel="stylesheet" type="text/css" href="includes/style.css">
    <link rel="stylesheet" type="text/css" href="includes/tablestyle.css">

</head>
<body>
<?php include 'includes/buttons.php';?>
    <br><br>
    <h1>Professor A</h1>
    <h3>
        Given the social security number of a professor,
        list the titles, classrooms, meeting days and time of his/her classes.
    </h3>

    <br><br>

    <h2>Sample Input:</h2>
    <h4>847732821</h4>
    <h4>939837943</h4>
    <h4>358102641</h4>

    <br><br><br>
    

    <form method="post" action="">
        <label for="ssn">Enter Professor's Social Security Number:</label>
        <input type="text" name="ssn" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the entered SSN
        $ssn = $_POST['ssn'];

        // Validate the SSN 
        if (preg_match("/^\d{9}$/", $ssn)) {
            // Connect to the database
            include 'includes/db_connection.php';

            // Prepare and execute the query
          $query = "SELECT Courses.Title, Sections.Classroom, Sections.MeetingDays, Sections.BeginningTime, Sections.EndingTime
          FROM Sections
          INNER JOIN Courses ON Sections.CourseNumber = Courses.CourseNumber
          WHERE Sections.ProfessorSSN = '$ssn'";


            $result = $conn->query($query);

            // Display the results
            if ($result->num_rows > 0) {
                echo "<br><h2>Classes Taught by Professor</h2>";
                echo "<table>";
                echo "<tr><th>Title</th><th>Classroom</th><th>Meeting Days</th><th>Time</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['Title']}</td>";
                    echo "<td>{$row['Classroom']}</td>";
                    echo "<td>{$row['MeetingDays']}</td>";
                    echo "<td>{$row['BeginningTime']} - {$row['EndingTime']}</td>";
                    echo "</tr>";
                }
                

                echo "</table>";
            } else {
                echo "<p>No classes found for the given professor.</p>";
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "<p>Invalid Social Security Number. Please enter a valid 9-digit SSN.</p>";
        }

    }       

    ?>

</body>
</html>
