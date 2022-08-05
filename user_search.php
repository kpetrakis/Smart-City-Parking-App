<?php
    header('Content-Type: multipart/form-data; charset=utf-8');

    include('admin/config.php');


    $kentro_polis = array(0.75,0.55,0.46, 0.19, 0.2, 0.2, 0.39, 0.55, 0.67, 0.8, 0.95, 0.9,
    0.95, 0.9, 0.88, 0.83, 0.7, 0.62, 0.74, 0.8, 0.8, 0.95, 0.92, 0.76);

    $perioxi_katoikias = array(0.69, 0.71, 0.73, 0.68, 0.69, 0.7, 0.67, 0.55, 0.49, 0.43, 0.34, 0.45, 
    0.48, 0.53, 0.5, 0.56, 0.73, 0.41, 0.42, 0.48, 0.54, 0.6, 0.72, 0.66);

    $statheri = array(0.18, 0.17, 0.21, 0.25, 0.22, 0.17, 0.16, 0.39, 0.54, 0.77, 0.78, 0.83,
    0.78, 0.78, 0.8, 0.76, 0.78, 0.79, 0.84, 0.57, 0.38, 0.24, 0.19, 0.23);
    

    if(isset($_POST['user_time']) && isset($_POST['aktina'])){
        $user_time = intval(explode(":",$_POST['user_time'])[0]); //krataei tin wra
        $minutes = intval(explode(":",$_POST['user_time'])[1]); //lepta
        $aktina = $_POST['aktina'];
        //$time = intval(explode(":",$_POST['user_time'])[0]); //krataei tin wra
        //$minutes = intval(explode(":",$_POST['user_time'])[1]); //lepta
    }

    if(isset($_POST['ids_in_range'])){
        $ids_in_range = json_decode($_POST['ids_in_range']);
    }
        
    //echo $ids_in_range[0]->id;
    
    $temp = array();//pinakas pou me voitha sto na prospelasw kathe centroid kai na dimiourgisw tixai simeia
    //echo $user_time;

    $random_points = array();
   
   $point = $_POST['point'];
   print_r(json_decode($point));

   foreach($ids_in_range as $in_range){
    $sql = "SELECT id, coordinates, population, centroid, parking_spots, distribution FROM  polygons WHERE id='$in_range->id'";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            if($row['distribution']=='Περιοχή σταθερής ζήτησης'){
                $zitisi = $statheri[$user_time];
            }else if($row['distribution']=='Περιοχή κατοικίας'){
                $zitisi = $perioxi_katoikias[$user_time];
            }else if($row['distribution']=='Κέντρο πόλης'){
                $zitisi = $kentro_polis[$user_time];
            }
            $monimi_katoikoi = 0.2*$row['population'];
            $left_spots = $row['parking_spots']-$monimi_katoikoi;
            $free_spots = (1-$zitisi)*$left_spots;
            $pososto_katilimenwn = (($row['parking_spots']-$free_spots)/$row['parking_spots'])*100;
            echo "eleuthere theseis: ".round($free_spots) ." id polygwnou: ". $in_range->id;
            $temp[] = array("free_spots"=>round($free_spots),"id"=>$in_range->id,"centroid"=>$row['centroid']);
            echo "<br>";
        }
    }else{
        echo '0 results';
    }
   }
   print_r($temp);
   foreach($temp as $tmp){
       $ran_points = array();
       $lat =json_decode($tmp['centroid'])[0];//to centroid einai sti morfi "[22.121,41.121]"
       $lng = json_decode($tmp['centroid'])[1];
       //vriskw tis sintetagmenes se apostasi 50m apo to kentroides 
       $max_lat = $lat + (180/M_PI)*(50/6378137);//50 metra ekfonisi
       $max_lng = $lng + (180/M_PI)*(50/6378137)/cos(deg2rad($lng));
       echo $max_lat ." " .$max_lng;
       echo "<br>";
       //dimiourgw tixaia simeia anamesa sto kendroeides kai stin sintetagmenes se apostasi 50m
       //kai pairnw sindiasmous twn sintategmwn=#free_spots gia kathe kendroieides
       for($i=0;$i<$tmp['free_spots'];$i++){
           $ran_points[] = array(mt_rand($lat*pow(10,11),$max_lat*pow(10,11))/pow(10,11),mt_rand($lng*pow(10,11),$max_lng*pow(10,11))/pow(10,11));
           $random_points[] = array(mt_rand($lat*pow(10,11),$max_lat*pow(10,11))/pow(10,11),mt_rand($lng*pow(10,11),$max_lng*pow(10,11))/pow(10,11));
       }
       print_r($ran_points);
       //$random_points[] = $ran_points;

     }
     print_r($random_points);
     
   




?>