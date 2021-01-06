<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reisekostenrechner</title>
</head>
<body>
    <h1>Reisekostenrechner</h1>
    <?php
        include "sql-statements.php";

        $step = 1;
        $start_date = "2021-01-01";
        $end_date = "2021-12-31";
        $season = "";
        $typ = "";
        $category = "";

        if (isset($_GET["step"])) {
            $step = $_GET["step"];
        }
        if (isset($_GET["start"])) {
            $start_date = $_GET["start"];
            $season = mysqli_fetch_array(check_date($start_date))[1];
        }
        if (isset($_GET["end"])) {
            $end_date = $_GET["end"];
        }
        if (isset($_GET["typ"])) {
            $typ = $_GET["typ"];
        }
        if (isset($_GET["category"])) {
            $category = $_GET["category"];
        }

        if ($step==1) ask_start_date($start_date);
        if ($step==2) ask_end_date($start_date, $season);
        if ($step==3) ask_typ($start_date, $end_date, $season);
        if ($step==4) ask_category($start_date, $end_date, $season, $typ);
        if ($step==5) print_results($start_date, $end_date, $season, $typ, $category);
   
        function ask_start_date($start_date) {
            echo "
            <form action='kosten_1.php' method='GET'>
                Anreise-Datum:
                <input type='date' id='start' name='start' value=$start_date min='2020-12-26' max ='2022-01-02'></input>
                ";
                // transport gathered data
                echo "
                <input type='hidden' name='step' value='2'>
                <input type='submit' value='Weiter'></input>
            </form>
            <p>
                <a href='home.php'>Go Back 2 Home</a>
            </p>
            ";
        }

        function ask_end_date($start_date, $season) {
            // display gathered data
            echo "
            <p>
            Anreise-Tag ist ".date_format_de($start_date).".<br>
            Die Reise fällt (nach Anreisetag) in die $season.
            </p>
            ";
            // increasing $start_date by one day
            $start = new DateTime($start_date);
            $start->add(new DateInterval('P1D'));
            $next_day = $start->format('Y-m-d');
            // ask next data point
            echo "
            <form action='kosten_1.php' method='GET'>
                Abreise-Datum:
                <input type='date' id='end' name='end' value=$next_day min=$next_day max ='2022-01-02'></input>
                ";
                // transport gathered data
                echo "
                <input type='hidden' name='step' value='3'>
                <input type='hidden' name='start' value=$start_date>
                <input type='submit' value='Weiter'></input>
            </form>
            <p>
                <a href='home.php'>Go Back 2 Home</a>
            </p>
            ";
        }

        function ask_typ($start_date, $end_date, $season) {
            $days = days_format(calc_days($start_date, $end_date));
            // display gathered data
            echo "
            <p>
                Anreise-Tag ist ".date_format_de($start_date).".<br>
                Abreise-Tag ist ".date_format_de($end_date).".<br>
                Die Reisedauer beträgt $days.<br>
                Die Reise fällt (nach Anreisetag) in die $season.
            </p>
            ";

            // ask next data point
            echo "
            <form action='kosten_1.php' method='GET'>
                Appartement-Typ:
                <select name='typ'>
                    <option value='A' >A</option>
                    <option value='B' >B</option>
                    <option value='B2'>B2</option>
                    <option value='C' >C</option>
                    <option value='D' >D</option>
                    <option value='D1' selected>D1</option>
                </select>
                ";
                // transport gathered data
                echo "
                <input type='hidden' name='step' value='4'>
                <input type='hidden' name='start' value=$start_date>
                <input type='hidden' name='end' value=$end_date>
                <input type='submit' value='Weiter'></input>
            </form>
            <p>
                <a href='home.php'>Go Back 2 Home</a>
            </p>
            ";
        }

        function ask_category($start_date, $end_date, $season, $typ) {
            $days = days_format(calc_days($start_date, $end_date));
            // display gathered data
            echo "
            <p>
                Anreise-Tag ist ".date_format_de($start_date).".<br>
                Abreise-Tag ist ".date_format_de($end_date).".<br>
                Die Reisedauer beträgt $days.<br>
                Die Reise fällt (nach Anreisetag) in die $season.
            </p>
            <p>
                Gewählter Appartement-Typ: $typ.
            </p>
            ";

            // ask next data point
            echo "
            <form action='kosten_1.php' method='GET'>
                Kategorie:
                <select name='category'>
                    <option value='3'>***</option>
                    <option value='4'>****</option>
                    <option value='5' selected>5*</option>
                </select>
                ";
                // transport gathered data
                echo "
                <input type='hidden' name='step' value='5'>
                <input type='hidden' name='start' value=$start_date>
                <input type='hidden' name='end' value=$end_date>
                <input type='hidden' name='typ' value=$typ>
                <input type='submit' value='Weiter'></input>
            </form>
            <p>
                <a href='home.php'>Go Back 2 Home</a>
            </p>
            ";
        }

        function print_results($start_date, $end_date, $season, $typ, $category) {
            $number_of_days = calc_days($start_date, $end_date);
            $days = days_format($number_of_days);
            $costs = calc_costs($season, $typ, $category, $number_of_days);
             // display gathered data
             echo "
             <p>
                 Anreise-Tag ist der $start_date.<br>
                 Abreise-Tag ist der $end_date.<br>
                 Die Reisedauer beträgt ".$days.".<br>
                 Die Reise fällt (nach Anreisetag) in die $season.
             </p>
             <p>
                 Gewählter Appartement-Typ: $typ.<br>
                 Gewählte Kategorie: $category-Sterne.<br>
                 Die Kosten der Reise betragen ".$costs." €.
             </p>
             <p>
                <a href='kosten_1.php'>Go Back 2 Start</a><br>
                <a href='home.php'>Go Back 2 Home</a>
             </p>
             ";
        }

        // helper function
        function calc_days($begin, $end) {
            $diff = date_diff(date_create($begin), date_create($end));
            return $diff->format('%a');
        }

        // helper function
        function calc_costs($season, $typ, $category, $days) {
            $result = query_prices($season, $typ, $category);
            $result = mysqli_fetch_array($result);

            $first_day_price = $result[0];
            $succeeding_day_price = $result[1];
            
            $price = $first_day_price + ($days-1) * $succeeding_day_price;
            return number_format($price, 2, ",", ".");
        }

        // helper function
        // is probably OS-dependent (WIN)
        function date_format_de($date) {
            setlocale(LC_TIME, 'DE');
            $time = strtotime($date);
            return strftime('%a, %d. %B %Y', $time); 
        }

        // helper function
        function days_format($days) {
            if ($days > 1) $suffix ="e"; else $suffix = "";
            return $days." Tag".$suffix;
        }
    ?>

</body>
</html>