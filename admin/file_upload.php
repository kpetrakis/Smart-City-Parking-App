<?php
header('Content-Type: multipart/form-data; charset=utf-8');

include('config.php');

ini_set('maximum_execution_time',500);
set_time_limit(500);

   $response = new stdClass();
   $msg = '';
   $msgClass = '';
   $target_dir = "uploads/";
   $uploadOk = 1;
   if(!empty($_FILES['fileToUpload'])){
      $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
      $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
      //check size
      if($_FILES['fileToUpload']['size']>10000000){
         $msg = 'Το αρχείο είναι πολύ μεγάλο.';
         /*$msgClass = 'alert-warning';
         $uploadOk = 0;
         $response->msgClass= $msgClass;
         $response->msg = $msg;
         echo json_encode($response,JSON_UNESCAPED_UNICODE);*/
         $uploadOk = 0;
         echo $msg;
      }
      //check if exists
      if(file_exists($target_file)){
         $msg = 'Το αρχείο υπάρχει ήδη.';
         /*$msgClass = 'alert alert-warning';
         $uploadOk = 0;
         $response->msgClass= $msgClass;
         $response->msg = $msg;      
         echo json_encode($response,JSON_UNESCAPED_UNICODE);*/
         $uploadOk = 0;
         echo $msg;
      }
      //check type
      if($fileType!="kml"){
         $msg = 'Επιλέξτε ένα .kml αρχείο.';
         /*$msgClass = 'alert alert-danger';
         $uploadOk=0;
         $response->msgClass= $msgClass;
         $response->msg = $msg;
         echo json_encode($response,JSON_UNESCAPED_UNICODE);*/
         $uploadOk = 0;
         echo $msg;
       }

      if($uploadOk === 0){
         //$msg .= ' Tο αρχείο δεν φορτώθηκε επιτυχώς!';
         //$msgClass = 'alert alert-danger';
         //$response->msgClass= $msgClass;
         //$response->msg .= $msg;
         //echo json_encode($response,JSON_UNESCAPED_UNICODE);
      }else{
         if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file)){
            $msg = "Το αρχείο ". basename($_FILES['fileToUpload']['name']). " φορτώθηκε επιτυχώς!";
            /*$msgClass = 'alert alert-success';
            $response->msgClass= $msgClass;
            $response->msg = $msg;
            echo json_encode($response,JSON_UNESCAPED_UNICODE);*/
            echo $uploadOk;//epistrefei 1 gia na deiksw oti ola pigan kala

            
   
    $kml = simplexml_load_file($target_file);
    
    //$placemarks = $kml->Document->Folder->Placemark;
    foreach($kml->Document->Folder->Placemark as $pm){
       if(isset($pm->MultiGeometry->Polygon)){
       $encoded = json_encode(explode(" ", str_replace(","," ",$pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates)),JSON_NUMERIC_CHECK);
       $centroid_encoded = json_encode(explode(",",$pm->MultiGeometry->Point->coordinates),JSON_NUMERIC_CHECK);
        $dom = new DOMDocument();
        $dom->loadHTML(htmlspecialchars_decode($pm->description));
        $anchors = $dom->getElementsByTagName('span');
   
        $gid = $anchors->item(1)->nodeValue;
       
        if(!is_object($anchors->item(5))){
            //diki mou timi otan den iparxei plithismos sto kml
            $population = 50;
        }else{
            $population = $anchors->item(5)->nodeValue;
        }
        
        $sql .= "INSERT INTO polygons (gid,coordinates,population,centroid,parking_spots,distribution)
VALUES ('$gid','$encoded','$population','$centroid_encoded','100','Περιοχή σταθερής ζήτησης');";
        


    }
}
    
    if ($conn->multi_query($sql) === TRUE) {
       
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        $msg = "Το .kml αρχείο. δεν φορτώθηκε σωστά στην βάση προέκυψε: ". $sql. " ". $conn->error;
         $msgClass = 'alert alert-danger';
         $response->msgClass= $msgClass;
         $response->msg = $msg;
         echo json_encode($response,JSON_UNESCAPED_UNICODE);
    }

    $conn->close();

         }else{
            $msg = 'Κάτι πήγε στραβά και το αρχείο δεν φορτώθηκε επιτυχώς!';
            $msgClass = 'alert alert-danger';
            $response->msgClass= $msgClass;
            $response->msg = $msg;
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
         }
      }
   } 
   
?>
