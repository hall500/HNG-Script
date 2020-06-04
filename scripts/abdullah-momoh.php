<?php 
  class _MUser {
    private $firstname = 'Abdullah';
    private $lastname = 'Momoh';
    private $id = 'HNG-00030';
    private $language = 'PHP';
    private $mail = 'momohabdullah20@gmail.com';

    public function output(){
      return "Hello World, this is {$this->firstname} {$this->lastname} with HNGi7 ID {$this->id} and email {$this->mail} using {$this->language} for stage 2 task";
    }
  }

  $me = new _MUser();
  print $me->output() . "\n";
