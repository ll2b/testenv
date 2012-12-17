<?php
    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the PostgreSQL database management system
        // NOTE: it is installed on localhost
        $link = pg_pconnect("host=localhost port=5432 dbname=testdb user=postgres password=testpass");
        if (!$link) {
            die(pg_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = pg_query($query);

        if (!$result) {
            print "<b>SQL error:</b> ". pg_error() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            print "<tr>";
            foreach ($line as $col_value) {
                print "<td>" . $col_value . "</td>";
            }
            print "</tr>\n";
        }

        print "</table>\n";
        print "</body></html>";
    }
?>