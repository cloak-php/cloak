<?php

require_once __DIR__ . "/vendor/autoload.php";

use Guzzle\Http\Client;

$client = new Client();
$request = $client->post('https://coveralls.io/api/v1/jobs')
    ->addPostFields(array(
        'service_name' => 'travis-ci',
        'repo_token' => 'jUiZAATYplPIeW66eqYAziuDqwollrfLe'
    ))
    ->addPostFiles(array(
        'json_file' => realpath(__DIR__ . '/coverage.json'
    )));

$request->send();
