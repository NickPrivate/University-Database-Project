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
    <h1>Student B</h1>
    <h3>Given the campus wide ID of a student, list all courses the student took and the grades.</h3>

    <br><br>

    <h2>Sample Input:</h2>
    <h4>983035503</h4>
    <h4>245231751</h4>
    <h4>222641809</h4>

    <br><br><br>

    <form method="post" action="">
        <label for="campusWideID">Enter Campus Wide ID:</label>
        <input type="text" name="campusWideID" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the entered Campus Wide ID
        $campusWideID = $_POST['campusWideID'];

        // Validate the input
        if (ctype_alnum($campusWideID)) {
            // Connect to the database
            include 'includes/db_connection.php';

            // Prepare and execute the query
            $query = "SELECT Courses.CourseNumber, Courses.Title, EnrollmentRecords.Grade
            FROM EnrollmentRecords
            JOIN Sections ON EnrollmentRecords.CourseSectionNumber = Sections.SectionNumber
            JOIN Courses ON Sections.CourseNumber = Courses.CourseNumber
            WHERE EnrollmentRecords.StudentID = '$campusWideID'";
  

            $result = $conn->query($query);

            // Display the results
            if ($result->num_rows > 0) {
                echo "<br><h2>Courses Taken by Student $campusWideID</h2>";
                echo "<table>";
                echo "<tr><th>Course Number</th><th>Title</th><th>Grade</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['CourseNumber']}</td>";
                    echo "<td>{$row['Title']}</td>";
                    echo "<td>{$row['Grade']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No courses found for the given student.</p>";
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "<p>Please enter a valid alphanumeric Campus Wide ID.</p>";
        }
    }
    ?>

</body>
</html>
