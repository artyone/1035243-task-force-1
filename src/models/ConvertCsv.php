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

    private function getHeader(): array
    {
        $this->fileInput->rewind();
        return $this->fileInput->current();
    }

    private function getData(): iterable
    {
        while (!$this->fileInput->eof()) {
            yield $this->fileInput->fgetcsv();
        }
    }

    private function writeData(SplFileObject $file, array $values): void
    {
        if ($values[0]) {
            $values = '"' . implode('","', $values) . '"';
            $string = "($values)\n";
            $file->fwrite($string);
        }
    }

    private function writeHeader(SplFileObject $file, array $headers): void
    {
        $headers = implode(',', $headers);
        $string = "INSERT INTO $this->fileName ($headers)\nVALUES";
        $file->fwrite($string);
    }

    public function convert()
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
