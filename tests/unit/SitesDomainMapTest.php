<?php

namespace Pantheon\TerminusYmlValidator\Validator;

use Exception;
use PHPUnit\Framework\TestCase;

class SitesDomainMapTest extends TestCase
{
    /**
     * Tests our sites.yml validator method.
     *
     * @dataProvider apiVersionTestValues
     *
     */
    public function testApiVersion($domainMap, $expectedException, $exceptionErrorMessage = null): void
    {
        $input = ["api_version" => 1, "domain_maps" => $domainMap];

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
            "invalid domain maps long env" => [
                [
                    "mylongmultidevname" => [1 => "site1.mylongmultidevname-mysite.pantheonsite.io"],
                ],
                Exception::class,
                '"mylongmultidevname" is not a valid environment name'
            ],
            "invalid domain maps bad env name" => [
                [
                    "feat_branch" => [ 1 => "site1.feat-branch-mysite.pantheonsite.io" ],
                ],
                Exception::class,
                '"feat_branch" is not a valid environment name'
            ],
            "invalid domain maps too many domains" => [
                [
                    "dev" => [
                        1 =>  "site1.dev-mysite.pantheonsite.io",
                        2 =>  "site2.dev-mysite.pantheonsite.io",
                        3 =>  "site3.dev-mysite.pantheonsite.io",
                        4 =>  "site4.dev-mysite.pantheonsite.io",
                        5 =>  "site5.dev-mysite.pantheonsite.io",
                        6 =>  "site6.dev-mysite.pantheonsite.io",
                        7 =>  "site7.dev-mysite.pantheonsite.io",
                        8 =>  "site8.dev-mysite.pantheonsite.io",
                        9 =>  "site9.dev-mysite.pantheonsite.io",
                        10 => "site10.dev-mysite.pantheonsite.io",
                        11 => "site11.dev-mysite.pantheonsite.io",
                        12 => "site12.dev-mysite.pantheonsite.io",
                        13 => "site13.dev-mysite.pantheonsite.io",
                        14 => "site14.dev-mysite.pantheonsite.io",
                        15 => "site15.dev-mysite.pantheonsite.io",
                        16 => "site16.dev-mysite.pantheonsite.io",
                        17 => "site17.dev-mysite.pantheonsite.io",
                        18 => "site18.dev-mysite.pantheonsite.io",
                        19 => "site19.dev-mysite.pantheonsite.io",
                        20 => "site20.dev-mysite.pantheonsite.io",
                        21 => "site21.dev-mysite.pantheonsite.io",
                        22 => "site22.dev-mysite.pantheonsite.io",
                        23 => "site23.dev-mysite.pantheonsite.io",
                        24 => "site24.dev-mysite.pantheonsite.io",
                        25 => "site25.dev-mysite.pantheonsite.io",
                        26 => "site26.dev-mysite.pantheonsite.io",
                        27 => "site27.dev-mysite.pantheonsite.io",
                        28 => "site28.dev-mysite.pantheonsite.io",
                        29 => "site29.dev-mysite.pantheonsite.io",
                    ],
                ],
                Exception::class,
                '"dev" has too many domains listed (29). Maximum is 25'
            ],
            "invalid hostname" => [
                [
                    "test" => [
                        1 => "$(sudo do something dangerous)",
                    ],
                ],
                Exception::class,
                '"$(sudo do something dangerous)" is not a valid hostname'
            ],
            "invalid site id key is string that looks like int" => [
                [
                    "test" => [
                        "31" => "siteOne.dev-mysite.pantheonsite.io",
                    ],
                ],
                Exception::class,
                'key "31" is not an integer.'
            ],
            "invalid site id key is string" => [
                [
                    "test" => [
                        "one" => "siteOne.dev-mysite.pantheonsite.io",
                    ],
                ],
                Exception::class,
                'key "one" is not an integer.'
            ]
        ];
    }
}
