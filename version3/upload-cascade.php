<?php

$countfiles = count($_FILES['files']['name']);

for($i=0;$i<$countfiles;$i++){
   $filename = $_FILES['files']['name'][$i];
    if ($filename != ""){
        //$is_image = exif_imagetype($_FILES['files']['tmp_name'][$i]);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext =="xml"){
            if(move_uploaded_file($_FILES['files']['tmp_name'][$i],'data/haarcascades/'.$filename)){
             echo "$filename was Uploaded<br>";
            }
        }else {
            echo    "<strong>File $filename did not upload</strong><br>
                    Cascade Filters have .xml extensions.  You uploaded a <strong>$ext</strong><br>";
        }
    }    
}

echo    "<a href='./upload-cascade-form.php'>Filter Upload Form</a><br>
        <a href='./index.php'>Home</a>";

?>