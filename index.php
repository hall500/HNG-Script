<?php
    include "./FileIndexer.php";

    $json = $_SERVER["QUERY_STRING"] ?? '';

    /* 
    * Add New Commands Here, 
    * Format: file_type => command
    */
    $commands = [
    ];

    /*
    * Instantiating a Single Instance of the FileIndexer Class 
     */
    $indexer = FileIndexer::instance();
    $indexer->addCommands($commands);

    if(function_exists('exec')){
        echo "<pre>";
        //print "Exec is enabled\n";
        $output = $indexer->computeFiles('go');
        print_r(json_encode($output));
        
        /* $output = $indexer->computeFiles('py');
        print_r(json_encode($output)); */
        /* $output = $indexer->computeFiles('js');
        print_r(json_encode($output));
        flush();
        ob_flush();
        time_nanosleep(2, 1000); */
        echo "</pre>";
        exit;
    }

    

    print 'HTML text here';