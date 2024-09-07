<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Rekognition\RekognitionClient;
use Aws\Exception\AwsException;

// AWS configuration
$awsRegion = 'your-region'; // e.g., 'us-west-2'
$bucket = 'your-bucket-name'; // Your S3 bucket name

// Initialize S3 and Rekognition clients
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => $awsRegion
]);

$rekognition = new RekognitionClient([
    'version' => 'latest',
    'region'  => $awsRegion
]);

header('Content-Type: application/json');

$responseData = [];

if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['photo']['tmp_name'];
    $fileName = $_FILES['photo']['name'];

    try {
        // Upload to S3 without specifying ACL
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key'    => $fileName,
            'SourceFile' => $tmpName
        ]);

        // Generate the S3 URL of the uploaded image
        $imageUrl = $s3->getObjectUrl($bucket, $fileName);
        $responseData['imageUrl'] = $imageUrl;

        // Analyze with Rekognition
        $rekognitionResponse = $rekognition->detectLabels([
            'Image' => [
                'S3Object' => [
                    'Bucket' => $bucket,
                    'Name'   => $fileName,
                ],
            ],
            'MaxLabels' => 10,
        ]);

        // Collect labels
        $responseData['labels'] = $rekognitionResponse['Labels'];

    } catch (AwsException $e) {
        $responseData['error'] = $e->getMessage();
    }
} else {
    $responseData['error'] = 'File upload error!';
}

echo json_encode($responseData);
?>
