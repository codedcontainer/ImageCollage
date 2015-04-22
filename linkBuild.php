<?php
 ini_set('display_errors',1);
 ini_set('display_startup_errors',1);
 error_reporting(-1);  //add error reporting that is not working
/* link build */ 
/* remove all links and start again with new rgb values */ 


$a = new MongoClient();
$db2 = $a->images;
$collection2 = $db2->newImages;


//==========================

$rowCol = 50; 
$m = new MongoClient();  
$db = $m->images;
$collection = $db->newImages; 

$inFile = "flash.jpg"; //image to use
// Get the image height and width. 
$imgSize = getimagesize($inFile);
$imgWidth = $imgSize[0]; //width of the image

echo "<div style='width:".$imgWidth."px'>";
for( $d = 0; $d<=$rowCol-1; $d++)
{

	for ( $a = 0; $a<=$rowCol-1; $a++)
	{
		$find = array('link'=>$a.'-'.$d.'.jpg');
		$cursor = $collection->find($find)->limit(1);
		foreach ($cursor as $doc)
		{
			//var_dump($doc);
			echo "<img src='http://".$doc['imgSrc']."' width='32' height='32' />";
			ob_flush();
			flush();
		}
	}
}

echo "</div>"; 

?>