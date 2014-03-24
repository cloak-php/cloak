<?php

require_once __DIR__ . "/../vendor/autoload.php";

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\ConfigurationBuilder;
use CodeAnalyzer\Result\File;
use Gitonomy\Git\Repository;


$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $builder->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })->excludeFile(function(File $file) {
        return $file->matchPath('/spec') || $file->matchPath('/vendor');
    });

});

$analyzer->start();


$defaultArgv = array('../vendor/bin/pho', '--reporter', 'spec');

$argv = array_merge($defaultArgv, array(
    'spec/ConfigurationSpec.php',
    'spec/ConfigurationBuilderSpec.php',
    'spec/ResultSpec.php',
    'spec/Result/FileSpec.php',
    'spec/Result/LineSpec.php',
    'spec/Result/CoverageSpec.php',
    'spec/Reporter/ReportableSpec.php',
    'spec/Reporter/TextReporterSpec.php',
    'spec/ProgressNotifierSpec.php',
    'spec/AnalyzerSpec.php'
));

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();


$result = $analyzer->getResult()->getFiles();


$jobId = getenv('TRAVIS_JOB_ID');
$jobNumber = getenv('TRAVIS_JOB_NUMBER');

$coveralls = array(
    'service_name' => 'travis-ci',
    'service_job_id' => strval($jobId) . '.' . strval($jobNumber),
    'repo_token' => '8CFNrlGgXsDPPR8r03VnIXJl6cCVnDhcO',
    'source_files' => array()
);

$sourceFiles = array();

foreach ($result as $file) {
    $source = trim(file_get_contents($file->getPath()));

    $lines = explode("\n", $source);
    $lineCount = count($lines);
    $lineResults = array_pad(array(), $lineCount, null);

    $coverageLines = $file->getLines();
    foreach ($coverageLines as $line) {
        if ($line->getLineNumber() <= 0 || $line->getLineNumber() > $lineCount) {
            continue;
        }

        $result = null;

        if ($line->isExecuted()) {
            $result = 1;
        } else if ($line->isUnused()) {
            $result = 0;
        }
        $lineResults[$line->getLineNumber() - 1] = $result;
    }
    $sourceFiles[] = array(
        'name' => $file->getRelativePath(getcwd()),
        'source' => $source,
        'coverage' => array_values($lineResults),
    );
}

$repository = new Repository('.');
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

file_put_contents(__DIR__ . '/coverage.json', json_encode($coveralls));


use Guzzle\Http\Client;

$client = new Client();
$request = $client->post('https://coveralls.io/api/v1/jobs')
    ->addPostFiles(array(
        'json_file' => realpath(__DIR__ . '/coverage.json')
    ));

$request->send();
