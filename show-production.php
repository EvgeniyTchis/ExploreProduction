<html>

<head>
    <title>Explore Production</title>
    <link rel="stylesheet" href="index.css">
</head>



<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = NULL; // edit the login credentials in connectToDB()
$show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

function debugAlertMessage($message)
{
    global $show_debug_alert_messages;

    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}
function executePlainSQL($cmdstr)
{ //takes a plain (no bound variables) SQL command and executes it
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

function printResult($result)
{
    echo '<table id="result_table">';
    echo '<tr>';
    echo     '<th class="result_header">PRID</th>';
    echo     '<th class="result_header">Name</th> ';
    echo     '<th class="result_header">Genre</th>';
    echo     '<th class="result_header">rating</th>';
    echo '</tr>  ';
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr class='result_header' onclick='window.location=\"show-production.php?prid=" . $row["PRID"] . "\";'><td>" . $row["PRID"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["RATING"] . "</td></tr>"; //or just use "echo $row[0]" 
    }
    echo '</tables>';
}
function printGenreResult($result)
{
    echo '<table id="result_table">';
    echo '<tr>';
    echo     '<th class="result_header">PRID</th>';
    echo     '<th class="result_header">Name</th> ';
    echo     '<th class="result_header">rating</th>';
    echo '</tr>  ';
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr class='result_header'><td>" . $row["PRID"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["RATING"] . "</td></tr>"; //or just use "echo $row[0]" 
    }
    echo '</tables>';
}
function connectToDB()
{
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

function disconnectFromDB()
{
    global $db_conn;

    debugAlertMessage("Disconnect from Database");
    OCILogoff($db_conn);
}
function handleNameSearchRequest()
{
    global $db_conn;

    $name = $_GET['name_search'];
    $result = executePlainSQL("SELECT * FROM production WHERE LOWER(NAME) LIKE LOWER('%$name%')");

    printResult($result);
}
function handleGenreSearchRequest()
{
    global $db_conn;
    $genre = $_GET['genre_search'];
    $result = executePlainSQL("SELECT PRID, NAME, RATING FROM production WHERE LOWER(GENRE)=LOWER('$genre')");

    printGenreResult($result);
}

// HANDLE ALL POST ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handlePOSTRequest()
{
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
function handleGETRequest()
{
    if (connectToDB()) {
        if (array_key_exists('SearchNameSubmit', $_GET)) {
            handleNameSearchRequest();
        } else if (array_key_exists('SearchGenreSubmit', $_GET)) {
            handleGenreSearchRequest();
        }

        disconnectFromDB();
    }
}
if (isset($_POST['a'])) {
    handlePOSTRequest();
} else if (isset($_GET['SearchNameQueryRequest']) || isset($_GET['SearchGenreQueryRequest'])) {
    handleGETRequest();
}

connectToDB();
$prid = $_GET['prid'];
$result = executePlainSQL("SELECT NAME FROM production WHERE PRID=$prid");
$row = OCI_Fetch_Array($result, OCI_BOTH);
echo '<body>';
echo '<div class="title_div" onclick="location.href=\'index.php\'">';
echo    '<h1 class="page_header">Explore Production</h1>';
echo '</div>';
echo '<div id ="main_div">';
echo    '<div id= "explore_div">';
echo         '<h1 id="explore">' . $row[0] . '</h1>';
echo     '</div>';
echo '</div>';
echo '<div id="menue_div">';
$row = OCI_Fetch_Array($result, OCI_BOTH);


$result = executePlainSQL("SELECT POSTALCODE, CITY, PERMITID FROM filmlocation WHERE PRID=$prid");
echo '<table id="result_table">';
echo '<div id="explore_div">';
echo '<h1 id="explore">Filmed Locations</h1>';
echo '</div>';
echo '<tr>';
echo     '<th class="result_header">City</th>';
echo     '<th class="result_header">PostalCode</th> ';
echo     '<th class="result_header">permit</th>';
echo '</tr>  ';
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr class='result_header'><td>" . $row["CITY"] . "</td><td>" . $row["POSTALCODE"] . "</td><td>" . $row["PERMITID"] . "</td></tr>"; //or just use "echo $row[0]" 
}
echo '</tables>';
echo '</div>';




$result = executePlainSQL("SELECT SINUMBER, OCCUPATION FROM workedin WHERE PRID=$prid");
echo '<table id="result_table">';
echo '<div>';
echo '<div id="explore_div">';
echo '<h1 id="explore">People On set</h1>';
echo '</div>';
echo '<tr>';
echo     '<th class="result_header">SIN</th>';
echo     '<th class="result_header">OCCUPATION</th> ';

echo '</tr>  ';
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr class='result_header'><td>" . $row["SINUMBER"] . "</td><td>" . $row["OCCUPATION"] . "</td></tr>"; //or just use "echo $row[0]" 
}
echo '</tables>';
echo '</div>';


