<?php


namespace app\models;

use \SplFileObject;

class ConvertCsv
{
    private $fileDir;
    private $fileName;
    private $fileInput;
    private $fileOutput;

    public function __construct(string $pathFile)
    {
        $this->fileName = pathinfo($pathFile)['filename'];
        $this->fileDir = pathinfo($pathFile)['dirname'];
    }

    public function getFileName()
    {
        echo $this->fileName;
    }

    protected function getHeader()
    {
        $this->fileInput->rewind();
        return $this->fileInput->current();
    }

    protected function getData()
    {
        while (!$this->fileInput->eof()) {
            yield $this->fileInput->fgetcsv();
        }
    }

    protected function writeData($file, $values)
    {
        if ($values[0]) {
            $values = '"' . implode('","', $values) . '"';
            $string = "($values)\n";
            $file->fwrite($string);
        }
    }

    protected function writeHeader($file, $headers)
    {
        $headers = implode(',', $headers);
        $string = "INSERT INTO $this->fileName ($headers)\nVALUES";
        $file->fwrite($string);
    }

    public function import()
    {

        $this->fileInput = new SplFileObject("$this->fileDir/$this->fileName.csv");
        $this->fileInput->setFlags(SplFileObject::READ_CSV);

        $this->fileOutput = new SplFileObject("$this->fileDir/$this->fileName.sql", 'w');
        $this->writeHeader($this->fileOutput, $this->getHeader());

        foreach ($this->getData() as $values) {
            $this->writeData($this->fileOutput, $values);
        }


    }

}
