<?php
  class FileIndexer {
    public static $instance;
    private $home = "scripts/";
    private $files = [];
    private $errors = [];
    private $command_scripts = [
      'js' => 'node',
      'py' => 'python',
      'php' => 'php',
      'cpp' => 'cpp'
    ];

    private function __constructor(){}

    public function addCommands($ecmd = []){
      $this->command_scripts = array_merge($this->command_scripts, $ecmd);
    }

    public static function instance(){
      if(self::$instance == NULL){
        self::$instance = new FileIndexer();
      }
      return self::$instance;
    }

    private function scripts($file_type = ''){
      $filename = $this->home . '*.' . $file_type;
      foreach (glob($filename) as $file) {
          $this->files[] = $file;
      }
      return $this->files;
    }

    private function command_handler($command = ''){
        $output = [];
        $return_var = -1;

        //$command = @escapeshellcmd($command);
        $last_line = @exec($command, $output, $return_var);
        if($return_var == 0){
            return $last_line;
        }else{
            return false;
        }
    }

    public function executeCommand($command = ''){
      try{
        $result = @$this->command_handler($command);
        return $result != false ? $result: NULL;
      }catch(\Exception $e){
        //echo "Error : " . $e->getMessage();
        print "An Error occurred\n";
        die();
      }
    }

    public function canExecuteCommand($file_type = '', $fail_message = ''){
        if(!isset($this->command_scripts[$file_type])){
          print "." . $file_type . " File Format is not supported\n";
          return false;
        }
        $command = "which " . $this->command_scripts[$file_type] . " 2>nul";
        $output = @$this->executeCommand($command, $fail_message);
        return ($output == NULL) ? false : true;
    }

    public function computeFiles($file_type = '', $error_message = 'server not running'){
      $data = [];

      if(!$this->canExecuteCommand($file_type)){
        $this->errors[] = $file_type . " " . $error_message . "\n";
        return false;
      }

      $files = $this->scripts($file_type);
      $command = "which " . $this->command_scripts[$file_type] . " 2>nul";
      @$this->executeCommand($command);
      foreach($files as $file){
          $extension = explode('.', $file);
          $command = $this->command_scripts[$file_type] . " " . $file . ' 2>nul';
          $exec = @$this->executeCommand($command);
          $data[$extension[0]]['content'] = ($exec === NULL) ? 'Script Error' : $exec;;
          $data[$extension[0]]['status'] = $this->testFileContent($exec);
          $data[$extension[0]]['name'] = $extension[0];
          $data[$extension[0]]['language'] = $extension[count($extension) - 1];
      }
      return $data;
    }

    public function testFileContent($string) {
        if (preg_match('/^Hello\sWorld[,|.|!]?\sthis\sis\s[a-zA-Z]{2,}\s[a-zA-Z]{2,}(\s[a-zA-Z]{2,})?\swith\sHNGi7\sID\s(HNG-\d{3,})\susing\s[a-zA-Z|#]{2,}\sfor\sstage\s2\stask.?$/i', trim($string))) {
            return 'Pass';
        }

        return 'Fail';
    }
        
}