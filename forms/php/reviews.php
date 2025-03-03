<?php
<<<<<<< HEAD
require_once('/backend/modules/module.php');
=======
require_once('../../backend/modules/module.php');
>>>>>>> c9fc6b957b9af4c538b9839345a8a591b31241e9
$reviews=get_reviews();

?>
<!DOCTYPE html>
<html>
<head>
<head>
    <link rel="stylesheet" href="/forms/styles/style.css">
</head>
    <body>
        <form class='hegazy-form' style='font-size:200%'>
            <div class="c">
                <h1>Latest Reviews</h1>
                <hr>

                <?php
                    foreach($reviews as $key=>$review){
                        echo "<h4>".$review['first_name'].' '.$review['last_name']."</h4>";
                        echo "<input type='rating' readOnly stars=5 value=".$review['rating']." style='color:rgb(255, 100, 0);'>";
                        echo "<span>".$review['review']."</span>";
                    }

                ?>
            </div>
        </form>
        <script>initialize()</script>

    </body>
</html>