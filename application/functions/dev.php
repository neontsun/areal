<?php

// Вывод ошибок на экран
ini_set('display_errors', 1);
// Показывать все ошибки
error_reporting(E_ALL);

function pretty($str) {
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
	exit;
}
