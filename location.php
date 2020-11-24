<html>
    <head>
        <title>Explore Production</title>
        <link rel="stylesheet" href="index.css">
    </head>

    <body>
        <div class="title_div" onclick="location.href='index.php'">
            <h1 class="page_header">Explore Production</h1>
        </div>
        <div id ="main_div">
            <div id= "explore_div">
                <h1 id="explore">Locations</h1>
            </div>
            <div id="menue_div">
                <button class="button button_w button_s" onclick="location.href='create-location.php'">Create</button>
                <button class="button button_b button_s" onclick="location.href='delete-location.php'">Delete</button>
                <button class="button button_w button_s" onclick="location.href='update-location.php'">Update</button>
            </div>
            <div id="search_div">
                <form method="GET" action="location.php">
                    <input class="button button_b button_s" type="submit" value="Search" name="SearchNameSubmit">
                    <input type="hidden" id="SearchNameQueryRequest" name="SearchNameQueryRequest">
                        <input class="search_bar" type="text" name="name_search" value="Search for Location country">
                </form>

            </div>
            <div id="result_div">
                <table id="result_table">
                    <tr>
                        <th class="result_header">City</th>
                        <th class="result_header">Postal Code</th> 
                        <th class="result_header">Country</th>

                    </tr>
                    <?php
                     $success = True; //keep track of errors so it redirects the page only if there are no errors
                     $db_conn = NULL; // edit the login credentials in connectToDB()
                     $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())
             
                     function debugAlertMessage($message) {
                         global $show_debug_alert_messages;
             
                         if ($show_debug_alert_messages) {
                             echo "<script type='text/javascript'>alert('" . $message . "');</script>";
                         }
                     }
                     function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
                        //echo "<br>running ".$cmdstr."<br>";
                        global $db_conn, $success;
            
                        $statement = OCIParse($db_conn, $cmdstr); 
                        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work
            
                        if (!$statement) {
                            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                            echo htmlentities($e['message']);
                            $success = False;
                        }
            
                        $r = OCIExecute($statement, OCI_DEFAULT);
                        if (!$r) {
                            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                            echo htmlentities($e['message']);
                            $success = False;
                        }
            
                        return $statement;
                    }

                    function printResult($result) { //prints results from a select statement        
                        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                            echo "<tr class='result_header'><td>" . $row["CITY"] . "</td><td>" . $row["POSTALCODE"] . "</td><td>" . $row["COUNTRY"] . "</td></tr>"; //or just use "echo $row[0]" 
                        }
                    }
                    function connectToDB() {
                        global $db_conn;
            
                        // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
                        // ora_platypus is the username and a12345678 is the password.
                        $db_conn = OCILogon("ora_willjvan", "a71341747", "dbhost.students.cs.ubc.ca:1522/stu");
            
                        if ($db_conn) {
                            debugAlertMessage("Database is Connected");
                            return true;
                        } else {
                            debugAlertMessage("Cannot connect to Database");
                            $e = OCI_Error(); // For OCILogon errors pass no handle
                            echo htmlentities($e['message']);
                            return false;
                        }
                    }

                    function disconnectFromDB() {
                        global $db_conn;
            
                        debugAlertMessage("Disconnect from Database");
                        OCILogoff($db_conn);
                    }
                    function handleNameSearchRequest() {
                        global $db_conn;
                        
                        $name = $_GET['name_search'];
                        $result = executePlainSQL("SELECT * FROM location_ WHERE LOWER(COUNTRY) LIKE LOWER('%$name%')");
                        
                        printResult($result);
                    }

                            // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('SearchNameSubmit', $_GET)) {
                    handleNameSearchRequest();
                }
                else if (array_key_exists('displayTuples', $_GET)) {
                    handleDisplayRequest();
                }

                disconnectFromDB();
            }
        }
		if (isset($_POST['a'])) {
            handlePOSTRequest();
        } else if (isset($_GET['SearchNameQueryRequest'])) {
            handleGETRequest();
        }

                    ?>
                </table>
            </div>  

        </div>

    
    </body>
    <?php
        //TODO
    ?>
</html>
