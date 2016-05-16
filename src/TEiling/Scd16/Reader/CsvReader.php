<?php

namespace TEiling\Scd16\Reader;

class CsvReader implements CsvReaderInterface
{
    /**
     * @param string $filePath
     *
     * @return array
     */
    public function readCsv($filePath)
    {
        $csvArray = [];
        if (file_exists($filePath)) {
            $file = fopen($filePath, 'r');
            $columnNames = array();

            foreach (fgetcsv($file) as $columnName) {
                $columnNames[] = utf8_encode($columnName);
            }

            while (($line = fgetcsv($file)) !== false) {
                $row = array_combine($columnNames, $line);

                foreach ($row as &$column) {
                    if ($column === '') {
                        $column = false;
                    } else {
                        $column = utf8_encode($column);
                    }
                }
                unset($column);
                $csvArray[] = $row;
            }

            fclose($file);
        }

        return $csvArray;
    }
}
