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

    public function clearOutput()
    {
        $dirs = glob($this->target('output') . '/**');

        foreach ($dirs as $key => $value) {
            if (is_dir($value)) {
                // rmdir($value);
                exec("rm -rfv $value");
            }
        }
    }
}