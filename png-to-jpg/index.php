<?php
/*
 *---------------------------------------------------------------
 * Jahir Higuera - php developer at damos.co
 * Github: masterrjj24
 *---------------------------------------------------------------
 *
 *  - configuration --
 *
 */
$deleteOrigen = true;
$compresion1to100 = 90;



/*
 *---------------------------------------------------------------
 * CONVERT ALL PNG FILES TO JPG INSIDE THIS DIRECTORY
 *---------------------------------------------------------------
 *
 *  - comment here --
 *
 */
$absolutePathToThisFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$aFiles = scandir( $absolutePathToThisFolder );
$auxConvertedFiles = [];

foreach ( $aFiles as $file )
{
    $sAbsolutePathToFile = $absolutePathToThisFolder . $file;
    $extensionFile = pathinfo($sAbsolutePathToFile, PATHINFO_EXTENSION);


    if ( is_file($sAbsolutePathToFile) )
    {

    	if ($extensionFile === 'png')
    	{
    		// Borramos jpg antes de crear jpg
    		$absolutePathNewFile = str_replace('.png', '', $sAbsolutePathToFile);

    		if ( is_file($absolutePathNewFile.'.jpg') ) {
    			unlink($absolutePathNewFile.'.jpg');
    		}

    		// Creamos jpg
    		$image = imagecreatefrompng($sAbsolutePathToFile);
			$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
			imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
			imagealphablending($bg, TRUE);
			imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
			imagedestroy($image);
			$quality = $compresion1to100; // 0 = worst / smaller file, 100 = better / bigger file
			imagejpeg($bg, $absolutePathNewFile . ".jpg", $quality);
			imagedestroy($bg);

			// Creamos log de tareas realizadas
			$auxConvertedFiles[] = $absolutePathNewFile . ".jpg";

			if ($deleteOrigen) {
				unlink($sAbsolutePathToFile);
			}

    	}

    }

}


foreach ($auxConvertedFiles as $file) {
	echo '<br>Converted file: '.$file;
}




/*
 *---------------------------------------------------------------
 * Inspiration from: https://stackoverflow.com/questions/1201798/use-php-to-convert-png-to-jpg-with-compression
 *---------------------------------------------------------------
 *
 *  - comment here --
 *  Do this to convert safely a PNG to JPG with the transparency in white.

	$image = imagecreatefrompng($filePath);
	$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
	imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
	imagealphablending($bg, TRUE);
	imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
	imagedestroy($image);
	$quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
	imagejpeg($bg, $filePath . ".jpg", $quality);
	imagedestroy($bg);


	shareimprove this answer
	edited Oct 1 '14 at 10:55
	user669677
	answered Jan 21 '12 at 8:00

	Daniel De León
	10.3k55 gold badges6868 silver badges58
 *
 */
?>