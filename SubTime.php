<?php

/*
 * This function should read in values of a datetime and then manipulate that datetime by 
 * subtracting the corresponding values from it
 *
 */


 $_GET["orig"];
 $_GET["days"];
 $_GET["hours"];
 $_GET["mins"];

//begin of init 
 $timeToAdd=NULL;
 $ArrayOrigTime = explode(" ",$_GET["orig"]);
 
 if(count($ArrayOrigTime) != 2)
 {
	 $origTimeDiffFromGmt = $ArrayOrigTime[2];
	 $origHour=$ArrayOrigTime[1];
 }
 else
 {
 	$origTimeDiffFromGmt=substr($ArrayOrigTime[1],-3);
 	$origHour=substr($ArrayOrigTime[1],0,5) ;
 }
 $origDay = $ArrayOrigTime[0];
//end of init

 
 $nDate = new DateTime($origDay.$origHour);

 $dtTs=date_timestamp_get($nDate);
 
 isset($_GET["mins"]) && is_numeric($_GET["mins"]) ? $timeToAdd+=$_GET["mins"]*60 : false ;
 isset($_GET["hours"]) && is_numeric($_GET["hours"]) ? $timeToAdd+=$_GET["hours"]*3600 : false;
 isset($_GET["days"]) && is_numeric($_GET["days"]) ? $timeToAdd+=$_GET["days"]*86400 : false;
 $dtTs-=$timeToAdd;
 
date_timestamp_set($nDate, $dtTs);


if ( $origTimeDiffFromGmt>=0 )
{
	
	print(date_format($nDate, 'Y/m/d H:i').$origTimeDiffFromGmt ) ;
}
else 
{
	print( date_format($nDate, 'Y/m/d H:i').$origTimeDiffFromGmt);
}


 
 ?>