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

    // fill the db with datas from the task 'Reisekosten - Teil 1.pdf'
    function fill_basic_data_set() {
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

        return query_reiseDB($sql);
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
    
    function test_wohnungspreise() {
        $sql = 
        "INSERT INTO saisonzeiten (saison, von, bis)
        VALUES 
        ('NEBENSAISON', '2021-01-09', '2021-01-30');";

        return query_reiseDB($sql);
    }
?>