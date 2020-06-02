<?php
    include "./file_indexer.php";

    $json = $_SERVER["QUERY_STRING"] ?? '';

    $python = FileIndexer::scripts('py');
    $php = FileIndexer::scripts('php');
    $js = FileIndexer::scripts('js');

    if(function_exists('exec')){
        echo 'Exec is enabled';
        echo exec('php test_scripts/server_running.php');
        echo exec('node test_scripts/server_running.py');
        echo exec('python test_scripts/server_running.js');
    }
    exit;

