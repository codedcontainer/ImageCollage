<?php
 ini_set('display_errors',1);
 ini_set('display_startup_errors',1);
 error_reporting(-1);  //add error reporting that is not working
$inFile = "flash.jpg"; //image to use
// Get the image height and width. 
$imgSize = getimagesize($inFile);
$imgWidth = $imgSize[0]; //width of the image
$imgHeight = $imgSize[1]; //height of the image 

//number of images per row and column
$rowCol = 50;

$imgWidthA = $imgWidth / $rowCol;
$imgHeightA = $imgHeight / $rowCol; 
$imgWidthD = $imgWidth / $rowCol;
$imgHeightD = $imgHeight / $rowCol; 
/*********************************************
*   Add all of the Y cordinates to an array. *
*   Add of the X cordinates to an array. 	 *
/********************************************/

//Add all of the y cordinates to the array starting from 0 
$imgHeightArray = array();  

for ($a = 0; $a <= $rowCol; $a++)
{
	array_push($imgHeightArray, $imgHeightA * $a );
	$imgHeightD += $imgHeightD; // add the imageheight to itself. 
}

//print_r($imgHeightArray);
//Add all of the x cordinates to the array starting from 0 
$imgWidthArray = array(); 
for ($i = 0; $i <= $rowCol; $i++)
{
	array_push($imgWidthArray, $imgWidthA * $i );
}

/*********************************************
*       Crop and Add Images To Screen     	 *
/********************************************/
//go through each row and get each image subset 
//$image2 = new Imagick($inFile); //get the image that you are intersted in looking at 
	//$image2->cropImage($imgWidthA, $imgHeightA, 0, 0) ; 
//echo "<img src='data:image/jpg;base64,".base64_encode($image2)."' />";
echo "<div style='width:".$imgWidth."px'>";

$one = ($rowCol* 2 ) * ( $rowCol -1 );
$dif = ($rowCol * 2 ) - ($rowCol -1);

$loopCount = 1; 

for( $d = 0; $d<=$rowCol-1; $d++)
{
	for ( $a = 0; $a<=$rowCol-1; $a++)
	{
		if( $loopCount ==  $rowCol*$rowCol * .10 )
		{
			echo '..10% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * .20 )
		{
			echo '..20% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * .30 )
		{
			echo '..30% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * .40 )
		{
			echo '..40% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * .50 )
		{
			echo '..50% of images downloaded. Please be patient. '; echo "<br/>";
		} 
		if( $loopCount == $rowCol*$rowCol * .60 )
		{ 
			echo '..60% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * .70 )
		{
			echo '..70% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * .80 )
		{
			echo '..80% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * .90 )
		{
			echo '..90% of images downloaded. Please be patient. '; echo "<br/>";
		}
		if( $loopCount == $rowCol*$rowCol * 1)
		{
			echo '..100% of images downloaded. Congrats. '; echo "<br/>";
			echo '<a href="oldInsert.php">Step Two...Insert Old Images to DB </a>'; 
		}
		$loopCount++;
		$image3 = new Imagick($inFile); //get the image that you are intersted in looking at 
		$image3->cropImage($imgWidthA, $imgHeightA, $imgWidthArray[$a], $imgHeightArray[$d] ) ; 
		echo "<img src='data:image/jpg;base64,".base64_encode($image3)."' />";
		$image3->writeImage($a.'-'.$d.'.jpg'); 
		//echo "writing image ".$a.'-'.$d.'.jpg'; echo "<br/>";
		ob_flush();
		flush();
	}
}
echo "</div>";
ob_flush();
flush();