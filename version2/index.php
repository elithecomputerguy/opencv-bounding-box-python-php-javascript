<?php
include 'upload-form.php';

$used_cascade = file_get_contents("./opencv-data.txt");
echo "<h3>Cascade Filter: $used_cascade</h3>";

$file = file("./pic-data.txt");

$key_array = array();

if($file[0] != " "){
    foreach($file as $picture){
        $result = explode("[", $picture);
        $coordinates = $result[1];
        $coordinates = trim($coordinates);
        $coordinates = rtrim($coordinates,"]");
        $key_array[$result[0]] = $coordinates;
    }

    $x=0;
    foreach($key_array as $pic =>$xy){
        echo "<div style='display:inline-block; width:300; border: 1px solid black;'>";
        $size = getimagesize($pic);
        $width = $size[0];
        $height = $size[1];
        echo "Picture Name: $pic<br>";
        echo "Width: $width Height: $height<br>";

        $canvas_width = 300;
        $resize_percent = $canvas_width / $width;
        //echo "$resize_percent %<br>";
        $resize_height = $height * $resize_percent;
        //echo "$resize_height <br>";


        //$xy contains box coordinates from OpenCV. Turn $xy into individual corrdinate sets, and clean up data
        $box = explode("', '",$xy);
        foreach($box as $coordinates){
            $coordinates = trim($coordinates);
            $coordinates = ltrim($coordinates, "'");
            $coordinates = rtrim($coordinates, "'");
            echo "$coordinates<br>";
        }

        //Create individual Canvases for images. Increment Canvas names by 1
        //Set Canvas size to image height/width
        echo "<canvas id=\"myCanvas".$x."\" width=$canvas_width height=$resize_height style=\"border:1px solid #d3d3d3;\"> Your browser does not support the HTML5 canvas tag. </canvas>";
        echo "<script>
        var canvas = document.getElementById(\"myCanvas".$x."\");
        var ctx = canvas.getContext(\"2d\");
        var img = new Image();
        img.src = \"".$pic."\";
        var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
        var x = (canvas.width / 2) - (img.width / 2) * scale;
        var y = (canvas.height / 2) - (img.height / 2) * scale;
        ctx.drawImage(img, x, y, img.width * scale, img.height * scale);";

        //Draw individual bounding boxes around objects
        foreach($box as $coordinates){
            $coordinates = trim($coordinates);
            $coordinates = ltrim($coordinates, "'");
            $coordinates = rtrim($coordinates, "'");
            
            $val = explode(",", $coordinates);

            $x_axis = $val[0] * $resize_percent;
            $y_axis = $val[1] * $resize_percent;
            $x_width = $val[2] * $resize_percent;
            $y_width = $val[3] * $resize_percent;

            echo "ctx.beginPath();
            ctx.lineWidth = \"3\";
            ctx.strokeStyle = \"red\";
            ctx.rect($x_axis, $y_axis, $x_width, $y_width);
            ctx.stroke();";
        }

        echo "</script>";
        echo "</div>";
       // echo "<br><br>";
        $x++;
    }

echo "<br><br><hr style='border:20px solid black;'>";
    echo "<h2>Images without Object</h2>";
    //display images without object
    $neg_file = file("./neg-data.txt");

    foreach($neg_file as $pic){
        echo "<img src=$pic style='width:$canvas_width;'>";
    }
}

?>