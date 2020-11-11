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
                <h1 id="explore">Create a Sponsor</h1>
            </div>
            <div id="menue_div">
                <form method="POST" action="create-sponsor.php">
                    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
                        <input class="search_bar" type="text" name="genre_search" value="SID">
                        <input class="search_bar" type="text" name="genre_search" value="Name">
                    <input class="button button_b button_s" type="submit" value="Create" name="CreateSponsorSubmit">
                    </form>
            </div>
        </div>


    </body>
</html>