<?php

declare(strict_types=1);

namespace Pantheon\TerminusYmlValidator\Commands;

use Pantheon\Terminus\Commands\TerminusCommand;
use Pantheon\TerminusYmlValidator\Validator\SitesValidator;

class SitesYmlValidatorCommand extends TerminusCommand
{
    /**
     * Validate a sites.yml file.
     *
     * @command validate:sites
     * @param string $file sites.yml filepath
     * @usage <file_path> Validates that the yml file at <file_path> matches a valid sites.yml schema.
     * @aliases validate-sites
     */
    public function validateSites(string $file): void
    {
        $v = new SitesValidator();
        $v->ValidateFromFilePath($file);
        $this->log()->notice("$file is valid!");
    }
}
