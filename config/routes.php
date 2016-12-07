<?php

  // $routes->get('/', function() {
  //   HelloWorldController::index();
  // });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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
    TaskController::create();
  });

  // must be added after post new
  $routes->get('/task/:id', function($id) {
    TaskController::show($id); 
  });

  $routes->get('/task/:id/edit', function($id){
    TaskController::edit($id);
  });

  $routes->post('/task/:id/edit', function($id){
    TaskController::update($id);
  });

  $routes->post('/task/:id/destroy', function($id){
    TaskController::destroy($id);
  });

  $routes->get('/login', function(){
    UserController::login();
  });

  $routes->post('/login', function(){
    UserController::handle_login();
  });