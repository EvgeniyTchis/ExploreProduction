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
                <h1 id="explore">Update a Critic</h1>
            </div>
            <div id="menue_div">
                <form method="POST" action="update-critic.php">
                    <input type="hidden" id="UpdateQueryRequest" name="UpdateQueryRequest">
                        <input class="search_bar" type="text" name="genre_search" value="CID">
                        <input class="search_bar" type="text" name="genre_search" value="Name">
                        <input class="search_bar" type="text" name="genre_search" value="Affiliation">

                    <input class="button button_b button_s" type="submit" value="Update" name="UpdateCriticSubmit">
                    </form>
            </div>
        </div>


    </body>
</html>