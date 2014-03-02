<?php

require_once __DIR__ . "/vendor/autoload.php";

use CodeAnalyzer\CodeAnalyzer;
use CodeAnalyzer\Configuration;
use CodeAnalyzer\Result\File;
use Gitonomy\Git\Repository;

CodeAnalyzer::configure(function(Configuration $configuration) {

    $configuration->collect(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE)
        ->includeFile(function(File $file) {
            return $file->matchPath('\/src');
        })
        ->excludeFile(function(File $file) {
            return $file->matchPath('\/spec') || $file->matchPath('\/vendor');
        });

});


$analyzer = new CodeAnalyzer();
$analyzer->start();

$defaultArgv = array('./vendor/bin/pho', '--reporter', 'spec');

$argv = array_merge($defaultArgv, array(
    'spec/ConfigurationSpec.php',
    'spec/ResultSpec.php',
    'spec/Result/FileSpec.php',
    'spec/Result/LineSpec.php'
));

require_once __DIR__ . "/vendor/bin/pho";


$analyzer->stop();

$result = $analyzer->getResult()->getFiles();


$coveralls = array(
    'repo_token' => 'jesEbmJxLyHbB2Lnl1wvqkMK1TRH9qjHW',
    'source_files' => array()
);

$sourceFiles = array();

foreach ($result as $file) {
    $source = trim(file_get_contents($file->getPath()));

    $lines = explode("\n", $source);
    $lineResults = array_pad(array(), count($lines), null);

    $coverageLines = $file->getLines();
    foreach ($coverageLines as $line) {
        if ($line->isExecuted() === false) {
            continue;
        }
        $lineResults[$line->getLineNumber() - 1] = 1;
    }
    $sourceFiles[] = array(
        'name' => $file->getPath(),
        'source' => $source,
        'coverage' => array_values($lineResults),
    );
}

$repository = new Repository('./');
$commit = $repository->getHeadCommit();
$branches = $repository->getReferences()->resolveBranches($commit);

$localBranch = null;

foreach ($branches as $branch) {
    if ($branch->isRemote() === true) {
        continue;
    }
    $localBranch = $branch;
}

$remotes = $repository->run('remote', array('-v'));
$remotes = explode("\n", $remotes);

$remoteMap = array();

foreach ($remotes as $remote) {
    if (empty($remote) === true) {
        continue;
    }
    preg_match("/(.+)\s(.+\.git)/", $remote, $mathes);

    $name = $mathes[1];
    $url = $mathes[2];

    $remoteMap[$name] = array(
        'name' => $name,
        'url' => $url
    );
}

$remotes = array_values($remoteMap);

$git = array(
    'head' => array(
        'id' => $commit->getHash(),
        'author_name' => $commit->getAuthorName(),
        'author_email' => $commit->getAuthorEmail(),
        'committer_name' => $commit->getCommitterName(),
        'committer_email' => $commit->getCommitterEmail(),
        'message' => $commit->getMessage()
    ),
    'branch' => $localBranch->getName(),
    'remotes' => $remotes
);

$coveralls['git'] = $git;
$coveralls['source_files'] = $sourceFiles;

file_put_contents('coverage.json', json_encode($coveralls));

use Guzzle\Http\Client;

$client = new Client();
$request = $client->post('https://coveralls.io/api/v1/jobs')
    ->addPostFiles(array(
        'json_file' => realpath(__DIR__ . '/coverage.json')
    ));

$request->send();

