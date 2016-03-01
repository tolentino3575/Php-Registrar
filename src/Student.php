<?php
class Student {
    private $id;
    private $name;
    private $enroll_date;


    function __construct($id = null, $name, $enroll_date)
    {
      $this->id = $id;
      $this->name = $name;
      $this->enroll_date = $enroll_date;
    }

    function setName($new_name)
    {
      $this->name = $new_name;
    }

    function setEnrollDate($new_enroll_date)
    {
      $this->enroll_date = $new_enroll_date;
    }

    function getId()
    {
      return $this->id;
    }

    function getName()
    {
      return $this->name;
    }

    function getEnrollDate()
    {
      return $this->enroll_date;
    }

    function save()
    {

      $GLOBALS['DB']->exec("INSERT INTO student (name, enroll_date) VALUES ('{$this->getName()}', {$this->getEnrollDate()});");
      $this->id = $GLOBALS['DB']->lastInsertId();

    }

    static function getAll()
    {
      $returned_students = $GLOBALS['DB']->query("SELECT * FROM student");
      $students = array();
      foreach($returned_students as $student)
      {
          $id = $student['id'];
          $name = $student['name'];
          $enroll_date = $student['enroll_date'];
          $new_student = new Student($id, $name, $enroll_date);
          array_push($students, $new_student);
      }
      return $students;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM student");
    }

    // function find($search_id)
    // {
    //     $found_student = null;
    //     $students = Student::getAll();
    //
    //     foreach($students as $student)
    //     {
    //         $student_id = $student->getId();
    //         if ($student_id == $search_id)
    //         {
    //             $found_student = $student;
    //         }
    //     }
    //     return $found_student;
    // }


} ?>
