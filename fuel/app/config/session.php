<?php

return array(
    'expire_on_close' => false,
    'expiration_time' => 2592000,
    'cookie' => array(
	'cookie_name' => 'cid',
    ),
    'driver' => 'file',
    'file' => array(
	'cookie_name' => '_fid', // name of the session cookie for file based sessions
	'path' => APPPATH.'/tmp', // path where the session files should be stored
	'gc_probability' => 5   // probability % (between 0 and 100) for garbage collection
    ),
);


