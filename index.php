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

    <br><br><br>

    <h1>Welcome to the University Database Application</h1>
    <h3>by:<br><br>
    Nicholas Goulart<br>
    Theo Gonong<br>
    Carlos Hernandez</h3>

    <br><br><br><br><br><br><br>

    <h3>Our Database Includes:</h3>

    <table>

        <tr>
            <td>200 Students</td>
            <td>9 Departments</td>
            <td>10 Professors</td>
        </tr>
        <tr>
            <td>8 Courses</td>
            <td>19 Sections</td>
            <td>200 Enrollment Records</td>
        </tr>
    </table>


    <?php include 'includes/db_connection.php';?>


</body>
</html>