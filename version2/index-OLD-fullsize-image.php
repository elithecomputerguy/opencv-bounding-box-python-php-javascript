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
        $size = getimagesize($pic);

        echo "Picture Name: $pic<br>";
        echo "Picture Size: ".$size[3]."<br>";
        
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
        echo "<canvas id=\"myCanvas".$x."\"".$size[3]." style=\"border:1px solid #d3d3d3;\"> Your browser does not support the HTML5 canvas tag. </canvas>";
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

            echo "ctx.beginPath();
            ctx.lineWidth = \"6\";
            ctx.strokeStyle = \"red\";
            ctx.rect(".$val[0].",".$val[1].",".$val[2].",".$val[3].");
            ctx.stroke();";
        }

        echo "</script>";
        echo "<br><br>";
        $x++;
    }


    echo "<h3>Images without Object</h3>";
    //display images without object
    $neg_file = file("./neg-data.txt");

    foreach($neg_file as $pic){
        echo "<img src=$pic style='width:400;'>";
    }
}

?>