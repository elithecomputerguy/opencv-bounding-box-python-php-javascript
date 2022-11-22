<?php

if (isset($_GET['delete'])){
    shell_exec("rm upload/*");
    //shell_exec("rm opencv-data.txt");
    file_put_contents("opencv-data.txt"," ");
    file_put_contents("pic-data.txt"," ");
    file_put_contents("neg-data.txt"," ");
}

//$opencv_result = shell_exec("python3 opencv-php-upload-python.py");

//if($opencv_result !=""){
    header("Location: ./index.php");
//} else {
//    echo "problem";
//}

?>