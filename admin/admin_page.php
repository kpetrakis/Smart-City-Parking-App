<?php
    session_start();
    // If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location:/arxiki.html');
	exit();
}
//include('file_upload.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 4 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!--link rel="stylesheet" href="modal.css"-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>


<script src = "map.js?aa" defer></script>
<script src ="file_upload.js?" defer></script>
<script src ="file_delete.js" defer></script>
<script src = "insert_data.js" defer></script>
<!--script src = "insert_time.js" defer--></script>



  <style>
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  #mapid { height:500px; align:'center';}
  </style>
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>My First Bootstrap 4 Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="logout.php">Αποσύνδεση</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>    
    </ul>
  </div>  
</nav>


<div class="container" style="margin-top:30px">

  <!--Για το file upload-->
  <!--action="<?//php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"-->
  <div class="row">
    <div class="col-sm-4">
    <div class="container">
   <div id="response" ></div>
  <h3>Ανέβασμα αρχείου</h3>
  <p>Επιλέξτε το αρχείο με βάση το οποίο θα σχηματιστεί ο χάρτης. </p>
  <form id="fileForm"  enctype="multipart/form-data">
    <div class="form-group">
      <input type="file" class="form-control-file-border" id="fileToUpload" name="fileToUpload">
      <small id="fileHelp" class="form-text text-muted">Επιλέξτε ένα .kml αρχείο</small>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
  </form>
</div> 
<!-- Τέλος του file upload-->


<div class="container">
  <div id="delete_response"></div>
  <p>Διαγραφή στοιχείων ρυμοτομίας απο την βάση </p>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">
  Διαγραφή Δεδομένων
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Προειδοποίηση</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Είστε σίγουροι οτι θέλετε να προχωρήσετε στην διαγραφή των χαρτογραφικών δεδομένων απο την βάση??
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
        <button type="submit" name="delete" class="btn btn-primary">Διαγραφή Δεδομέων</button>
      </div>
    </div>
  </div>
</div>


</div>
      <h3>Some Links</h3>
      <p>Lorem ipsum dolor sit ame.</p>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>
      <hr class="d-sm-none">
    </div>
    <div class="col-sm-8">
      <h2>TITLE HEADING</h2>
      <h5>Title description, Dec 7, 2017</h5>
<!--modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία Δεδομένων Πολυγώνου</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="insert_form" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="form-group">
            <label for="parking_spots" class="col-form-label">Θέσεις Στάθμευσης:</label>
            <input type="number" class="form-control" id="parking_spots">
          </div>
          <div class="form-group">
            <label for="zitisi" class="col-form-label">Καμπύλη Ζήτησης:</label>
            <input type="text" class="form-control" placeholder="π.χ Περιοχή σταθερής ζήτησης" id="zitisi">
            <small class="form-text text-muted">Επιλογές: Κέντρο Πόλης - Περιοχή κατοικίας - Περιοχή σταθερής ζήτησης</small>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
        <button type="submit" class="btn btn-primary">Υποβολή</button>
      </div>
</form>
    </div>
  </div>
</div>
<!-- telos tou modal-->
      <!-- για τον map-->
      <div id="insert_response"></div>
      <div id="mapid">Χάρτης</div>
        <div class="container">
      <button class="btn btn-primary" name="fetch_polygons">Φόρτωση Πολυγώνων</button>
      <!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal</button-->
      <form id="time_form" class="form-inline" enctype="multipart/form-data">
      <div class="form-group row">
      <label for="time_input" class="col-2 col-form-label">Time</label>
      <div class="col-10">
      <input class="form-control" type="time" value="13:45:00" id="time_input">
      </div>
    </div>
        <button type="submit" class="btn btn-primary">Εκτέλεση Εξομόιωσης</button>
      </form>
        </div>
        <!-- τέλος του map-->
      <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
      <br>
      <h2>TITLE HEADING</h2>
      <h5>Title description, Sep 2, 2017</h5>
      <div class="fakeimg">Fake Image</div>
      <p>Some text..</p>
      <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
    </div>
  </div>
</div>-

<div class="jumbotron text-center" style="margin-bottom:0">
  <p>Footer</p>
</div>

</body>


<!--
<html>
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $_SESSION['name']; ?></h1> 
      <h2><a href = "logout.php">Sign Out</a></h2>
   </body>
   
</html> -->