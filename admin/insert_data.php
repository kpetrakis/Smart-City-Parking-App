<?php

    header('Content-Type: multipart/form-data; charset=utf-8');

    include('config.php');

    
    if(isset($_POST['parking_spots'])){
        $parking_spots = $_POST['parking_spots'];
    }

    if(isset($_POST['zitisi'])){
        $zitisi = $_POST['zitisi'];
    }

    //echo $_POST['zitisi'];
    //print_r($_POST);
    
    $points = array($_POST['points']);
    //print_r($points);
    //echo json_encode($points,JSON_NUMERIC_CHECK);
    $cords = array();
    if(isset($_POST['points'])){ //to points krataei ta oria tou polygon
        $points = explode(",", $_POST['points']); 
        //prosthetw to arxiko simeio sto telos
        $points[] = $points[0];
        $points[] = $points[1];
        //stroggilopoiw
        foreach($points as $point){
            $cords[] = round($point,10);
        }
        //$points_encoded = json_encode($points,JSON_NUMERIC_CHECK);
        //antistrefw lat kai lng
        for($i=0;$i<sizeof($cords);$i+=2){
            $tmp = $cords[$i];
            $cords[$i] = $cords[$i+1];
            $cords[$i+1] = $tmp;
        }
        
        
    }
    

    
    $sql = "SELECT id, coordinates FROM  polygons";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row =$result->fetch_assoc()){
            //strogilopoiw tis sintetagmenes apo ti vasi
            $round_return = array();
            $returns = json_decode($row['coordinates']);
            foreach($returns as $return){
                $round_return[] = round($return,10);
            }
            if($round_return==$cords){
                $id = $row['id'];
                //echo $row['id'];
                //echo "BIKE";
            }
            //print_r($round_return);
            //print_r(json_decode($row['coordinates']));
            //var_dump($cords==$round_return);
        

        }
    }else{
        echo '0 results';
    }

    $sql2 = "UPDATE polygons SET parking_spots=$parking_spots, distribution='$zitisi' WHERE id=$id";
    if ($conn->query($sql2) === TRUE) {
        echo "Οι θέσεις στάθμευσης του πολυγώνου ενημερώθηκαν επιτυχώς!";
    } else {
        echo "Error updating record: " . $conn->error;
    }




    $kentro_polis = array(0.75,0.55,0.46, 0.19, 0.2, 0.2, 0.39, 0.55, 0.67, 0.8, 0.95, 0.9,
    0.95, 0.9, 0.88, 0.83, 0.7, 0.62, 0.74, 0.8, 0.8, 0.95, 0.92, 0.76);

    $perioxi_katoikias = array(0.69, 0.71, 0.73, 0.68, 0.69, 0.7, 0.67, 0.55, 0.49, 0.43, 0.34, 0.45, 
    0.48, 0.53, 0.5, 0.56, 0.73, 0.41, 0.42, 0.48, 0.54, 0.6, 0.72, 0.66);

    $statheri = array(0.18, 0.17, 0.21, 0.25, 0.22, 0.17, 0.16, 0.39, 0.54, 0.77, 0.78, 0.83,
    0.78, 0.78, 0.8, 0.76, 0.78, 0.79, 0.84, 0.57, 0.38, 0.24, 0.19, 0.23);


?>