<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reisekostenrechner</title>
    <?php 
        include "sql-statements.php";

        $start_date = "2021-01-01";
        $end_date = "2021-12-31";
        $season = "";

        if (isset($_GET["start"]) && isset($_GET["end"])) {
            
            $start_date = $_GET["start"];
            $end_date = $_GET["end"];

            $result = check_date($_GET["start"]);
            $season = mysqli_fetch_array($result)[1];
        }
    ?>
</head>
<body>
    <h1>Reisekostenrechner</h1>
    <form action="kosten.php" method="GET">
        Beginn:
        <input type="date" id="start" name="start" value=<?php echo $start_date ?> min="2020-12-26" max ="2022-01-02"></input>
        <br>
        Ende:
        <input type="date" id="end" name="end" value=<?php echo $end_date ?> min="2020-12-26" max ="2022-01-02"></input>
        <br>
        <input type="submit" value="Zeitraum prüfen"></input>
    </form>

    <?php
        if ($season != "") {
            echo "Der Starttermin liegt in der $season.";
        }
    ?>

</body>
</html>