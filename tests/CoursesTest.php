<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Courses.php";
require_once "src/Student.php";

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

  function testFind()
  {
      //Arrange
      $course_name = "Php";
      $course_number = '100';
      $id = 1;
      $test_course = new Courses($id, $course_name, $course_number);
      $test_course->save();

      //Act
      $result = Courses::find($test_course->getId());

      //Assert
      $this->assertEquals($test_course, $result);
  }

  function testDeleteCourse()
  {
      //Arrange
      $course_name = "Php";
      $course_number = '100';
      $id = 1;
      $test_course = new Courses($id, $course_name, $course_number);
      $test_course->save();

      $course_name2 = "Java";
      $course_number2 = '100';
      $id = 1;
      $test_course2 = new Courses($id, $course_name2, $course_number2);
      $test_course2->save();

      //Act
      $test_course2->delete();
      $result = Courses::getAll();

      //Assert
      $this->assertEquals([$test_course], $result);

  }

  function testAddStudent()
  {
      //Arrange
      $name = "Timmy";
      $enroll_date = 01012016;
      $id = 5;
      $test_student = new Student($id, $name, $enroll_date);
      $test_student->save();

      $course_name = "C#";
      $course_number = '110';
      $id = 1;
      $test_course = new Courses($id, $course_name, $course_number);
      $test_course->save();

      //Act
      $test_course->addStudent($test_student);
      $result = $test_course->getStudents();

      //Assert
      $this->assertEquals([$test_student], $result);

  }

  function testGetStudents()
  {
      //Arrange
      $name = "Timmy";
      $enroll_date = 01012016;
      $id = 1;
      $test_student = new Student($id, $name, $enroll_date);
      $test_student->save();

      $name2 = "Jimmy";
      $enroll_date2 = 04052016;
      $id2 = 1;
      $test_student2 = new Student($id2, $name2, $enroll_date2);
      $test_student2->save();

      $course_name = "Php";
      $course_number = '100';
      $id2 = 1;
      $test_course = new Courses($id2, $course_name, $course_number);
      $test_course->save();


      //Act
      $test_course->addStudent($test_student);
      $test_course->addStudent($test_student2);

      //Assert
      $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);

  }

}
?>
