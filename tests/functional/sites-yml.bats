#!/usr/bin/env bats

SELF_DIRNAME="$(dirname -- "$0")"

FIXTURES_DIR="${SELF_DIRNAME}/../../../tests/fixtures/"

@test "run validate:sites" {
  run terminus validate:sites "${FIXTURES_DIR}/sites/valid_api_only.yml"
  [[ $output == *"is valid!"* ]]
  [ "$status" -eq 0 ]
}

@test "run validate-sites" {
  run terminus validate-sites "${FIXTURES_DIR}/sites/valid_api_only.yml"
  [[ $output == *"is valid!"* ]]
  [ "$status" -eq 0 ]
}