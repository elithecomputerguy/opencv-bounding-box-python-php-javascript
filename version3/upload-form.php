Open CV Detection App<br>

<?php

$dir = "./data/haarcascades/";
$dir = scandir($dir);

echo "<form action='./pic-upload.php' method='post' enctype='multipart/form-data'>";
echo "<select name='filter'>";

foreach($dir as $folder){
    $folder = trim($folder);
    if($folder != "." && $folder != ".."){    
        echo "<option value=$folder>$folder</option>";
    }    
}

echo   "</select>
        <a href='upload-cascade-form.php'>Upload New Cascade Filter</a>
        <br><br>
        <label for='files'>Select files:</label>
        <input type='file' id='files' name='files[]' multiple><br><br>
        <input type='submit' value='Process Pictures'>
        </form>

        <a href='delete-pics.php?delete=yes'> Delete Uploaded Pictures</a>
        <br><br>";

?>