<?php namespace app;

use includes\Exception;

class Parser
{
    private $tmpFolder = '/tmp';                // Temp folder name
    private $tmpFile;                           // Temp file path
    private $url;                               // URL that must be parsed
    private $insideFile;                        // The name of the file inside archive to read
    private $zipData;                           // Data from zip file
    private $fileBytes = 8192;                  // Max bytes of the inside file to read (must be extended for big files)

    /**
     * Parser constructor.
     * @param $url
     * @param $sourceFolder
     * @param $insideFile
     */
    public function __construct($url, $sourceFolder, $insideFile)
    {
        $this->url = $url;
        $this->tmpFile = $sourceFolder.$this->tmpFolder.'/tmp-'.time().'.zip';
        $this->insideFile = $insideFile;

        $this->download();
        $this->read();
        $this->isJson($this->zipData);
    }

    /**
     * Deleting tmp file
     */
    public function __destruct()
    {
        unlink($this->tmpFile);
    }

    /**
     * Downloads zip file from source
     */
    private function download()
    {
        $fp = fopen ($this->tmpFile, 'x+');

        $ch = curl_init(str_replace(" ","%20",$this->url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    /**
     * Reads data from zip file and returns it content to a value
     * If JSON detected, converts it to array and returns array data
     */
    private function read()
    {
        // Opening the file inside zip archive
        $handle = fopen('zip://'.$this->tmpFile.'#'.$this->insideFile, 'r');
        while (!feof($handle)) {
            $this->zipData .= fread($handle, $this->fileBytes);
        }
        fclose($handle);
    }

    /**
     * Checks if zip file data is json format.
     * If TRUE, returns true and changes $zipData for array converted from json
     *
     * @return bool
     * @throws Exception
     */
    function isJson() {
        if(is_string($this->zipData)) {
            $json = json_decode($this->zipData, true);
            if(json_last_error() == JSON_ERROR_NONE) {
                $this->zipData = $json;
                unset($json);
            }
            return (json_last_error() == JSON_ERROR_NONE);
        } else {
            throw new Exception("File was not read properly. Maybe file is empty, corrupted, or source is invalid.");
        }
    }

    /**
     * Returns content from zip file
     * @return mixed
     * @throws Exception
     */
    public function getZipData()
    {
        if(is_string($this->zipData) || is_array($this->zipData)) {
            return $this->zipData;
        } else {
            throw new Exception("File was not read properly. Maybe file is corrupted, or source is invalid.");
        }
    }
}