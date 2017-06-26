<?php

namespace Mutum;

use Site;

header('Content-type: application/json');


$img = new Image();

/**
 * Class Image
 * @package Mutum
 */
class Image
{
    /**
     * @throws sprintf
     */
    public function __construct()
    {
        try {
            $method = $_REQUEST['method'];
            if (!method_exists($this, $method)) {
                throw new sprintf("Method '%s' doesn't exist.", $method);

            }

            $response = $this->{$method}();
        } catch (\Excpetion $e) {
            $response = array('success' => false, 'message' => $e->getMessage());
        }

        die(json_encode($response));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function upload()
    {
        if (!count($_FILES)) {
            throw new \InvalidArgumentException('You should upload a file.');
        }

        $scope = array_keys($_FILES)[0];

        $file = $_FILES[$scope];
        if ($file['error'] != 0) {
            throw new \Exception(sprintf("Fail to upload file '%s', code: %s", $file['name'], $file['error']));
        }

        $name = $file['name'];
        preg_match("/(.*[^\.]+)\.(.*)$/", $name, $matches);
        $extension = $matches[2];
        $filename = sprintf("%s.%s", hash('md5', sprintf("%s%s", $name, time())), $extension);
        $uploadfile = sprintf("../../%s/%s/%s", UPLOADDIR, $scope, $filename);
        $webpath = sprintf("%s/%s/%s/%s", WEBDIR, UPLOADDIR, $scope, $filename);

        if (!move_uploaded_file($file['tmp_name'], $uploadfile)) {
            throw new \RuntimeException("Can't move uploaded file.");
        }

        return array('success' => true, 'filename' => $filename, 'webpath' => $webpath);
    }

    /**
     *
     */
    public function delete()
    {

    }
}


