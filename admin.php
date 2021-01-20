<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Interface Reisekosten-DB</title>
</head>
<body>
    <h1>Admin-Interface Reisekosten-DB</h1>
    <ul>
        <li><a href="?view=seasons">Manage Saisonzeiten</a></li>
        <li><a href="?view=flats">Manage Wohnungspreise</a></li>
    </ul>
    <?php 
        include("sql-statements.php");
        
        if (isset($_GET["view"])) {
            if ($_GET["view"] == "seasons") {
                print_seasons(list_seasons());
            } else if ($_GET["view"] == "flats") {
                print_flat_prizes(list_flat_prizes());
            }
        }
        
        function print_seasons($seasons) {
            echo "<table>";
                echo "<tr>";
                    echo "<th>Saison</th>";
                    echo "<th>Von</th>";
                    echo "<th>Bis</th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($seasons)) {
                    echo "<tr>";
                    echo "<td>$row[1]</td>";
                    echo "<td>$row[2]</td>";
                    echo "<td>$row[3]</td>";
                    echo "</tr>";
                }
            echo "</table>";
        }

        function print_flat_prizes($flats) {
            echo "<table>";
                echo "<tr>";
                    echo "<th>Typ</th>";
                    echo "<th>Kategorie</th>";
                    echo "<th>Saison</th>";
                    echo "<th>Preis am ersten Tag</th>";
                    echo "<th>Preis je Folgetag</th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($flats)) {
                    echo "<tr>";
                    echo "<td>$row[2]</td>";
                    echo "<td>$row[3]</td>";
                    echo "<td>$row[1]</td>";
                    echo "<td>$row[4]</td>";
                    echo "<td>$row[5]</td>";
                    echo "</tr>";
                };
            echo "</table>";
        }
    ?>  
    <a href="home.php">Go Back 2 Home</a>
</body>
</html>