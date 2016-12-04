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

  $routes->post('/task', function() {
    TaskController::store();
  });

  $routes->get('/task/new', function() {
    TaskController::create(); // not implemented yet
  });

// must be added after post new
  $routes->get('/task/:id', function($id) {
    TaskController::show($id); 
  });