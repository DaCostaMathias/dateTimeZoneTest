<!-- Add as much css to this as you would like there are always bonus points for a well designed page and there is nothing wrong with using a framework like bootstrap. -->
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title>MediMap Date Test</title>
        
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>

        <link rel="icon" type="image/gif" href="img/world.gif">
        
       
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script type="text/javascript" src="js/datetest.js"></script>        
        <script src="js/jquery.datetimepicker.full.min.js"></script>        
       
        <script src="http://momentjs.com/downloads/moment-with-locales.js"></script>
        <script src="http://momentjs.com/downloads/moment-timezone-with-data.min.js"></script>
         
    <script src="js/bootstrap.min.js"></script>
      
        
        
        
        <?php

				/*
				* init and create an array for to fill the <select><option>
				*
				*
				*
				*/
				$zones_array = array();
			  	$timestamp = time();
				//get the list of area from php 
			  	foreach(timezone_identifiers_list() as $key => $zone) 
			  	{
					date_default_timezone_set($zone);
					if($zone == "UTC")
						continue;
					$temp_array = array();
					$temp_array = explode('/',$zone);
					
					$zones_array[$key]['city'] = preg_replace("/_/"," ",$temp_array[1]);
					$zones_array[$key]['zone'] = $zone;
					$zones_array[$key]['diff_from_GMT'] = date('P', $timestamp);					
					$zones_array[$key]['continent'] =  $temp_array[0];
				}
				
				
			?>
            
	</head>
	<body>
    <nav class="navbar navbar-default navbar-static-top"  >
  <div class="container" >
  <p class="navbar-text navbar-left"><h1>Time Zone utility</h1></p>
  </div>
</nav>
    
    <div class="container">
    <form class="form-inline">
    	<input class="form-control" id="datetimepicker" type="text">
		<select id="timezone" class="form-control">
			<option value="false" default >No Timezone</option>
            <?php
			
				$continent = NULL;
				$city = NULL;
				//fill the <option> with the array grouped by continent
				foreach($zones_array as $zone_array)
				{
					//create a group if we change the continent
					if($zone_array['continent']!=$continent)
					{
						//optgroup
						echo("<optgroup label=\"$zone_array[continent]\">");
						$continent = $zone_array['continent'];
						
					}
					//avoid doubles
					if($zone_array['city']==$city)
						continue;
					
					echo("<option value=\"$zone_array[diff_from_GMT]\">$zone_array[city] UTC/GMT$zone_array[diff_from_GMT]</option>");
					$city=$zone_array['city'];
				}
				
				
			?>
			
			
			
		</select>
		<input class="btn btn-default" id="add_btn" type="button" value="add">
        </form>
        
   <div class="span4 pull-right">
    <div class="alert alert-danger fade">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Alert!</strong> Please choose a date.
    </div>
	</div>
		<div id="dates_div">

		</div>
		<div id="transform_div" style="display:none">
        <hr>
<div class="panel panel-default">
			<p id="datetime_placeholder"></p>
			<input class="form-control" id="days" placeholder="days">
			<input class="form-control" id="hours" placeholder="hours">
			<input class="form-control" id="minutes" placeholder="minutes">
			<button class="btn btn-default pull-right" id="addtime_btn">Add</button>
			<button class="btn btn-default pull-right" id="subtract_btn">Subtract</button>
			
			<!-- if you finish this far and still have time uncomment this block and get ready to modify timezones -->
			<br>
				<select id="timezone_change">
					<option value="false" class="form-control" selected default  >local Timezone</option>
            <?php
			
				$continent = NULL;
				$city = NULL;
				foreach($zones_array as $zone_array)
				{
					
					if($zone_array['continent']!=$continent)
					{
						//optgroup
						echo("<optgroup label=\"$zone_array[continent]\">");
						$continent = $zone_array['continent'];
						
					}
					if($zone_array['city']==$city)
						continue;
					echo("<option value=\"$zone_array[zone]\">$zone_array[city] UTC/GMT$zone_array[diff_from_GMT]</option>");
					$city=$zone_array['city'];
				}
			?>
				</select>
			 	<button class="btn btn-default" id="tzchange_btn">Change Timezone</button>
			 <br><button class="btn btn-default center-block" id="confirm_btn">Confirm</button>
		</div>
        </div>
        
      </div>
        <div class="page-footer"></div>
	
	</body>
</html>