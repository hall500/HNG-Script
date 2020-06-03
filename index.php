<?php
    include "./FileIndexer.php";

    $json = $_SERVER["QUERY_STRING"] ?? '';

    /* 
    * Add New Commands Here, 
    * Format: file_type => command
    */
    $commands = [
        'java' => 'java '
    ];

    /*
    * Instantiating a Single Instance of the FileIndexer Class 
     */
    $indexer = FileIndexer::instance();
    $indexer->addCommands($commands);

    if(function_exists('exec')){
        echo "<pre>";
        //print "Exec is enabled\n";
        $output = $indexer->computeFiles('php');
        print_r(json_encode($output));
        
        $output = $indexer->computeFiles('py');
        print_r(json_encode($output));
        
        $output = $indexer->computeFiles('js');
        print_r(json_encode($output));
        echo "</pre>";
        exit;
    }

    

    print 'HTML text here';