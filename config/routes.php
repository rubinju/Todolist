<?php

  // $routes->get('/', function() {
  //   HelloWorldController::index();
  // });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/tasklist', function() {
    HelloWorldController::list_tasks();
  });

  $routes->get('/taskedit', function() {
    HelloWorldController::edit_task();
  });

  $routes->get('/', function() {
    TaskController::index();
  });

  $routes->get('/task', function() {
    TaskController::index();
  });

// show not implemented yet
  // $routes->get('/task/:id', function() {
  //   TaskController::show($id); 
  // });