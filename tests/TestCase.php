<?php

namespace Pointdeb\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function target(string $key): string
    {
      $realPaht = __DIR__ . '/../target';
      if (is_dir($realPaht)) {
        return realpath($realPaht . '/' . $key);
      } else {
        return realpath($realPaht);
      }
    }
}