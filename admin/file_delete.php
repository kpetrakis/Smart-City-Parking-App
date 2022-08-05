<?php 
    include('config.php');

    $dir = 'uploads';
    $files = scandir($dir);
    $file = 'uploads/'.$files[2];//ta prwta apo tin scandir() einai . kai ..
    unlink($file);


    
    $sql = 'TRUNCATE TABLE polygons';

    if($conn->query($sql)===TRUE){
        echo "ok";
    }else{
        echo "Error deleteting table: ". $conn->error;
    }
    
?>