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
    $id = 3;
    $test_name = new Student($id, $name, $enroll_date);

    //Act
    $result = $test_name->getName();

    //Assert
    $this->assertEquals($name, $result);

  }

  function testGetId()
  {
    //Arrange
    $name = "Bob";
    $enroll_date = 01012016;
    $id = 1;
    $test_id = new Student($id, $name, $enroll_date);

    //Act
    $result = $test_id->getId();

    //Assert
    $this->assertEquals($id, $result);

  }

  function testEnrollDate()
  {
    //Arrange
    $name = "Tiff";
    $enroll_date = 01012016;
    $id = 4;
    $test_student = new Student($id, $name, $enroll_date);

    //Act
    $result = $test_student->getEnrollDate();

    //Assert
    $this->assertEquals($enroll_date, $result);
  }


}
 ?>
