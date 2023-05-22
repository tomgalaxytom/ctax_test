<?php
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);

     define('DB_HOST', 'localhost');
     define('DB_USER', 'postgres');
     define('DB_PASS', 'stalinthomas');
     define('DB_NAME', 'ctax_test');
     define('DB_PORT', '5432');

    define('BASE_PATH', realpath(__DIR__ . "/../../") );
    define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . "app");
    define('PUBLIC_PATH', BASE_PATH . DIRECTORY_SEPARATOR . "public");
    
    // define('URLROOT', 'http://localhost/ctax/');
    // define('Filepath', 'http://localhost/ctax/upload/bills');
   // define('URLROOT', 'https://10.163.19.176/ctax_test/');
   // define('Filepath', 'https://10.163.19.176/ctax_test/upload/bills');

    define('URLROOT', 'http://localhost/projects/ctax_test/');
    define('FILEPATH', 'http://localhost/projects/ctax_test/uploads/');



    define('Fileuploadpath', '/home/apache2438/htdocs/citizen_new/ctax/gstweb/uploads');


    
  
?>
