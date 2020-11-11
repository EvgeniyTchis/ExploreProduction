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
                <h1 id="explore">Create a TV show</h1>
            </div>
            <div id="menue_div">
                <form method="POST" action="create-production-show.php">
                    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
                        <input class="search_bar" type="text" name="genre_search" value="ID">
                        <input class="search_bar" type="text" name="genre_search" value="Title">
                        <input class="search_bar" type="text" name="genre_search" value="Genre">
                        <input class="search_bar" type="text" name="genre_search" value="Rating">
                        <input class="search_bar" type="text" name="genre_search" value="Seasons">
                        <input class="search_bar" type="text" name="genre_search" value="Episodes">
                    <input class="button button_b button_s" type="submit" value="Create" name="SearchGenreSubmit">
                    </form>
            </div>
        </div>


    </body>
</html>