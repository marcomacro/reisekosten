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
        $typ = "";
        $kategory = "";

        if (isset($_GET["start"]) && isset($_GET["end"])) {
            
            $start_date = $_GET["start"];
            $end_date = $_GET["end"];

            $result = check_date($_GET["start"]);
            $season = mysqli_fetch_array($result)[1];

            $typ = $_GET["typ"];
            $kategory = $_GET["kategory"];
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
        Typ:
        <select name="typ">
            <option value="A"  <?php if ($typ=="A") echo "selected"?>>A</option>
            <option value="B"  <?php if ($typ=="B") echo "selected"?>>B</option>
            <option value="B2" <?php if ($typ=="B2") echo "selected"?>>B2</option>
            <option value="C"  <?php if ($typ=="C") echo "selected"?>>C</option>
            <option value="D"  <?php if ($typ=="D") echo "selected"?>>D</option>
            <option value="D1" <?php if ($typ=="D1") echo "selected"?>>D1</option>
        </select>
        <br>
        Kategorie:
        <select name="kategory">
            <option value="3" <?php if ($kategory=="3") echo "selected"?>>3 Sterne</option>
            <option value="4" <?php if ($kategory=="4") echo "selected"?>>4 Sterne</option>
            <option value="5" <?php if ($kategory=="5") echo "selected"?>>5 Sterne</option>
        </select>
        <br>
        <input type="submit" value="Zeitraum prüfen"></input>
    </form>

    <?php
        if ($season != "") {
            $number_of_days = calc_days($start_date, $end_date);
            $costs = calc_costs($season, $typ, $kategory, $number_of_days);

            echo "<p>";
            echo "Die Reisezeit beträgt ".$number_of_days." Tage.<br>";
            echo "Der Starttermin liegt in der $season.<br>";
            echo "Der gewählte Typ ist $typ.<br>";
            echo "Gewählt wurde die $kategory-Sterne-Kategorie.<br>";
            echo "Die Kosten der Reise betragen ".$costs." €.<br>";
            echo "</p>";
        }

        function calc_days($begin, $end) {
            $diff = date_diff(date_create($begin), date_create($end));
            return $diff->format('%a');
        }

        function calc_costs($season, $typ, $kategory, $days) {
            $result = query_prices($season, $typ, $kategory);
            $result = mysqli_fetch_array($result);

            $first_day_price = $result[0];
            $succeeding_day_price = $result[1];
            
            $price = $first_day_price + ($days-1) * $succeeding_day_price;
            return $price;
        }
    ?>

</body>
</html>