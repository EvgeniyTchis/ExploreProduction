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
                <h1 id="explore">Critics</h1>
            </div>
            <div id="menue_div">
                <button class="button button_w button_s" onclick="location.href='create-critic.php'">Create</button>
                <button class="button button_b button_s" onclick="location.href='delete-critic.php'">Delete</button>
                <button class="button button_w button_s" onclick="location.href='update-critic.php'">Update</button>
            </div>
            <div id="search_div">
                <form method="GET" action="critic.php">
                    <input class="button button_b button_s" type="submit" value="Search" name="SearchNameSubmit">
                    <input type="hidden" id="SearchNameQueryRequest" name="SearchNameQueryRequest">
                        <input class="search_bar" type="text" name="name_search" value="Search for Critic name">
                </form>

            </div>
            <div id="result_div">
                <table id="result_table">
                    <tr>
                        <th class="result_header">CID</th>
                        <th class="result_header">Name</th> 
                        <th class="result_header">Affiliaton</th>

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
