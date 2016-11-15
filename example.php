<?php

require_once 'SimplePDO.php';

$pdo = new SimplePDO('dbtest', 'root', '');

$rows = $pdo->rows('tbltest', array(array('id', '>', 0), "AND", array('title', '=', 'abc')));
var_dump($rows);

$select = $pdo->select('tbltest', '*', array(array('title', '=', 'abc')), array('id', 'desc'));
var_dump($select);

$insert = $pdo->insert('tbltest', array('title' => 'test'));
var_dump($insert);

$update = $pdo->update('tbltest', array('title' => 'masoud'), array(array('id', '=', '5')));
var_dump($update);

$delete = $pdo->delete('tbltest', array(array('id', '!=', '1'), 'AND', array('id', '<>', '2')));
var_dump($delete);

?>
