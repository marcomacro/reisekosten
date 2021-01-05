<?php

    // fire a sql-query
    function query_reiseDB($sql) {
        $server = "localhost";
        $user = "root";
        $password = "";
        $dbname = "reise";

        $conn = mysqli_connect($server, $user, $password, $dbname);
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    // fill the db with season datas from the task 'Reisekosten - Teil 1.pdf'
    function fill_season_data_set() {
        // mySQL date format: JJJJ-MM-DD
        $sql = 
        "INSERT INTO saisonzeiten (saison, von, bis)
        VALUES 
        ('NEBENSAISON', '2021-01-09', '2021-01-30'),
        ('NEBENSAISON', '2021-02-20', '2021-03-27'),
        ('NEBENSAISON', '2021-04-10', '2021-05-15'),
        ('NEBENSAISON', '2021-09-11', '2021-10-09'),
        ('NEBENSAISON', '2021-11-06', '2021-12-26'),
        ('ZWISCHENSAISON', '2021-01-30', '2021-02-20'),
        ('ZWISCHENSAISON', '2021-03-27', '2021-04-10'),
        ('ZWISCHENSAISON', '2021-05-15', '2021-06-26'),
        ('ZWISCHENSAISON', '2021-08-28', '2021-09-11'),
        ('ZWISCHENSAISON', '2021-10-09', '2021-11-06'),
        ('HAUPTSAISON', '2021-01-02', '2021-01-09'),
        ('HAUPTSAISON', '2021-06-26', '2021-08-28'),
        ('SYLVESTERPAUSCHALE', '2020-12-26', '2021-01-02'),
        ('SYLVESTERPAUSCHALE', '2021-12-26', '2022-01-02');";

        query_reiseDB($sql);
    }

    // returns the corresponding season to a date
    function check_date($date) {
        $sql = "SELECT * FROM `saisonzeiten` WHERE von < '$date' AND bis >= '$date';";
        return query_reiseDB($sql);
    }

    // query all registered seasons
    function list_seasons() {
        $sql = "SELECT * FROM `saisonzeiten`;";
        return query_reiseDB($sql);
    }
    
    // fill the db with flat-datas from the task 'Reisekosten - Teil 2.pdf'
    function fill_flats_data_set() {
        $sql = 
        "INSERT INTO wohnungspreise (saison, typ, kategorie, erstTag, folgeTag)
        VALUES
        ('NEBENSAISON', 'A', 3, 77.00, 37.00),
        ('NEBENSAISON', 'A', 4, 79.00, 39.00),
        ('NEBENSAISON', 'A', 5, 82.00, 42.00),
        
        ('ZWISCHENSAISON', 'A', 3, 82.00, 42.00),
        ('ZWISCHENSAISON', 'A', 4, 87.00, 47.00),
        ('ZWISCHENSAISON', 'A', 5, 92.00, 52.00),
        
        ('HAUPTSAISON', 'A', 3, 86.00, 46.00),
        ('HAUPTSAISON', 'A', 4, 92.00, 52.00),
        ('HAUPTSAISON', 'A', 5, 97.00, 57.00),
        
        ('NEBENSAISON', 'B', 3, 102.00, 47.00),
        ('NEBENSAISON', 'B', 4, 107.00, 52.00),
        ('NEBENSAISON', 'B', 5, 110.00, 55.00),
        
        ('ZWISCHENSAISON', 'B', 3, 111.00, 56.00),
        ('ZWISCHENSAISON', 'B', 4, 119.00, 64.00),
        ('ZWISCHENSAISON', 'B', 5, 124.00, 69.00),
        
        ('HAUPTSAISON', 'B', 3, 119.00, 64.00),
        ('HAUPTSAISON', 'B', 4, 129.00, 74.00),
        ('HAUPTSAISON', 'B', 5, 134.00, 79.00),
        
        ('NEBENSAISON', 'B2', 4, 117.00, 62.00),
        ('ZWISCHENSAISON', 'B2', 4, 130.00, 75.00),
        ('HAUPTSAISON', 'B2', 4, 140.00, 85.00),
        
        ('NEBENSAISON', 'C', 3, 131.00, 61.00),
        ('NEBENSAISON', 'C', 4, 137.00, 67.00),
        ('NEBENSAISON', 'C', 5, 139.00, 69.00),
        
        ('ZWISCHENSAISON', 'C', 3, 142.00, 72.00),
        ('ZWISCHENSAISON', 'C', 4, 150.00, 80.00),
        ('ZWISCHENSAISON', 'C', 5, 159.00, 89.00),
        
        ('HAUPTSAISON', 'C', 3, 155.00, 85.00),
        ('HAUPTSAISON', 'C', 4, 167.00, 97.00),
        ('HAUPTSAISON', 'C', 5, 179.00, 109.00),
        
        ('NEBENSAISON', 'D', 5, 195.00, 105.00),
        ('ZWISCHENSAISON', 'D', 5, 200.00, 110.00),
        ('HAUPTSAISON', 'D', 5, 229.00, 139.00),
        
        ('NEBENSAISON', 'D1', 4, 147.00, 67.00),
        ('ZWISCHENSAISON', 'D1', 4, 160.00, 80.00),
        ('HAUPTSAISON', 'D1', 4, 177.00, 97.00);";

        query_reiseDB($sql);
        echo "Tabelle 'wohnungspreise' gefüllt";
    }

    function query_prices($season, $typ, $kategory) {
        $sql = "SELECT erstTag, folgeTag
        FROM wohnungspreise
        WHERE saison='$season' AND typ='$typ' AND kategorie='$kategory'";
        return query_reiseDB($sql);
    }

    // !!! SINGLE USE CALL
    // fill_flats_data_set();
    
?>