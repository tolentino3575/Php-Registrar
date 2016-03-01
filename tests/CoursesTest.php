<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Courses.php";

$server = 'mysql:host=localhost;dbname=registrar_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class CoursesTest extends PHPUnit_Framework_TestCase{

  protected function tearDown()
     {
         Courses::deleteAll();
     }


  function testGetCourseName() {
    //Arrange
    $course_name = "Php";
    $course_number= '100';
    $id = 1;
    $test_course_name = new Courses($id, $course_name, $course_number);

    //Act
    $result = $test_course_name->getCourseName();

    //Assert
    $this->assertEquals($course_name, $result);

  }

  function testGetId()
  {
    //Arrange
    $course_name = "Php";
    $course_number = '100';
    $id = 1;
    $test_id = new Courses($id, $course_name, $course_number);

    //Act
    $result = $test_id->getId();

    //Assert
    $this->assertEquals($id, $result);

  }

  function testCourseNumber()
  {
    //Arrange
    $course_name = "Php";
    $course_number = '100';
    $id = 1;
    $test_course_name = new Courses($id, $course_name, $course_number);

    //Act
    $result = $test_course_name->getCourseNumber();

    //Assert
    $this->assertEquals($course_number, $result);
  }

  function testSave()
  {
      //Arrange
      $course_name = "Php";
      $course_number = '100';
      $id = 1;
      $test_course_name = new Courses($id, $course_name, $course_number);
      $test_course_name->save();

      //Act
      $result = Courses::getAll();


      //Assert
      $this->assertEquals($test_course_name, $result[0]);
  }

  function testGetAll()
  {
      //Arrange
      $course_name = "Php";
      $course_number = '100';
      $id = 1;
      $test_course_name = new Courses($id, $course_name, $course_number);
      $test_course_name->save();

      $course_name2 = "Java";
      $course_number2 = '100';
      $id = 1;
      $test_course_name2 = new Courses($id, $course_name2, $course_number2);
      $test_course_name2->save();

      //Act
      $result = Courses::getAll();

      //Assert
      $this->assertEquals([$test_course_name, $test_course_name2], $result);
  }


}
?>
