<?php
    include('config.php');

    $response = array();

    $sql = "SELECT coordinates FROM polygons";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row =$result->fetch_assoc()){
            $response[] = $row['coordinates'];
        }
    }else{
        echo '0 results';
    }
    echo json_encode($response);

    /*
    if(isset($_POST['x'])){ //to x krataei to count()
        $id = $_POST['x']; 
    }
    
    $sql = "SELECT coordinates FROM polygons WHERE id=$id";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row =$result->fetch_assoc()){
            echo $row['coordinates'];
        }
    }else{
        echo '0 results';
    }*/

?>