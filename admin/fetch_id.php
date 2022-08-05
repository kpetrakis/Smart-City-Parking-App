<?php
    include('config.php');

    $sql = "SELECT count(id) as total FROM polygons";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row =$result->fetch_assoc()){
            echo $row['total'];
        }
    }else{
        echo '0 results';
    }

?>