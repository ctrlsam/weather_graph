<?php
	// Query database for weather information
	include_once('connection.php');

	$sql = "SELECT recorded_time, temp, rain, pop FROM " . $tablename . " ORDER BY recorded_time ASC";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
	    $temp_x = $temp_y = [];
	    $rain_x = $rain_y = [];

	    while($row = mysqli_fetch_assoc($result)) {
	    	// Temperature
	        $temp_x[] = date('r', $row['recorded_time']);
	        $temp_y[] = $row['temp'];
	        // Rain
        	$rain_x[] = date('r', $row['recorded_time']);
        	$rain_y[] = $row['rain'];

	    }
	}
	mysqli_close($conn);
?>


<!DOCTYPE html>
<head>
	<title>Basic Weather Graph</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Theme Color - for Mobile -->
	<meta name="theme-color" content="#343a40">
</head>

<body>

	<!-- Navbar -->
	<nav class="navbar navbar-dark bg-dark">
	  <a class="navbar-brand" href="">
	    Basic Weather
	  </a>
	</nav>
  
  	<!-- Content -->
  	<div class="content">
  		<div class="row">
		  	<div class="col-md-12">
		  		<!-- Graph -->
				<div id="graph"></div>
		  	</div>
	  	</div>
  	</div>

  	<!-- JQuery -->
  	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

  	<!-- Plotly.js -->
	<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

	<script src="js/index.js"></script>
	<script src="js/graph.js"></script>
	<script>
		var temp = [<?php echo json_encode($temp_x); ?>, <?php echo json_encode($temp_y); ?>];
		var rain = [<?php echo json_encode($rain_x); ?>, <?php echo json_encode($rain_y); ?>]
		if(temp.length > 0){
			// Options for Graph
			var figure = {
			  data: [
			      {
			        x: temp[0],
			        y: temp[1],
			        type: 'scatter',
					name: 'Temperature'
			      },

			      {
			        x: rain[0],
			        y: rain[1],
			        type: 'bar',
			        name: 'Chance of Rain'
			      }
			  ]
			}
			graph(figure);
		}
		else{
			// No data message
			$(".content .row").append(`
				<div class="col-md-12">
					<div class="text-center">
						<h2> There appears to be no data to display </h2>
						<h3> Try refreshing the page</h3>
					</div>
				</div>
			`);
		}
		
	</script>
</body>
</html>