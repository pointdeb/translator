<?php

namespace Pointdeb\Tests\Features;

use Pointdeb\Tests\TestCase;

use Pointdeb\Translator\Translation;

class TranslationTest extends TestCase
{

    public function setup()
    {
        $this->clearOutput();
    }

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

            "about.contact" => [
                "en" => "Contact",
                "fr" => "Contacter",
                "mg" => "Hifandray"
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

        $outputPath = $this->target('output');

        foreach ($datas as $key => $data) {
            $result = Translation::saveToFile($key, $data, $outputPath);
            $this->assertTrue($result);
        }


        $this->assertTrue(is_file("$outputPath/en/home.php"));
        $this->assertTrue(is_file("$outputPath/fr/home.php"));
        $this->assertTrue(is_file("$outputPath/mg/home.php"));

        $this->assertTrue(is_file("$outputPath/en/about.php"));
        $this->assertTrue(is_file("$outputPath/fr/about.php"));
        $this->assertTrue(is_file("$outputPath/mg/about.php"));

        $values = require("$outputPath/en/home.php");
        $this->assertTrue(is_array($values), json_encode($values));
        $this->assertTrue(key_exists('cover', $values), json_encode($values));
        $this->assertTrue(key_exists('greeting', $values['cover']), json_encode($values['cover']));
        $this->assertTrue($values['cover']['greeting'] == "Hello world", json_encode($values['cover']['greeting']));

        $values = require("$outputPath/fr/home.php");
        $this->assertTrue(is_array($values), json_encode($values));
        $this->assertTrue(key_exists('cover', $values), json_encode($values));
        $this->assertTrue(key_exists('greeting', $values['cover']), json_encode($values['cover']));
        $this->assertTrue($values['cover']['greeting'] == "Salut les gens", json_encode($values['cover']['greeting']));


        $values = require("$outputPath/mg/home.php");
        $this->assertTrue(is_array($values), json_encode($values));
        $this->assertTrue(key_exists('cover', $values), json_encode($values));
        $this->assertTrue(key_exists('greeting', $values['cover']), json_encode($values['cover']));
        $this->assertTrue($values['cover']['greeting'] == "Salama tompoko", json_encode($values['cover']['greeting']));
    }


    public function testGetFromExcel()
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

            "about.contact" => [
                "en" => "Contact",
                "fr" => "Contacter",
                "mg" => "Hifandray"
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

        $modelPath = $this->target('models/translation.model.xlsx');

        $result = Translation::getFromExcel($modelPath);

        $this->assertEquals($datas, $result);
    }

    public function testSaveToFileFromExcel()
    {
        $outputPath = $this->target('output');
        $modelPath = $this->target('models/translation.model.xlsx');

        $result = Translation::saveToFileFromExcel($modelPath, $outputPath);
        $this->assertTrue($result);

        $this->assertTrue(is_file("$outputPath/en/home.php"));
        $this->assertTrue(is_file("$outputPath/fr/home.php"));
        $this->assertTrue(is_file("$outputPath/mg/home.php"));

        $this->assertTrue(is_file("$outputPath/en/about.php"));
        $this->assertTrue(is_file("$outputPath/fr/about.php"));
        $this->assertTrue(is_file("$outputPath/mg/about.php"));

        $values = require("$outputPath/en/home.php");
        $this->assertTrue(is_array($values), json_encode($values));
        $this->assertTrue(key_exists('cover', $values), json_encode($values));
        $this->assertTrue(key_exists('greeting', $values['cover']), json_encode($values['cover']));
        $this->assertTrue($values['cover']['greeting'] == "Hello world", json_encode($values['cover']['greeting']));

        $values = require("$outputPath/fr/home.php");
        $this->assertTrue(is_array($values), json_encode($values));
        $this->assertTrue(key_exists('cover', $values), json_encode($values));
        $this->assertTrue(key_exists('greeting', $values['cover']), json_encode($values['cover']));
        $this->assertTrue($values['cover']['greeting'] == "Salut les gens", json_encode($values['cover']['greeting']));

        $values = require("$outputPath/mg/home.php");
        $this->assertTrue(is_array($values), json_encode($values));
        $this->assertTrue(key_exists('cover', $values), json_encode($values));
        $this->assertTrue(key_exists('greeting', $values['cover']), json_encode($values['cover']));
        $this->assertTrue($values['cover']['greeting'] == "Salama tompoko", json_encode($values['cover']['greeting']));
    }

}