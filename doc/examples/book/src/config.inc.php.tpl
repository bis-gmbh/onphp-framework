<?php
	/* $Id$ */

	// system settings
	error_reporting(E_ALL | E_STRICT);
	
	setlocale(LC_CTYPE, "ru_RU.UTF8");
	setlocale(LC_TIME, "ru_RU.UTF8");
	
	// paths
	define('PATH_BASE', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
	
	define('PATH_WEB', 'http://book.oem.boo/');
	
	define('PATH_ADMIN', 'http://admin.book.oem.boo/');
	
	define('PATH_CLASSES', PATH_BASE.'classes'.DIRECTORY_SEPARATOR);
	define('PATH_CONTROLLERS', PATH_BASE.'controllers'.DIRECTORY_SEPARATOR);
	define('PATH_TEMPLATES', PATH_BASE.'templates'.DIRECTORY_SEPARATOR);
	
	// onPHP
	require '/var/www/libs/onphp-1.0/global.inc.php.tpl';
	
	// everything else
	define('DEFAULT_ENCODING', 'UTF-8');
	mb_internal_encoding(DEFAULT_ENCODING);
	mb_regex_encoding(DEFAULT_ENCODING);
	
	ini_set(
		'include_path',
		PATH_CLASSES.PATH_SEPARATOR
		.PATH_CLASSES.'DAOs'.PATH_SEPARATOR
		.PATH_CLASSES.'Business'.PATH_SEPARATOR
		.PATH_CLASSES.'Proto'.PATH_SEPARATOR
		.PATH_CLASSES.'Filters'.PATH_SEPARATOR
		.PATH_CLASSES.'Utils'.PATH_SEPARATOR
		.PATH_CLASSES.'ViewHelpers'.PATH_SEPARATOR
		.PATH_CLASSES.'Flow'.PATH_SEPARATOR
		
		.PATH_CLASSES.'Auto'.DIRECTORY_SEPARATOR.'Business'.PATH_SEPARATOR
		.PATH_CLASSES.'Auto'.DIRECTORY_SEPARATOR.'Proto'.PATH_SEPARATOR
		.PATH_CLASSES.'Auto'.DIRECTORY_SEPARATOR.'DAOs'.PATH_SEPARATOR
		
		.PATH_CONTROLLERS.PATH_SEPARATOR
		
		.get_include_path().PATH_SEPARATOR
	);
	
	// magic_quotes_gpc must be off
	
	//define('__LOCAL_DEBUG__', true);
	define('BUGLOVERS', 'gabaden@gmail.com');
	
	// db settings
	DBPool::me()->
	setDefault(
		DB::spawn('PgSQL', 'sherman', '', 'localhost', 'book')
	);
	
	Cache::setPeer(
		WatermarkedPeer::create(
			Memcached::create('localhost'),
			
			'book'
		)
	);
	
	Cache::setDefaultWorker('VoodooDaoWorker');
	VoodooDaoWorker::setDefaultHandler('MessageSegmentHandler');
	
	// Cache::me()->clean();
?>
