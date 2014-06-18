<?php
$databaseConfig = array(
		'db' => array(
				'driver' => 'pdo_mysql',
				'username' => 'adminTJEGQ1c',
				'password' => 'h9I1_ShVB_xF',
				'database' => 'gotcms',
				'hostname' => '127.6.228.130',
				'driver_options' => array(
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
				),
		),
);
$fileName = getenv('ZS_APPLICATION_BASE_DIR') . '/config/autoload/local.php';
$writeResutl = file_put_contents($fileName, '<?php return ' . var_export($databaseConfig,true).';');
if ( $writeResutl === false) {
	echo 'Cannot write file  : ' . $fileName;
	exit(1);
}
exit(0);