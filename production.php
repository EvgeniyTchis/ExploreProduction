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
                <h1 id="explore">Productions</h1>
            </div>
            <div id="menue_div">
                <button class="button button_w button_s" onclick="location.href='create-production.php'">Create</button>
                <button class="button button_b button_s" onclick="location.href='delete-production.php'">Delete</button>
                <button class="button button_w button_s" onclick="location.href='update-production.php'">Update</button>
            </div>
            <div id="search_div">
                <form method="GET" action="production.php">
                    <input class="button button_b button_s" type="submit" value="Search" name="SearchNameSubmit">
                    <input type="hidden" id="SearchNameQueryRequest" name="SearchNameQueryRequest">
                        <input class="search_bar" type="text" name="name_search" value="Search for title name">
                </form>
                <form method="GET" action="production.php">
                    <input class="button button_b button_s" type="submit" value="Search" name="SearchGenreSubmit">
                    <input type="hidden" id="SearchGenreQueryRequest" name="SearchGenreQueryRequest">
                        <input class="search_bar" type="text" name="genre_search" value="Search Productions by genre">
                </form>
            </div>
            <div id="result_div">
                <table id="result_table">
                    <tr>
                        <th class="result_header">ID</th>
                        <th class="result_header">Name</th> 
                        <th class="result_header">Genre</th>
                        <th class="result_header">rating</th>
                        <th class="result_header">length</th>
                        <th class="result_header">F.S.C</th>
                        <th class="result_header">year</th>
                        <th class="result_header">revenue</th>
                        <th class="result_header">seasons</th>
                        <th class="result_header">episodes</th>
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
