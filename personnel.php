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
                <h1 id="explore">Personnels</h1>
            </div>
            <div id="menue_div">
                <button class="button button_w button_s" onclick="location.href='create-personnel.php'">Create</button>
                <button class="button button_b button_s" onclick="location.href='delete-personnel.php'">Delete</button>
                <button class="button button_w button_s" onclick="location.href='update-personnel.php'">Update</button>
            </div>
            <div id="search_div">
                <form method="GET" action="critic.php">
                    <input class="button button_b button_s" type="submit" value="Search" name="SearchNameSubmit">
                    <input type="hidden" id="SearchNameQueryRequest" name="SearchNameQueryRequest">
                        <input class="search_bar" type="text" name="name_search" value="Search for personel name name">
                </form>

            </div>
            <div id="result_div">
                <table id="result_table">
                    <tr>
                        <th class="result_header">SIN</th>
                        <th class="result_header">Name</th> 
                        <th class="result_header">Debut Date</th>

                    </tr>
                    <?php
                    //TODO
                    //php code for the rows in the search
                    ?>
                </table>
            </div>  

        </div>

    
    </body>
    <?php
        //TODO
    ?>
</html>
