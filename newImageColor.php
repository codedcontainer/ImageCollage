<?php
/* gets all of the colors for the new images */ 
ini_set('display_errors',1);
 ini_set('display_startup_errors',1);
 error_reporting(-1); 
 $mongo = new mongoClient(); 
$db = $mongo->images;
$collection = $db->newImages;
$cursor = $collection->find(array('rgb'=>array('$exists'=>false)));

foreach( $cursor as $value => $doc)
{
	$imgSrc = $doc['imgSrc'];
	$apiString = 'http://mkweb.bcgsc.ca/color_summarizer/?xml=1&url='.$imgSrc.'&precision=high'; //get the color of the image
	$xml = simplexml_load_file($apiString); //load the url
	$json = json_encode($xml); //convert the xml to json
	$jsonDecode2 = json_decode($json, true); //decode the json file

	$newRed = $jsonDecode2['variable'][3]['statistic'][0]['value']; //get red color from the json file
	$newGreen = $jsonDecode2['variable'][4]['statistic'][0]['value']; //get the green color from the json file
	$newBlue = $jsonDecode2['variable'][5]['statistic'][0]['value']; //get the blue color from the json file 

	$updates = array('$set'=>array('rgb'=>array('r'=>$newRed, 'g'=>$newGreen, 'b'=>$newBlue)));
	$find = array('imgSrc'=>$imgSrc);
	$mongo2 = new mongoClient(); 
	$db2 = $mongo2->images;
	$collection2 = $db2->newImages;
	$collection2->update(array('imgSrc'=>$imgSrc), $updates);
	//echo 'image updated';
	ob_flush();
	flush();

}




?>