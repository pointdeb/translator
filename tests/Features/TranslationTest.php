<?php

namespace Pointdeb\Tests\Features;

use Pointdeb\Tests\TestCase;

use Pointdeb\Translator\Translation;

class TranslationTest extends TestCase {

    public function testSaveToFile()
    {
        $datas = [
            "home.cover.greeting" => [
                "en" => "Hello world",
                "fr" => "Salut les gens",
                "mg" => "Salama tompoko"
            ],
            "home.cover.getstarted" => [
                "en" => "Get Started",
                "fr" => "Commencer",
                "mg" => "Manomboka"
            ],

            "about.contact.phone" => [
                "en" => "Mobile",
                "fr" => "Telephone",
                "mg" => "Finday"
            ],
            "about.contact.email" => [
                "en" => "Email",
                "fr" => "Email",
                "mg" => "Tranokala"
            ],
        ];

        foreach($datas as $key => $data) {
            $result = Translation::saveToFile($key, $data);
        }

        $outputPath = $this->target('output');

        $this->assertTrue(is_file("$outputPath/en/home.php"));
        $this->assertTrue(is_file("$outputPath/fr/home.php"));
        $this->assertTrue(is_file("$outputPath/mg/home.php"));

        $this->assertTrue(is_file("$outputPath/en/about.php"));
        $this->assertTrue(is_file("$outputPath/fr/about.php"));
        $this->assertTrue(is_file("$outputPath/mg/about.php"));
    }

}