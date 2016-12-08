<?php

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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

  $routes->post('/task/:id/done', function($id){
    TaskController::done($id);
  });

  $routes->get('/login', function(){
    UserController::login();
  });

  $routes->post('/login', function(){
    UserController::handle_login();
  });

  $routes->get('/logout', function(){
    UserController::logout();
  });

  $routes->get('/project', function() {
    ProjectController::index();
  });

  $routes->get('/project/new', function() {
    ProjectController::create();
  });

  $routes->post('/project/:id/destroy', function($id){
    ProjectController::destroy($id);
  });