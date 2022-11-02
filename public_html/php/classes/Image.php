<?php
require_once dirname(__FILE__) .'/../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;


if ($_FILES["image"]["error"] > 0) {
    echo "Error: " . $_FILES["image"]["error"] . "<br />";
} else {
    $imagePath = $_FILES["image"]["tmp_name"];
    $imageTitle = $_POST['title'];
    Configuration::instance([
        'cloud' => [
            'cloud_name' => 'dhzn9musm',
            'api_key' => '364195656183668',
            'api_secret' => 'djFdPLL9D2O2lxNxApJNBxVY1iY'
        ],

        'url' => [
            'secure' => true
        ]
    ]);

    /*  $data =  (new UploadApi())->upload("img/AutoCad.jpg", */
    $data =  (new UploadApi())->upload(
        $imagePath,
        [
            'folder' => 'SL Visuals/',
            'public_id' => $imageTitle,
            'overwrite' => true,
        ],
    );
    //print_r($data);
    $imageLink = "v" . $data['version'] . "/" . $data['public_id'];
    $query  = $conn->prepare("INSERT INTO gallery (image,title) VALUES ('$imageLink','$imageTitle')");
    $result = $query->execute();
}