<?php

namespace App\Helpers;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;

class AwsHelper
{
    /**
     * @var S3Client
     */
    private $client;

    public function __construct()
    {
        $this->client = \App::make('aws')->createClient('s3');
    }

    /**
     * Allows to upload file to s3
     * @param UploadedFile $file
     * @param string $path - could be empty or include folder and a part of name
     * @return string - URL
     */
    public function uploadToS3(UploadedFile $file, string $path = '') : string
    {
        $photo = $this->client->putObject([
            'Bucket'     => getenv('AWS_BUCKET'),
            'Key'        => $path . '_' . uniqid() . '.' . $file->extension(),
            'SourceFile' => $file->getPathName(),
        ]);

        return $photo['ObjectURL'];
    }

    /**
     * Allows to remove old file and replace it with a new one
     * @param string|null $oldFileUrl
     * @param UploadedFile $file
     * @param string $path
     * @return string
     */
    public function replaceS3File($oldFileUrl, UploadedFile $file, string $path = '') : string
    {
        if (!empty($oldFileUrl) && strpos($oldFileUrl, '.amazonaws.com') !== false) {
            $url = parse_url($oldFileUrl);

            $this->client->deleteObject([
                'Bucket' => getenv('AWS_BUCKET'),
                'Key' => ltrim($url['path'], '/'),
            ]);
        }

        return $this->uploadToS3($file, $path);
    }

}