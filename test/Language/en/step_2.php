<?php

return [
'list' => [
// Heading
'heading_title'        => 'Configuration',

// Text
'text_step_3'          => 'Enter your database and administration details',
'text_db_connection'   => '1. Please enter your database connection details.',
'text_db_administration'  => '2. Please enter a username and password for the administration.',
'text_mysqli'          => 'MySQLi',
'text_pdo'             => 'mPDO',
'text_pgsql'           => 'PostgreSQL',
'text_help'            => 'Information about setting up a databases on different platforms:',
'text_cpanel'          => 'CPanel DB Setup',
'text_plesk'           => 'Plesk DB Setup',

// Entry
'entry_db_driver'      => 'DB Driver',
'entry_db_hostname'      => 'Hostname',
'entry_db_username'      => 'Username',
'entry_db_password'      => 'Password',
'entry_db_database'    => 'Database',
'entry_db_port'        => 'Port',
'entry_db_prefix'      => 'Prefix',
'entry_username'       => 'Username',
'entry_password'       => 'Password',
'entry_email'          => 'E-Mail',
'button_continue'        => 'Continue',
],
// Error
'error_db_driver'        => 'Database Driver required!',
'error_db_hostname'      => 'Hostname required!',
'error_db_username'      => 'Username required!',
'error_db_database'      => 'Database Name required!',
'error_db_port'          => 'Database Port required!',
'error_db_prefix'        => 'DB Prefix can only contain lowercase characters in the a-z range, 0-9 and underscores',
'error_db_connect'       => 'Error: Could not connect to the database please make sure the database server, username and password is correct!',
'error_username'         => 'Username required!',
'error_password'         => 'Password required!',
'error_email'            => 'E-Mail Address does not appear to be valid!',
'error_config'           => 'Error: Could not write to config.php please check you have set the correct permissions on: ',

];
