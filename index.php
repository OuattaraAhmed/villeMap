<?php
$con=mysqli_connect('localhost','root','','ville');


// $longeur=$lng['lng'];
// $largeur=$lat['lat'];

?>


<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>MAP</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
 </head>

<body>
<!-- <form action="" method="post">
<label for="site-search">Rechercher une ville</label>
<input type="search" id="search" name="search" aria-label="Search through site content" value="">
<button>Search</button> -->

<!-- </form> -->

<div class="container">
   <br />
   <h2 align="center">Recherche de Ville</h2><br />
   <div class="form-group">
    <div class="input-group">
     <span class="input-group-addon">Search</span>
     <input type="text" name="search_text" id="search_text" placeholder="Search by Customer Details" class="form-control" />
    </div>
   </div>
   <br />
   <div id="result"></div>
  </div>
  <script>
        $(document).ready(function(){

        load_data();

        function load_data(query)
        {
          $.ajax({
          url:"fetch.php",
          method:"POST",
          data:{query:query},
          success:function(data)
          {
            $('#result').html(data);
          }
          });
        }
        $('#search_text').keyup(function(){
          var search = $(this).val();
          if(search != '')
          {
          load_data(search);
          }
          else
          {
          load_data();
          }
        });
        });
</script>

  <div id="mapdiv"></div>
  <script src="http://www.openlayers.org/api/OpenLayers.js"></script>

<?php 

// $name = $_POST['search'];
//  WHERE ville LIKE '%{$name}%' dans sql

$sql = "SELECT * FROM ville  ";
$result = $con->query($sql);


    
?>

  <script>
     


    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());

   
    <?php if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

    ?>

    var lonLat = new OpenLayers.LonLat( <?php echo $row["lng"]; ?> , <?php echo $row["lat"]; ?>)
    
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );

    var zoom=16;

    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);

    markers.addMarker(new OpenLayers.Marker(lonLat));

    map.setCenter (lonLat, zoom);

    <?php
    }
    
  } else {
      echo "0 results";
    }

    mysqli_close($con);
    ?>
  </script>

  
</body>
</html>