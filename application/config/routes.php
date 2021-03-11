<?php

return [

	'news' => [
		'controller' => 'news',
		'action' => 'index'
	],
	'news/edit/{id:\d+}' => [
		'controller' => 'news',
		'action' => 'edit'
	],
	'news/add' => [
		'controller' => 'news',
		'action' => 'add'
	],

];

