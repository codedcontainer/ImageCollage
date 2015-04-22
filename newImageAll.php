<?php
ini_set('display_errors',1);
 ini_set('display_startup_errors',1);
 error_reporting(-1);  //add error reporting that is not working
/*****************************************************
* 	Get new images and add them to the database      *
*	if the width or height has a 0 remander of 50  	 *
*	Also, get the color properties from another api  *
*	and add those to the new collection as well. 	 *
/*****************************************************/
echo "Please wait while we download some images for you...<br/>";
newImageInsert('barry allen comic'); 
newImageInsert('barry allen');
newImageInsert('flash hero');
newImageInsert('flash comic');
newImageInsert('flash dc');
newImageInsert('barry allen the flash');
newImageInsert('barry allen the flash hero');

function newImageInsert($query)
{
	$apiKey = 'f2abc38ca45115ffbac5571f2e66fa76';
	$text = urlencode($query);
	$flickUrl = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$apiKey.'&text='.$text.'&content_type=1&format=json&nojsoncallback=1';
	//echo $flickUrl; 
	 $sampleUrl = file_get_contents($flickUrl);
	 $jsonDecode = json_decode($sampleUrl, true);
	 //print_r($jsonDecode);
	// //connect to the flickr api and retrieve one image for testing
	 $numPages = $jsonDecode['photos']['pages']; //gets the number of pages. 
	 $total = $jsonDecode['photos']['total'];
	 $total2 = 'a'; 
	 if ($total2 == 'a'){ $total2 = $total; }
	 $m = new MongoClient();  //start a new mongo client
	 $loopCount = 1; 
	for($y = 1; $y <= $numPages; $y++)
	{
		//echo $flickUrl.'&page='.$y; echo "<br/>";
		$sampleUrl2 = file_get_contents($flickUrl.'&page='.$y); //start on the first page 
		$jsonDecode2 = json_decode($sampleUrl2,true); //decode each on of the pages 
		//var_dump($jsonDecode2['photos']['photo']);  echo "<br/><br/>";
		$numItems = count($jsonDecode2['photos']['photo']); // gets the number items per page
		 for( $h = 0; $h <= $numItems-1; $h++) //ADD NUM ITEMS
		 { //get each items id, farm, server, and secret numbers 
		 	$sampleUrl2 = file_get_contents($flickUrl.'&page='.$y); //start on the first page 
			$jsonDecode2 = json_decode($sampleUrl2,true); //decode each on of the pages 
		 	$singlePhotoId = $jsonDecode2['photos']['photo'][$h]['id'];
		 	$singlePhotoFarm = $jsonDecode2['photos']['photo'][$h]['farm'];
		 	$singlePhotoServer = $jsonDecode2['photos']['photo'][$h]['server'];
		 	$singlePhotoSecret = $jsonDecode2['photos']['photo'][$h]['secret'];
		 	//convert each of the items on each page to a new URL to retrieve the photo url 
		 	$baseUrl = "https://";
		 	$imgUrl2 = "farm".$singlePhotoFarm.".staticflickr.com/".$singlePhotoServer."/".$singlePhotoId."_".$singlePhotoSecret.".jpg";
				// insert the new image to the mongodb database
					$db = $m->images; //use database "images"
					$collection = $db->newImages; //use the collection "new images"
					$findPointer = array('imgSrc'=>$imgUrl2); //create file pointer that will be used to find teh image
					$count = $collection->find($findPointer)->count(); //count # of items already in the database. 
					//construct the json object that will be entered into the collection if there is not a image with the same name already been added. 
					$document = array("imgSrc"=>$imgUrl2 );
					if($count == 0) //if the document does not exsist then add a new record.
					{
					 	$collection->insert($document); 

					 	if ( $loopCount == floor($total * .10))
					 	{
					 		echo '...10% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * .20))
					 	{
					 		echo '...20% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * .30))
					 	{
					 		echo '...30% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * 40))
					 	{
					 		echo '...40% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * .50))
					 	{
					 		echo '...50% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * .60))
					 	{
					 		echo '...60% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * .70))
					 	{
					 		echo '...70% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * .80))
					 	{
					 		echo '...80% of images downloaded in set <br/>';
					 	}

					 	if ( $loopCount == floor($total * .90))
					 	{
					 		echo '...90% of images downloaded in set <br/>';
					 	}
					 	//echo $loopCount." of ".$total2; echo "<br/>";
					 	ob_flush();
					 	flush();
					 	$loopCount++;
					}
					else{
						$total2--;
					}
		 }
	}
	echo '...100% of images downloaded in set <br/>';
	echo "<hr>";
	ob_flush();
	flush();
}
	mail('jutt@codedcontainer.com', 'New image database download complete!', 'All images have been added to new image database!');
?>