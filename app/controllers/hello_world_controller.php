<?php

  //require 'app/models/task.php'; // changed to composer 

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
      echo "This is the frontpage!";
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      //echo 'Hello World!';
      //View::make('helloworld.html');
      $beer = Task::find(1);
      $tasks = Task::all();
      // Kint debugger
      Kint::dump($beer);
      Kint::dump($tasks);
    }

    public static function login(){
        View::make('suunnitelmat/login.html');
    }
    public static function list_tasks(){
      View::make('suunnitelmat/list.html');
    }

    public static function edit_task(){
      View::make('suunnitelmat/edit_task.html');
    }
  }
