<?php

namespace Pantheon\TerminusYmlValidator\Validator\Sites;

use Exception;
use Symfony\Component\Yaml\Yaml;

const MAX_DOMAIN_MAPS = 25;
const VALID_HOSTNAME_REGEX = '/^([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])(\.([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]))*$/';
const VALID_MULTIDEV_NAME_REGEX = '/^[a-z0-9\-]{1,11}$/';

class SitesValidator
{
    public function validateFromYaml($y)
    {
        $s = Yaml::parse($y);
        return $this->validate($s);
    }

    public function validateFromFilePath($filePath)
    {
        $yFile = file_get_contents($filePath);
        if ($yFile === false) {
            throw new Exception("Error reading YAML file: $filePath");
        }
        return $this->validateFromYaml($yFile);
    }

    private function validate($sites)
    {
        $err = $this->validateAPIVersion($sites["apiVersion"]);
        if ($err !== null) {
            return $err;
        }
        return $this->validateDomainMaps($sites["domainMaps"]);
    }

    private function validateDomainMaps($domainMaps)
    {
        foreach ($domainMaps as $env => $domainMap) {
            if (!preg_match(VALID_MULTIDEV_NAME_REGEX, $env)) {
                return sprintf('"%s" is not a valid environment name', $env);
            }
            $domainMapCount = count($domainMap);
            if ($domainMapCount > MAX_DOMAIN_MAPS) {
                return sprintf('"%s" has too many domains listed (%d). Maximum is %d', $env, $domainMapCount, MAX_DOMAIN_MAPS);
            }
            foreach ($domainMap as $domain) {
                if (!preg_match(VALID_HOSTNAME_REGEX, $domain)) {
                    return sprintf('"%s" is not a valid hostname', $domain);
                }
            }
        }
        return null;
    }

    private function validateAPIVersion($apiVersion)
    {
        if ($apiVersion !== 1) {
            return new Exception("Invalid API version");
        }
        return null;
    }
}
