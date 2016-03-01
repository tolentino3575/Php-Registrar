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

    static function find($search_id)
    {
        $found_student = null;
        $students = Student::getAll();

        foreach($students as $student)
        {
            $student_id = $student->getId();
            if ($student_id == $search_id)
            {
                $found_student = $student;
            }
        }
        return $found_student;
    }

    function addCourse($course)
    {
        $GLOBALS['DB']->exec("INSERT INTO student_courses (student_id, course_id) VALUES ({$this->getId()}, {$course->getId()});");
    }

// OLD WAY
//     function getCourses()
//     {
//         $query = $GLOBALS['DB']->query("SELECT course_id FROM student_courses WHERE student_id = {$this->getId()};");
//         [4, 2, 5, 6]
//         $course_ids = $query->fetchAll(PDO::FETCH_ASSOC);
//         ["course_id":4, "course_id":2, "course_id":5, "course_id":6]
//
//
//         $courses = array();
//         foreach($course_ids as $id)
//         {
//             $course_id = $id['course_id'];
//             $result = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$course_id};");
//             [["math", 110, 1], ["science", 101, 4]]
//             $returned_course = $result->fetchAll(PDO::FETCH_ASSOC);
//             [["course_name":"math", "course_number":110, "id":1], ["course_name":"science", "course_number":101, "id":4]]
//             $course_name = $returned_course[0]['course_name'];
//             $course_number = $returned_course[0]['course_number'];
//             $id = $returned_course[0]['id'];
//             $new_course = new Courses($id, $course_name, $course_number);
//             array_push($courses, $new_course);
//         }
//         return $courses;
//     }

//JOIN statement
    function getCourses()
    {
        $courses = $GLOBALS['DB']->query("SELECT courses.* FROM student
            JOIN student_courses ON (student.id = student_courses.student_id)
            JOIN courses ON (student_courses.course_id = courses.id)
            WHERE student.id = {$this->getId()};");

        // $course_ids = $query->fetchAll(PDO::FETCH_ASSOC);

        $result_courses = array();
        foreach($courses as $course)
        {
            $course_id = $course['id'];
            $course_name = $course['course_name'];
            $course_number = $course['course_number'];
            $new_course = new Courses($course_id, $course_name, $course_number);
            array_push($result_courses, $new_course);
        }
        return $result_courses;
    }


    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM student WHERE id = {$this->getId()};");
    }


} ?>
