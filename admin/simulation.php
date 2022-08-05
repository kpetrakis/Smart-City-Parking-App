<?php
    header('Content-Type: multipart/form-data; charset=utf-8');

    include('config.php');

    $kentro_polis = array(0.75,0.55,0.46, 0.19, 0.2, 0.2, 0.39, 0.55, 0.67, 0.8, 0.95, 0.9,
    0.95, 0.9, 0.88, 0.83, 0.7, 0.62, 0.74, 0.8, 0.8, 0.95, 0.92, 0.76);

    $perioxi_katoikias = array(0.69, 0.71, 0.73, 0.68, 0.69, 0.7, 0.67, 0.55, 0.49, 0.43, 0.34, 0.45, 
    0.48, 0.53, 0.5, 0.56, 0.73, 0.41, 0.42, 0.48, 0.54, 0.6, 0.72, 0.66);

    $statheri = array(0.18, 0.17, 0.21, 0.25, 0.22, 0.17, 0.16, 0.39, 0.54, 0.77, 0.78, 0.83,
    0.78, 0.78, 0.8, 0.76, 0.78, 0.79, 0.84, 0.57, 0.38, 0.24, 0.19, 0.23);

    if(isset($_POST['time'])){
        $time = intval(explode(":",$_POST['time'])[0]); //krataei tin wra
        $minutes = intval(explode(":",$_POST['time'])[1]); //lepta
    }
    //echo $time;

    $teliko = array();
    

    $sql = "SELECT id, coordinates, population, centroid, parking_spots, distribution FROM  polygons";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            if($row['distribution']=='Περιοχή σταθερής ζήτησης'){
                $zitisi = $statheri[$time];
            }else if($row['distribution']=='Περιοχή κατοικίας'){
                $zitisi = $perioxi_katoikias[$time];
            }else if($row['distribution']=='Κέντρο πόλης'){
                $zitisi = $kentro_polis[$time];
            }
            $monimi_katoikoi = 0.2*$row['population'];
            $left_spots = $row['parking_spots']-$monimi_katoikoi;
            $free_spots = (1-$zitisi)*$left_spots;
            $pososto_katilimenwn = (($row['parking_spots']-$free_spots)/$row['parking_spots'])*100;
            //echo $pososto_katilimenwn;
            $teliko[] = array('id'=>$row['id'],'pososto'=>$pososto_katilimenwn,'centroid'=>$row['centroid']); //array pou tha metatrapei se json
        }
    }else{
        echo '0 results';
    }

    echo json_encode($teliko,JSON_NUMERIC_CHECK);
   




?>