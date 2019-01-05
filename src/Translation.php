<?php

namespace Pointdeb\Translator;

use Throwable;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Translation
{

    /**
     * Create dynamic translation file generator for laravel framework
     * @param string $key key.key2.key3.key4
     * @param array $translations ['en' => 'value', 'fr' => 'valeur']
     * @param $resourcePath
     * @return bool
     */
    public static function saveToFile(string $key, array $translations, $resourcePath): bool
    {
        $parts = explode('.', $key);
        $filename = $parts[0];
        unset($parts[0]);

        foreach ($translations as $key => $content) {
            $langPath = "$resourcePath/$key";
            if (!is_dir($langPath)) {
                mkdir($langPath);
            }

            $filePath = "$langPath/$filename.php";

            if (is_file($filePath)) {
                $contents = file_get_contents($filePath);
            } else {
                $contents = "<?php\n\$contents = [];";
            }

            $contents = str_replace("\nreturn \$contents;\n", '', $contents);

            $keys = array_map(function ($item) {
                return "['$item']";
            }, $parts);

            $contents .= "\n";

            $contents .= '$contents' . implode('', $keys) . " = \"$content\";";

            $contents .= "\n";
            $contents .= 'return $contents;';
            $contents .= "\n";

            file_put_contents($filePath, $contents);
        }
        return true;
    }


    /**
     * Create an array of translation as key and values from excel
     * @param string $excelPath
     * @return array
     */
    public static function getFromExcel(string $excelPath): array
    {

        if (!is_file($excelPath)) {
            throw new Exception("File not found $excelPath");
        }

        $reader = IOFactory::createReader("Xlsx");
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($excelPath);

        $result = [];

        $sheet = $spreadsheet->getActiveSheet();

        $headerRowStart = 1;
        $headerColumnStart = 2;

        $headers = [];
        $header = $sheet->getCellByColumnAndRow($headerColumnStart, $headerRowStart)->getValue();

        while(!empty($header)) {
            $headers[$headerColumnStart . '-' .$headerRowStart] =  $header;
            $headerColumnStart++;
            $header = $sheet->getCellByColumnAndRow($headerColumnStart, $headerRowStart)->getValue();
        }


        $keyRowStart = 2;
        $keyColumnStart = 1;
        $key = $sheet->getCellByColumnAndRow($keyColumnStart, $keyRowStart)->getValue();

        while(!empty($key)) {

            $valueColumnStart = 2;
            $valueRowStart = $keyRowStart;

            $values = [];

            $value = $sheet->getCellByColumnAndRow($valueColumnStart, $valueRowStart)->getValue();

            while(!empty($value)) {
                $lang = $headers[$valueColumnStart . '-' .$headerRowStart];
                $values[$lang] = $value;
                $valueColumnStart++;
                $value = $sheet->getCellByColumnAndRow($valueColumnStart, $valueRowStart)->getValue();
            }

            $result[$key] = $values;

            $keyRowStart++;
            $key = $sheet->getCellByColumnAndRow($keyColumnStart, $keyRowStart)->getValue();
        }

        return $result;
    }

    /**
     * Merge of getFromExcel and saveToFile
     * @param string $excelPath
     * @param $resourcePath
     * @return bool
     */
    public static function saveToFileFromExcel(string $excelPath, string $resourcePath): bool
    {

        $datas = self::getFromExcel($excelPath);
        foreach ($datas as $key => $data) {
            self::saveToFile($key, $data, $resourcePath);
        }
        return true;
    }
}