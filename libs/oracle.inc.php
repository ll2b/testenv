<?php
    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the Oracle database management system
        // NOTE: it is installed on localhost
        $link = oci_pconnect('HR', 'testpass', '//localhost/XE');
        if (!$link) {
            die(oci_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $stid = oci_parse($link, $query);
        if (!$stid) {
          $e = oci_error($link);
          die(htmlentities($e['message']));
        }

        $result = oci_execute($stid, OCI_DEFAULT);

        if (!$result) {
            print "<b>SQL error:</b> ". oci_error() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = oci_fetch_array($stid, OCI_ASSOC)) {
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