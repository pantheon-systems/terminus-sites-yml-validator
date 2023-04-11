<?php

namespace Pantheon\TerminusYmlValidator\Validator;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Exception\ParseException;

class SitesFromYamlTest extends TestCase
{
    /**
     * Tests reading, parsing, and validating a sites.yml file.
     *
     * @dataProvider validateSitesFromFilePathTestValues
     *
     */
    public function testValidateSitesFromFilePath($fixture_yml_file, $expectedException, $exceptionErrorMessage = null): void
    {
        if ($expectedException) {
            $this->expectException($expectedException);
        } else {
            $this->expectNotToPerformAssertions();
        }
        $v = new SitesValidator();

        $fp = __DIR__ . '/../fixtures/sites/' . $fixture_yml_file;
        $v->ValidateFromFilePath($fp);
    }

    /**
     * Data provider for testValidateSitesFromFilePath.
     *
     * Return an array of arrays, each of which contains the parameter
     * values to be used in one invocation of the testValidateSitesFromFilePath test function.
     */
    public function validateSitesFromFilePathTestValues(): array
    {
        return [
            "valid api only" => ["valid_api_only.yml",null],
            "invalid api version" => ["invalid_api_only.yml",Exception::class,"Invalid API version."],
            "full valid with comments" => ["valid.yml",null],
            "bad yaml" => ["bad_yml.yml",ParseException::class],
            "string as key" => ["invalid_string_as_key.yml",Exception::class,'key "31" is not an integer.']
        ];
    }
}
