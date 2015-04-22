<?php
ini_set('display_errors',1);
 ini_set('display_startup_errors',1);
 error_reporting(-1);  //add error reporting that is not working
/* update new images with a link of old images by color */ 
$a = new MongoClient();
$db = $a->images;
$collection2 = $db->newImages;
$collection2->update(array(), array('$unset'=>array('link'=>1)),array(false,true));
linkUpdate(); 

function linkUpdate()
{
	$rowCol = 50;
$m = new MongoClient();
	
	for( $f = 0; $f<= $rowCol - 1; $f++)
{
	for( $g = 0; $g <= $rowCol -1; $g++)
	{

	$db = $m->images;
	$collection = $db->oldImages;
	$findPointer = array('imgSrc'=>$g.'-'.$f.'.jpg');
	//echo "<img src='12-1.gif'/>";
	$find = $collection->find($findPointer, array('rgb'=>1, 'imgSrc'=>1));
		foreach($find as $doc)
		{
			//var_dump($doc);
			$red = $doc['rgb']['r'];
			$green = $doc['rgb']['g'];
			$blue = $doc['rgb']['b'];
			//echo $red.' '.$green.' '.$blue;
			$collection2 = $db->newImages;
			$findPointer2 = array('rgb.r'=>array('$lte'=>(string)$red),'rgb.g'=>array('$lte'=>(string)$green),'rgb.b'=>array('$lte'=>(string)$blue));
			
			$find2 = $collection2->find($findPointer2)->sort(array('rgb'=> -1))->limit(1);
			foreach($find2 as $doc2)
			{
				echo "<img src='".$doc['imgSrc']."'/>";
				echo "<img src='http://".$doc2['imgSrc']."'width='23' height='23'/>"; echo"<br/>"; 
				ob_flush();
				flush(); 
				//append the new information to the new array item on New Images.
				$newData = array('$addToSet'=>array('link'=>$doc['imgSrc']));
				$find3 = $collection2->update(array('imgSrc'=>$doc2['imgSrc']), $newData); 
			}
		}

}
}


}



?>