$result = executePlainSQL("SELECT DID FROM distributes WHERE PRID=$prid");
echo '<table id="result_table">';
echo '<div>';
echo '<div id="explore_div">';
echo '<h1 id="explore">Distributors</h1>';
echo '</div>';
echo '<tr>';
echo     '<th class="result_header">DID</th>';

echo '</tr>  ';
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr class='result_header'><td>" . $row["DID"] . "</td></tr>"; //or just use "echo $row[0]" 
}
echo '</tables>';
echo '</div>';

$result = executePlainSQL("SELECT CID, RATING FROM reviews WHERE PRID=$prid");
echo '<table id="result_table">';
echo '<div>';
echo '<div id="explore_div">';
echo '<h1 id="explore">Reviews</h1>';
echo '</div>';
echo '<tr>';
echo     '<th class="result_header">CID</th>';
echo     '<th class="result_header">Rated</th> ';

echo '</tr>  ';
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr class='result_header'><td>" . $row["CID"] . "</td><td>" . $row["RATING"] . "</td></tr>"; //or just use "echo $row[0]" 
}
echo '</tables>';
echo '</div>';

$result = executePlainSQL("SELECT SID, PRODUCT FROM sponsored WHERE PRID=$prid");
echo '<table id="result_table">';
echo '<div>';
echo '<div id="explore_div">';
echo '<h1 id="explore">Sponsorships</h1>';
echo '</div>';
echo '<tr>';
echo     '<th class="result_header">SID</th>';
echo     '<th class="result_header">Product</th> ';

echo '</tr>  ';
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr class='result_header'><td>" . $row["SID"] . "</td><td>" . $row["PRODUCT"] . "</td></tr>"; //or just use "echo $row[0]" 
}
echo '</tables>';
echo '</div>';

$result = executePlainSQL("SELECT AID, TITLE, YEAR FROM awardRcvd WHERE PID=$prid");
echo '<table id="result_table">';
echo '<div id="explore_div">';
echo '<h1 id="explore">Awards</h1>';
echo '</div>';
echo '<tr>';
echo     '<th class="result_header">aid</th>';
echo     '<th class="result_header">title</th> ';
echo     '<th class="result_header">name</th>';
echo '</tr>  ';
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr class='result_header'><td>" . $row["AID"] . "</td><td>" . $row["TITLE"] . "</td><td>" . $row["YEAR"] . "</td></tr>"; //or just use "echo $row[0]" 
}

echo '</tables>';
echo '</div>';

$result = executePlainSQL("SELECT FID, CONTRACTID FROM created WHERE PRID=$prid");
echo '<table id="result_table">';
echo '<div>';
echo '<div id="explore_div">';
echo '<h1 id="explore">Film Studio</h1>';
echo '</div>';
echo '<tr>';
echo     '<th class="result_header">SID</th>';
echo     '<th class="result_header">Name</th> ';

echo '</tr>  ';
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr class='result_header'><td>" . $row["FID"] . "</td><td>" . $row["CONTRACTID"] . "</td></tr>"; //or just use "echo $row[0]" 
}
echo '</tables>';
echo '</div>';

disconnectFromDB();





?>
</div>

</body>

</html>