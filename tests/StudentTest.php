<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Student.php";

$server = 'mysql:host=localhost;dbname=registrar_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class StudentTest  extends PHPUnit_Framework_TestCase{

  // deleteAll


  function testGetName() {
    //Arrange
    $name = "Bob";
    $enroll_date= 01012016;
    $test_name = new Name($name, $enroll_date);

    //Act
    $result = $test_name->getName();

    //Assert
    $this->assertEquals($name, $result);

  }


}
 ?>
