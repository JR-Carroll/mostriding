<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SUB_CONTEXT', '/application');

define('BRC', 'BRC');
define('ERC', 'ERC');
define('RRBRC', 'RRBRC');
define('TRIWBRC', '3WBRC');

define('COURSES', json_encode(
    array (
    array('code'=>BRC, 'name'=>'Basic Rider Course', 'price' => 300),
    array('code'=>ERC, 'name'=>'Experienced Rider Course', 'price' => 100),
    array('code'=>RRBRC, 'name'=>'Returning Rider Basic Rider Course', 'price' => 120),
    array('code'=>TRIWBRC, 'name'=>'3 Wheeled Basic Rider Course', 'price' => 430),
    )
));

define('HD', 'HD');
define('M', 'M');

define('LOCATIONS', json_encode(
    array (
    array('code'=>HD, 'location'=>'Heritage Harley Davidson in Concord, NH'),
    array('code'=>M, 'location'=>'Elbit Systems in Merrimack, NH'),
    )
));
/*
 PROD
  SecurenetId: 1076290  
  SecureKey: WQ6HzSPS4GMl
 
 TEST
  SecurenetId: 8003668  
  SecureKey: 5p0CEH5jUxpL  
 */
define('SECURENET_ID', '1076290');
define('SECURENET_KEY', 'WQ6HzSPS4GMl');
/* End of file constants.php */
/* Location: ./application/config/constants.php */