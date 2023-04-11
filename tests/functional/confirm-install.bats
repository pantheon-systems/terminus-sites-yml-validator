#!/usr/bin/env bats

#
# confirm-install.bats
#
# Ensure that Terminus and the Composer plugin have been installed correctly
#

@test "confirm terminus version" {
  terminus --version
}

@test "get help on validate:sites command" {
  run terminus help validate:sites
  [[ $output == *"Validate a sites.yml file."* ]]
  [ "$status" -eq 0 ]
}
