<?php
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Storage\StorageClient;

function usage() {
    fprintf(STDERR, "Usage: %s [upload_file]\n", $_SERVER["argv"][0]);
    exit(1);
}

if ($_SERVER["argc"] <= 1) {
    usage();
} elseif (!file_exists($_SERVER["argv"][1])) {
    fprintf(STDERR, "ERROR: File not found: %s\n", $_SERVER["argv"][1]);
    usage();
}

# Your Google Cloud Platform project ID
$projectId = 'YOUR_PROJECT_ID';

# Instantiates a client
$storage = new StorageClient([
    'projectId' => $projectId
]);

# The name for the bucket
$bucketName = 'my-bucket';

$bucket = $storage->bucket($bucketName);

# File upload
$options = [
    'name' => basename($_SERVER["argv"][1]),
];

$object = $bucket->upload(
    fopen($_SERVER["argv"][1], 'r'),
    $options
);
