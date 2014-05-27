<?php
return [

	/*
	|--------------------------------------------------------------------------
	| Database Settigns
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	*/

    'DB_NAME' 		=> 'tigre',
    'DB_USERNAME' 	=> 'dbuser',
    'DB_PASSWORD' 	=> '123',
    'DB_HOST' 		=> 'localhost',


	/*
	|--------------------------------------------------------------------------
	| Email Settigns
	|--------------------------------------------------------------------------
	|
	| Here setup your email configurations.
	|
	*/

    'MAIL_DRIVER' 			=> 'smtp', //"smtp", "mail", "sendmail"
    'MAIL_HOST' 			=> 'smtp.mailgun.org',
    'MAIL_SMTP_PORT' 		=> 587,
    'MAIL_FROM.ADDRESS' 	=> 'support@fastdezine.com',
    'MAIL_FROM.NAME'		=> 'Contato',
    'MAIL_ENCRYPTION' 		=> 'tls',
    'MAIL_USERNAME' 		=> null,
    'MAIL_PASSWORD' 		=> null,
    'MAIL_SENDMAIL_PATH' 	=> '/usr/sbin/sendmail -bs',
    'MAIL_PRETEND' 			=> false,
];
