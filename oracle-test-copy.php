<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values

  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->

<html>
<title>Explore Production</title>
        <link rel="stylesheet" href="index.css">
    </head>

    <body>
    <body>
        <div class="title_div" onclick="location.href='index.php'">
            <h1 class="page_header">Explore Production</h1>
        </div>
        <div id ="main_div">
            <div id= "explore_div">
                <h1 id="explore">Group By</h1>
            </div>

        <h2>(join) Join Production, Critic, and Reviews</h2>
        <form method="GET" action="oracle-test-copy.php">
            <input type="hidden" id="joinRequest" name="joinRequest">
            Where: <input type="text" name="whereClause" id = "whereClause" > <br /><br />
            <input type="submit" name="join"></p>
        </form>

        <hr />

        <h2>(division) Find the Personnel who worked in every production</h2>
        <form method="GET" action="oracle-test-copy.php">
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            <input type="submit" name="division"></p>
        </form>

        <hr />

        <h2>(nested) Find the number of Productions for each rating that is above the average Production rating</h2>
        <form method="GET" action="oracle-test-copy.php">
            <input type="hidden" id="nestedRequest" name="nestedRequest">
            <input type="submit" name="nested"></p>
        </form>

        <hr />


        <h2>(projection) Select Production name, prid, and rating </h2>
        <form method="GET" action="oracle-test-copy.php">
            <input type="hidden" id="selectRequest" name="selectRequest">
            <input type="submit" name="select"></p>
        </form>

        <hr />

        <h2>(group by having)Movies Who Have Ratings Higher Than Average Ratings for Movie For Critic Reviews and User Reviews</h2>
        <form method="POST" action="oracle-test-copy.php">
            <input type="hidden" id="groupByHavingRequest" name="groupByHavingRequest">
            <label for="Ranking">Choose a ranking:</label>
            <select name="ranking" id="ranking">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                 <option value="4">4</option>
                 <option value="5">5</option>
                <option value="6">6</option>
                 <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                 <option value="10">10</option>
            </select>
            <br><br>
            <input type="submit" name="groupByHaving"></p>
        </form>

        <hr />

        <h2>(group by)Display the How Many Productions Per Genre</h2>
        <form method="GET" action="oracle-test-copy.php"> <!--refresh page when submitted-->
            <input type="hidden" id="groupByRequest" name="groupByRequest">
            <input type="submit" name="groupBy"></p>
        </form>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

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
            echo "<br>printResult<br>";
            echo "<table>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr class='result_header'><td>" . $row[0] . "<tr><td>";
            }

            echo "</table>";
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

        function handleGroupByRequest() {
            global $db_conn;
  
            $result = executePlainSQL("SELECT Count(*), production.genre FROM production GROUP BY production.genre");
  
            echo "<table>";
            echo "<tr><th>COUNT</th><th>GENRE</th></tr>";
  
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
                echo "<tr><td>" . $row[0] . "</td><td>" . $row["GENRE"] . "</td></tr>";
            
            }
  
            echo "</table>";
          }

        function handleGroupByHavingRequest() {
            global $db_conn;

            $selectOption = $_POST['ranking'];

            $result = executePlainSQL("WITH T as (SELECT reviews.prid, reviews.rating
                                        FROM reviews
                                        UNION
                                        SELECT production.prid, production.rating
                                        FROM production)
                            SELECT pr.name
                            FROM production pr
                            WHERE pr.prid IN (SELECT T.prid FROM T GROUP BY T.prid HAVING AVG(T.rating) >= '". $selectOption . "')");


            OCICommit($db_conn);

            echo "<table>";
            echo "<tr class='result_header'><th>NAME</th><tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
                echo "<tr class='result_header'><td>" . $row[0] . "</td><tr>";

            }

            echo "</table>";

        }

        function handleNestedRequest() {
            global $db_conn;

            $sql = "SELECT p1.name, p1.rating
            FROM production p1
            WHERE p1.rating > (SELECT AVG(p2.rating)
                                     FROM production p2)";

           $sql = "SELECT p1.rating,COUNT(p1.rating)
           FROM production p1
           GROUP BY p1.rating
           HAVING p1.rating > (SELECT AVG(p2.rating)
                                    FROM production p2)";

            echo $sql;

            $result = executePlainSQL($sql);

            echo "<br> <br>" ;

            echo "<table>";
            echo "<tr class='result_header'>
                    <th>RATING</th>
                    <th> # of PRODUCTIONS</th>

                  </tr>";

              while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                  echo "<tr class='result_header'>";
                  for ($x = 0; $x < 2; $x++) {
                    echo "<td>";
                    echo $row[$x];
                    echo " ";
                    echo "</td>";
                  }
                  echo "<tr>";
              }

              echo "</table>";

        }

        function handleSelectRequest() {
            global $db_conn;

            $sql = "SELECT production.name, production.prid, production.rating
            FROM production";

            echo $sql;

            $result = executePlainSQL($sql);

            echo "<br> <br>" ;

            echo "<table>";
            echo "<tr class='result_header'>
                    <th>Name</th>
                    <th>PRID</th>
                    <th>Rating</th>
                  </tr>";

              while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                  // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
                  echo "<tr class='result_header'>";
                  for ($x = 0; $x < 3; $x++) {
                    echo "<td>";
                    echo $row[$x];
                    echo " ";
                    echo "</td>";
                  }
                  echo "<tr>";
              }
        }

        function handleJoinRequest() {
            global $db_conn;

            $where = $_GET['whereClause'];
            $and = " and ";

            $sql = "SELECT production.prid, critic.cid, production.name, critic.name, reviews.rating
            FROM production, critic, reviews
            WHERE production.prid = reviews.prid and
                  critic.cid = reviews.cid";

            if (!empty($where)) {
               $sql = $sql.$and.$where;
            }

            echo $sql;

            $result = executePlainSQL($sql);

            echo "<br> <br>" ;

            echo "<table>";
            echo "<tr class='result_header'>
                    <th>PRID</th>
                    <th>CID</th>
                    <th>Production Name</th>
                    <th>Critic Name</th>
                    <th>Rating</th>
                  </tr>";

              while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                  // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
                  echo "<tr class='result_header'>";
                  for ($x = 0; $x < 5; $x++) {
                    echo "<td>";
                    echo $row[$x];
                    echo " ";
                    echo "</td>";
                  }
                  echo "<tr>";
              }

              echo "</table>";
            }

            function handleDivisionRequest() {
                global $db_conn;
   
                // $sql = "WITH p_table AS
                //           (SELECT name as
                //           FROM personnel)
                //         SELECT t.name
                //         FROM p_table t";
                $sql = "SELECT per.name
                        FROM personnel per
                        WHERE NOT EXISTS (
                                  (SELECT prod.prid
                                  FROM production prod)
                                  MINUS
                                  (SELECT work.prid
                                  FROM workedin work
                                  WHERE work.sinumber = per.sinumber))";
   
                echo $sql;
   
                $result = executePlainSQL($sql);
   
                echo "<br> <br>" ;
   
                echo "<table>";
                echo "<tr class='result_header'>
                        <th>Name</th>
                      </tr>";
   
                  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                      // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
                      echo "<tr class='result_header'>";
                      for ($x = 0; $x < 1; $x++) {
                        echo "<td>";
                        echo $row[$x];
                        echo " ";
                        echo "</td>";
                      }
                      echo "<tr>";
                  }
   
                  echo "</table>";
              }


        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('groupByHavingRequest', $_POST)) {
                    handleGroupByHavingRequest();
                }
                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('nested', $_GET)) {
                    handleNestedRequest();
                } else if (array_key_exists('join', $_GET)) {
                    handleJoinRequest();
                } else if (array_key_exists('select', $_GET)) {
                    handleSelectRequest();
                } else if (array_key_exists('groupBy', $_GET)) {
                    handleGroupByRequest();
                } else if (array_key_exists('division', $_GET)) {
                    handleDivisionRequest();
                }

                disconnectFromDB();
            }
        }

        if (isset($_POST['groupByHaving'])) {
            handlePOSTRequest();
        } else if (isset($_GET['nestedRequest']) || isset($_GET['joinRequest'])
        || isset($_GET['selectRequest']) || isset($_GET['groupByRequest'])
        || isset($_GET['groupByRequest']) || isset($_GET['divisionRequest'])) {
            handleGETRequest();
        }
		?>
        </div>
	</body>
</html>
