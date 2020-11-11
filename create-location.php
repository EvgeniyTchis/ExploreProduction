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
                <h1 id="explore">Create a Location</h1>
            </div>
            <div id="menue_div">
                <form method="POST" action="create-location.php">
                    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
                        <input class="search_bar" type="text" name="genre_search" value="City">
                        <input class="search_bar" type="text" name="genre_search" value="Postal Code">
                        <input class="search_bar" type="text" name="genre_search" value="Country">

                    <input class="button button_b button_s" type="submit" value="Create" name="CreateLocationSubmit">
                    </form>
            </div>
        </div>


    </body>
</html>