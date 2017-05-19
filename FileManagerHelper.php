<?php

/**
 *
 */
class FileManagerHelper
{
    private static $allowed_file_types = [
        'bmp' =>'Content-type: image/bmp',
        'gif' =>'Content-type: image/gif',
        'jpg' =>'Content-type: image/jpeg',
        'jpeg'=>'Content-type: image/jpeg',
        'png' =>'Content-type: image/png'
    ];
    public static $server_dir = '/var/share/nginx/shared/file_manager_upload/';
    private $filename;

    /**
     * FileManagerHelper constructor.
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = basename($filename);
    }

    /**
     * @return string
     */
    public function file_path()
    {
        return (self::$server_dir) . ('images/') . ($this->filename);
    }

    /**
     * @return string
     */
    public function thumb_path()
    {
        $x = (self::$server_dir) . ('thumbs/') . ($this->filename);
        return $x;
    }

    /**
     * @return bool Whether or not this file's type is allowed
     */
    public function file_type_allowed()
    {
        return in_array(strtolower(pathinfo($this->filename,PATHINFO_EXTENSION)), array_keys(self::$allowed_file_types));
    }

    /**
     * @return string MIME-type of this file
     */
    public function get_mime_type()
    {
        return self::$allowed_file_types[strtolower(pathinfo($this->filename,PATHINFO_EXTENSION))];
    }
}