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



class StudentTest extends PHPUnit_Framework_TestCase{

  protected function tearDown()
     {
       Student::deleteAll();
     }


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
    $id = null;
    $test_student = new Student($id, $name, $enroll_date);

    //Act
    $result = $test_student->getEnrollDate();

    //Assert
    $this->assertEquals($enroll_date, $result);
  }

  function testSave()
  {
    //Arrange
    $id = null;
    $name = "Tiff";
    $enroll_date = 01012016;
    $test_student = new Student($id, $name, $enroll_date);
    $test_student->save();

    //Act
    $result = Student::getAll();


    //Assert
    $this->assertEquals($test_student, $result[0]);

  }

  function testGetAll()
  {
    //Arrange
    $name = "Pete";
    $enroll_date = 01012016;
    $id = null;
    $test_student = new Student($id, $name, $enroll_date);
    $test_student->save();

    $name2 = "Nic";
    $enroll_date2 = 01012016;
    $id = null;
    $test_student2 = new Student($id, $name2, $enroll_date2);
    $test_student2->save();

    //Act
    $result = Student::getAll();

    //Assert
    $this->assertEquals([$test_student, $test_student2], $result);

  }

  function testFind()
  {
      //Arrange
      $name = "Pete";
      $enroll_date = 01012016;
      $id = 4;
      $test_student = new Student($id, $name, $enroll_date);
      $test_student->save();

      //Act
      $result = Student::find($test_student->getId());

      //Assert
      $this->assertEquals($test_student, $result);


  }

  function testDeleteStudent()
  {
      //Arrange
      $name = "Pete";
      $enroll_date = 01012016;
      $id = 4;
      $test_student = new Student($id, $name, $enroll_date);
      $test_student->save();

      $name2 = "Ted";
      $enroll_date2 = 03032016;
      $id = 4;
      $test_student2 = new Student($id, $name2, $enroll_date2);
      $test_student2->save();

      //Act
      $test_student->delete();
      $result = Student::getAll();

      //Assert
      $this->assertEquals([$test_student2], $result);

  }



}
 ?>
