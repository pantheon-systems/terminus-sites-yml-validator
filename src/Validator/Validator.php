<?php

declare(strict_types=1);

namespace Pantheon\TerminusYmlValidator\Validator;

use Exception;
use Symfony\Component\Yaml\Yaml;

class Validator
{
    public function validateFromFilePath(string $filePath): void
    {
        $yFile = file_get_contents($filePath);
        if ($yFile === false) {
            throw new Exception("Error reading YAML file: $filePath");
        }
        $this->validateFromYaml($yFile);
    }

    public function validateFromYaml(string $y): void
    {
        $s = Yaml::parse($y);
        $this->validate($s);
    }
}
