<?php
   include('config.php');
    //include('file_upload.php');

    $rings = array();
    $kml = simplexml_load_file('uploads/geonode-population_data_per_block.kml');
    
    //$placemarks = $kml->Document->Folder->Placemark;
    foreach($kml->Document->Folder->Placemark as $pm){
       if(isset($pm->MultiGeometry->Polygon)){
       $encoded = json_encode(explode(" ", str_replace(","," ",$pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates)));
       echo $encoded;
       echo "<br>";
       $centroid_encoded = json_encode(explode(",",$pm->MultiGeometry->Point->coordinates));
       echo "centoid: ". $centroid_encoded;
       echo "<br>";
        $dom = new DOMDocument();
        $dom->loadHTML(htmlspecialchars_decode($pm->description));
        $anchors = $dom->getElementsByTagName('span');
        echo "gid: " . $anchors->item(1)->nodeValue;
        $gid = $anchors->item(1)->nodeValue;
        echo "<br>";
        echo "esye_code: ". $anchors->item(3)->nodeValue;
        echo "<br>";
        if(!is_object($anchors->item(5))){
            echo "den uparcei timi";
        }else{
            echo "Population: ". $anchors->item(5)->nodeValue;
        }
        if(!is_object($anchors->item(5))){
            //diki mou timi otan den iparxei plithismos sto kml
            $population = 50;
        }else{
            $population = $anchors->item(5)->nodeValue;
        }
        /*
        $sql .= "INSERT INTO polygons (gid,coordinates,population,centroid)
VALUES ('$gid','$encoded','$population','$centroid_encoded');";*/
        
        echo "<br>";
        echo "<br>";

        $prepro_array = explode(" ", (string)$pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
        foreach($prepro_array as $key => $str){
            $str = explode(",",$str);
            $prepro_array[$key]=$str;
    }
        $rings[] = $prepro_array;

    }else{
        echo "<br> Not a polygon skipping";
    }
}
    /*
    if ($conn->multi_query($sql) === TRUE) {
        echo "New records created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();*/




    /*
    foreach($kml->Document->Folder->Placemark as $pm){
        if(isset($pm->MultiGeometry->Polygon)){
              // Process polygon datas
              // Get coordinates for 'outerBoundaryIs', other possible data not considered is 'innerBoundaryIs'
              $coordinates = $pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;
              $cordsData = trim(((string) $coordinates));
              echo "cordsData : ". $cordsData;
                      // check if coordinate data is available
                      if(isset($cordsData) && !empty($cordsData)){
                          
                          $explodedData = explode("\n", $cordsData);
                          echo "<br>";
                          print_r($explodedData);
                          $explodedData = array_map('trim', $explodedData);
                          echo "<br>";
                          print_r($explodedData);
                          
                          // next for each of the points build the polygon data
                          $points = "";
                          foreach ($explodedData as $index => $coordinateString) {
                              $coordinateSet = array_map('trim', explode(' ', $coordinateString));
                              echo "<br>";
                              print_r($coordinateSet);
                          }       
                          
                      }
                      
          } else {
              echo '<br/>Not a polygon - skipping';
          }

    }/*

      
     








    /*
    echo "<br>";
    echo $placemarks->coordinates;
    echo "<br>";

    print_r(str_replace(","," ",$placemarks->coordinates));
    echo "<br>";
    //vazei opou , to keno kai ftiaxnei pinaka xwrizontas to string me vasi to keno
    print_r(explode(" ", str_replace(","," ",$placemarks->coordinates)));
    echo "<br>";
    
    //me tin parametro JSON_NUMERIC_CHECK feugoun ta ""
    $encoded = json_encode(explode(" ", str_replace(","," ",$placemarks->coordinates)));
    echo $encoded;
    */
    echo "<br>";
    //tipou array() preprocessing coordinates gia ipologismo centroid polygonou 

    /*
    $prepro_array = explode(" ", (string)$place->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
    foreach($prepro_array as $key => $str){
        $str = explode(",",$str);
        $prepro_array[$key]=$str;
    }*/


    //morfi coordinates katalili gia centroid of polygon
    //print_r($prepro_array);

    //$html = $kml->Document->Folder->Placemark;
    /*
    foreach($placemarks as $desc){
        $dom = new DOMDocument();
        $dom->loadHTML(htmlspecialchars_decode($desc->description));
        $anchors = $dom->getElementsByTagName('span');
        echo "gid: " . $anchors->item(1)->nodeValue;
        echo "<br>";
        echo "esye_code: ". $anchors->item(3)->nodeValue;
        echo "<br>";
        if($anchors->item(5)->nodeValue==NULL){
            echo "den uparcei timi";
        }else{
            echo "Population: ". $anchors->item(5)->nodeValue;
        }
        //echo "Population: ". $anchors->item(5)->nodeValue;
        echo "<br>";
        echo "<br>";
       
    }*/



    
?>
    /*
    $places = $kml->Document->Folder->Placemark;
    foreach($places as $place){
        print_r(explode(" ", str_replace(","," ",$place->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates)));
        echo "<br>";
        echo "<br>";
    }

  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";*/


/*
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO polygons (coordinates)
VALUES ('$encoded')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();*/


