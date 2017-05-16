<?php
  require_once('connection.php');

  function checkReferer() {
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
    return $res = transition($httpArr['path']);
  }

  function transition($path) {
    $data = $_POST;
    if($path === '/index.php' && $data['type'] === 'delete'){
      deleteData($data['id']);
      return 'index';
    }elseif($path === '/new.php'){
      create($data);
      return 'index';
    }elseif($path === '/edit.php'){
      update($data);
      return 'index';
    }
  }

  function create($data) {
    insertDb($data['todo']);
  }

  function index() {
    return $todos = selectAll();
  }

  function update($data) {
    updateDb($data['id'], $data['todo']);
  }

  function detail($id) {
    return getSelectData($id);
  }

  function deleteData($id) {
    deleteDb($id);
  }
?>