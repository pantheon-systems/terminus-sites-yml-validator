<?php


namespace Pantheon\TerminusYmlValidator\Validator;

use Exception;
use PHPUnit\Framework\TestCase;

class SitesApiVersionTest extends TestCase
{
    /**
     * Tests our sites.yml validator method.
     * 
     * @dataProvider apiVersionTestValues
     * 
     */
    public function testApiVersion($input, $expectedException, $exceptionErrorMessage = null): void
    {
        if ($expectedException) {
            $this->expectException($expectedException);
        } else {
            $this->expectNotToPerformAssertions();
        }
        $v = new SitesValidator();
        $v->Validate($input);
    }

    /**
     * Data provider for testApiVersion.
     *
     * Return an array of arrays, each of which contains the parameter
     * values to be used in one invocation of the testApiVersion test function.
     */
    public function apiVersionTestValues(): array
    {
        return [
                "only api version" => [["api_version" => 1, "domain_maps" => []], null],
                "valid api version missing domain maps" => [["api_version" => 1], null],
                "invlaid api version" => [["api_version" => 2], Exception::class,"Invalid API version."],
                "missing api version" => [[], Exception::class,"API version missing."],
        ];
    }
}