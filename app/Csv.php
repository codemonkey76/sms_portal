<?php

namespace App;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class Csv
{
    protected string $path;

    public function __construct(UploadedFile|File|string $file, protected string $delimiter = ',')
    {
        if ($file instanceof UploadedFile || $file instanceOf File) {
            $this->path = $file->getRealPath();
        } elseif (file_exists($file)) {
            $this->path = $file;
        } else {
            throw new \InvalidArgumentException('Invalid file or path provided to Csv.');
        }
    }

    public static function from(UploadedFile|File|string $file, string $delimiter = ','): self
    {
        return new static($file, $delimiter);
    }

    public function columns(): array
    {
        return $this->openFile(fn($handle) => array_filter(fgetcsv($handle, 1000, $this->delimiter)));
    }

    public function eachRow(callable $callback): self
    {
        $this->openFile(function ($handle) use ($callback) {
            $columns = array_filter(fgetcsv($handle, 1000, $this->delimiter));

            while (($data = fgetcsv($handle, 1000, $this->delimiter)) !== false) {
                $row = [];

                foreach ($data as $i => $value) {
                    if (! isset($columns[$i])) {
                        continue;
                    }

                    $row[$columns[$i]] = $value;
                }

                $callback($row);
            }
        });

        return $this;
    }

    protected function openFile($callback)
    {
        $handle = fopen($this->path, 'r');

        if (!$handle) {
            throw new \RuntimeException("Unable to open CSV file: {$this->path}");
        }

        $result = $callback($handle);

        fclose($handle);

        return $result;
    }
}
