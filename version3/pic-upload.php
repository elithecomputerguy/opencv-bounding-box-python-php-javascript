<?php

$filter = $_POST['filter'];

echo "$filter<br><br>";

file_put_contents("opencv-data.txt", $filter);

$countfiles = count($_FILES['files']['name']);

for($i=0;$i<$countfiles;$i++){
   $filename = $_FILES['files']['name'][$i];
    echo "filename $filename<br>";
    if ($filename != ""){
        $is_image = exif_imagetype($_FILES['files']['tmp_name'][$i]);

        if ($is_image !=""){
            if(move_uploaded_file($_FILES['files']['tmp_name'][$i],'upload/'.$filename)){
             echo "$filename was Uploaded<br>";
            }
        }
    }    
}

$opencv_result = shell_exec("python3 opencv-process.py");

if($opencv_result !=""){
    header("Location: ./index.php");
} else {
    echo "problem";
}
?>