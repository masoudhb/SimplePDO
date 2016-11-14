<?php

require_once 'SimplePDO.php';

$pdo = new SimplePDO('dbtest', 'root', '');

$rows = $pdo->rows('tbltest', array(array('id', '>', 0), "AND", array('user_id', '=', 2)));
var_dump($rows);

$select = $pdo->select('tbltest', '*', false, array('id', 'desc'));
var_dump($select);

$insert = $pdo->insert('tbltest', array('user_id' => '2', 'title' => 'test', 'content' => 'test', 'date' => '1479129508'));
var_dump($insert);

$update = $pdo->update('tbltest', array('user_id' => '3'), array(array('id', '=', '2')));
var_dump($update);

$delete = $pdo->delete('tbltest', array(array('id', '!=', '1'), 'AND', array('id', '<>', '2')));
var_dump($delete);

?>
