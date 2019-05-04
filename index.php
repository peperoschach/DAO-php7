<?php

require_once("config.php");

// load unique user
/* $root = new User();
$root->loadById(4);
echo $root; */

// Load list to users
/* $list = User::getList();
echo json_encode($list); */

// Load search to users
/* $search = User::search("e");
echo json_encode($search); */

// load user loggedin
$login = new User();
$login->login("jose", "68hh8s");
echo $login;
