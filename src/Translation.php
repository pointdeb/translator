<?php

namespace Pointdeb\Translator;

use Throwable;

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
        try {

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
        } catch (Throwable $e) {
            return false;
        }
    }
}