<?php

declare(strict_types=1);

namespace Pantheon\TerminusYmlValidator\Validator;

use Exception;

const MAX_DOMAIN_MAPS = 25;
const VALID_HOSTNAME_REGEX = '/^([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])(\.([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]))*$/';
const VALID_MULTIDEV_NAME_REGEX = '/^[a-z0-9\-]{1,11}$/';

class SitesValidator extends Validator
{
    public function validate(array $sites): void
    {
        if (! array_key_exists("api_version", $sites)) {
            throw new Exception("API version missing.");
        }
        $this->ValidateAPIVersion($sites["api_version"]);

        if (! array_key_exists("domain_maps", $sites)) {
            return;
        }
        $this->ValidateDomainMaps($sites["domain_maps"]);
    }

    private function validateAPIVersion(int $apiVersion): void
    {
        // Make this more robust once we have a second API version.
        if ($apiVersion === 1) {
            return;
        }
        throw new Exception("Invalid API version.");
    }

    private function validateDomainMaps(array $domainMaps): void
    {
        foreach ($domainMaps as $env => $domainMap) {
            if (!preg_match(VALID_MULTIDEV_NAME_REGEX, $env)) {
                throw new Exception(
                    sprintf('"%s" is not a valid environment name', $env)
                );
            }
            $domainMapCount = count($domainMap);
            if ($domainMapCount > MAX_DOMAIN_MAPS) {
                throw new Exception(
                    sprintf('"%s" has too many domains listed (%d). Maximum is %d', $env, $domainMapCount, MAX_DOMAIN_MAPS)
                );
            }
            foreach ($domainMap as $blog_key => $domain) {
                var_dump($blog_key);
                if (!is_int($blog_key)) {
                    throw new Exception(sprintf('key "%s" is not an integer.', $blog_key));
                }
                if (!preg_match(VALID_HOSTNAME_REGEX, $domain)) {
                    throw new Exception(
                        sprintf('"%s" is not a valid hostname', $domain)
                    );
                }
            }
        }
    }
}
