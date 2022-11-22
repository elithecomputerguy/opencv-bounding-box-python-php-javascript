<h1>Upload OpenCV Cascade Filter</h1>

<?php

echo    "<p>Select Cascade Filter to Upload:</p>
        <form action='./upload-cascade.php' method='post' enctype='multipart/form-data'>
        <label for='files'>Select files:</label>
        <input type='file' id='files' name='files[]' multiple><br><br>
        <input type='submit' value='Upload Filter'>
        </form>";

?>