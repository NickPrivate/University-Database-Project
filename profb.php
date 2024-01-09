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
    <h1>Professor B</h1>
    <h3>Given a course number and a section number, count how many students get each distinct grade.</h3>

    <br><br>

    <h2>Sample Input:</h2>
    <h4>4, 1</h4>
    <h4>3, 2</h4>
    <h4>5, 6</h4>
    
    <br><br><br>

    <form method="post" action="">
        <label for="courseNumber">Enter Course Number:</label>
        <input type="text" name="courseNumber" required>
        <label for="sectionNumber">Enter Section Number:</label>
        <input type="text" name="sectionNumber" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the entered Course Number and Section Number
        $courseNumber = $_POST['courseNumber'];
        $sectionNumber = $_POST['sectionNumber'];

        // Validate the input
        if (is_numeric($courseNumber) && is_numeric($sectionNumber)) {
            // Connect to the database
            include 'includes/db_connection.php';

            // Prepare and execute the query
            $query = "SELECT Grade, COUNT(*) AS StudentsCount
                    FROM EnrollmentRecords
                    WHERE CourseSectionNumber = '$courseNumber-$sectionNumber'
                    GROUP BY Grade";

            $result = $conn->query($query);

            // Display the results
            if ($result->num_rows > 0) {
                echo "<br><h2>Grades Count for Course $courseNumber, Section $sectionNumber</h2>";
                echo "<table>";
                echo "<tr><th>Grade</th><th>Count</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['Grade']}</td>";
                    echo "<td>{$row['StudentsCount']}</td>"; 
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No grades found for the given course and section.</p>";
            }


    }  
}
        

    ?>

</body>
</html>