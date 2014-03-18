<?php

header('Cache-Control: no-cache');
header('Pragma: no-cache');

$myurl = $_REQUEST['q'];

convert($myurl);

    function convert($myurl)
    {   
		//$myurl = 'filename.pdf['.$pagenumber.']';
		$myurl = 'cloud.pdf'; 
		
		//$myurl = ''.$myurl.'[0]';
		
		$image = new Imagick($myurl);
		$image->setResolution(212,300);
		$image->setImageFormat( "png" );
		$image->writeImage('./pdfToPng.png');

		header("Content-Type: image/png");

		//$filehandle = fopen("./image.png", "w");
		//$image->writeImageFile($filehandle);

		//$image->writeImages('image.png', false);

		//echo $image;
 		return $myurl;
  	}

?>