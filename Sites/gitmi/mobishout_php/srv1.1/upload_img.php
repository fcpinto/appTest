<?php
/**
 * User: zul
 * Date: 13/03/14
 * Time: 00:21
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');

$uploaddir = '../../../AAD/';
$allowedExts = array("gif", "jpeg", "jpg", "png");
$successfulFiles = array();
$failedFiles = array();


$files = $_FILES;

echo count($files);

echo '||';

for($i=0; $i<count($files); $i++){
    echo json_encode($files[$i]);
    echo ',';
}
/*for($i=0; $i<count($_FILES['file']['name']); $i++) {
    //Get the temp file path
    $fileName = $_FILES['file']['name'][$i];
    $fileType = $_FILES["file"]["type"][$i];

    $nameExplode = explode(".", $fileName);
    $extension = end($nameExplode);

    if ((($fileType == "image/gif")
            || ($fileType == "image/jpeg")
            || ($fileType == "image/jpg")
            || ($fileType == "image/pjpeg")
            || ($fileType == "image/x-png")
            || ($fileType == "image/png"))
        && in_array($extension, $allowedExts)
    ) {

        $tmpFilePath = $_FILES["file"]["tmp_name"][$i];
        //Make sure we have a filepath
        if ($tmpFilePath != "") {
            //Setup our new file path
            $newFilePath = $uploaddir . $fileName;

            //Upload the file into the temp dir
            move_uploaded_file($tmpFilePath, $newFilePath);

            array_push($successfulFiles,$fileName);
        }
    }
    else {
        array_push($failedFiles,$fileName);
    }
}
echo 'Successful:';
echo json_encode($successfulFiles);
echo 'Failed:';
echo json_encode($failedFiles);*/
