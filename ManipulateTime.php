<?php

/*
 * This function should read in values of a datetime and then manipulate that datetime by 
 * adding or subtracting the corresponding values from it
 *
 */


 $_GET["orig"];
 $_GET["days"];
 $_GET["hours"];
 $_GET["mins"];
 $_GET["action"];

//begin of init 
 $timeToAdd=NULL;
 $ArrayOrigTime = explode(" ",$_GET["orig"]);
 //if the timezone is positive
 if(count($ArrayOrigTime) != 2)
 {
	 //copy the timezone value ex: +12
	 $origTimeDiffFromGmt = $ArrayOrigTime[2];
	 //copy the time value
	 $origHour=$ArrayOrigTime[1];
 }
 else
 {
	 //copy the timezone value ex: -12
 	$origTimeDiffFromGmt=substr($ArrayOrigTime[1],-3);
	 //copy the time value
 	$origHour=substr($ArrayOrigTime[1],0,5) ;
 }
 //copy the date
 $origDay = $ArrayOrigTime[0];
//end of init

 //create a new object date with the param
 $nDate = new DateTime($origDay.$origHour);

//convert into timestamp
 $dtTs=date_timestamp_get($nDate);
 
 //converte all the value write by the user into seconde
 isset($_GET["mins"]) && is_numeric($_GET["mins"]) ? $timeToAdd+=$_GET["mins"]*60 : false ;
 isset($_GET["hours"]) && is_numeric($_GET["hours"]) ? $timeToAdd+=$_GET["hours"]*3600 : false;
 isset($_GET["days"]) && is_numeric($_GET["days"]) ? $timeToAdd+=$_GET["days"]*86400 : false;

//add or substract the value to the timestamp
 if($_GET["action"] === "add")
	 $dtTs+=$timeToAdd;
 if($_GET["action"] === "sub")
 	$dtTs-=$timeToAdd;
	
//udpate the date object 	
date_timestamp_set($nDate, $dtTs);
//response
print(date_format($nDate, 'Y/m/d H:i').$origTimeDiffFromGmt ) ;



 
 ?>