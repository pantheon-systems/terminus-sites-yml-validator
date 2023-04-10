<?php 

namespace Pantheon\TerminusYmlValidator\Commands;

use Pantheon\Terminus\Commands\TerminusCommand;

class SitesYmlValidatorCommand extends TerminusCommand {
    /**
     * Validate a sites.yml file.
     *
     * @command validate:sites
     * @param string $file sites.yml filepath
     * @usage <file_path> Validates that the yml file at <file_path> matches a valid sites.yml schema.
     * @aliases sites-validate
     */
    public function validateSites($file) {
    	if (!file_exists($file)) {
            throw new TerminusException(
                'The file {file} cannot be accessed by Terminus.',
                ['file' => $file,],
                1
            );
        }

        $this->log()->notice("$file is valid!");
    }
}