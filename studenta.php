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
    <h1>Student A</h1>
    <h3>Given a course number, list the sections of the course, including classrooms, meeting days and time, and the number of students enrolled in each section.</h3>

    <br><br>

    <h2>Sample Input:</h2>
    <h4>3</h4>
    <h4>4</h4>
    <h4>7</h4>
    
    <br><br><br>

    <form method="post" action="">
        <label for="courseNumber">Enter Course Number:</label>
        <input type="text" name="courseNumber" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the entered Course Number
        $courseNumber = $_POST['courseNumber'];

        // Validate the input
        if (is_numeric($courseNumber)) {
            // Connect to the database
            include 'includes/db_connection.php';

            // Prepare and execute the query
            $query = "SELECT Sections.SectionNumber, Sections.Classroom, Sections.MeetingDays, Sections.BeginningTime, Sections.EndingTime, COUNT(*) AS StudentsEnrolled
                      FROM Sections
                      LEFT JOIN EnrollmentRecords ON Sections.SectionNumber = EnrollmentRecords.CourseSectionNumber
                      WHERE Sections.CourseNumber = '$courseNumber'
                      GROUP BY Sections.SectionNumber";

            $result = $conn->query($query);

            // Display the results
            if ($result->num_rows > 0) {
                echo "<br><h2>Sections for Course $courseNumber</h2>";
                echo "<table>";
                echo "<tr><th>Section Number</th><th>Classroom</th><th>Meeting Days</th><th>Time</th><th>Students Enrolled</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['SectionNumber']}</td>";
                    echo "<td>{$row['Classroom']}</td>";
                    echo "<td>{$row['MeetingDays']}</td>";
                    echo "<td>{$row['BeginningTime']} - {$row['EndingTime']}</td>";
                    echo "<td>{$row['StudentsEnrolled']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No sections found for the given course.</p>";
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "<p>Please enter a valid numeric value for Course Number.</p>";
        }
    }
    ?>

</body>
</html>
