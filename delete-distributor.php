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
                <h1 id="explore">Delete a Distributor</h1>
            </div>
            <div id="menue_div">
                <form method="POST" action="delete-distributor.php">
                    <input type="hidden" id="DeleteQueryRequest" name="DeleteQueryRequest">
                        <input class="search_bar" type="text" name="genre_search" value="DID">
                    <input class="button button_b button_s" type="submit" value="Delete" name="DeleteDisSubmit">
                    </form>
            </div>
        </div>


    </body>
</html>