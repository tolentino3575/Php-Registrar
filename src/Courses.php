<?php
class Courses {
    private $id;
    private $course_name;
    private $course_number;


    function __construct($id = null, $course_name, $course_number)
    {
      $this->id = $id;
      $this->course_name = $course_name;
      $this->course_number = $course_number;
    }

    function setName($new_course_name)
    {
      $this->course_name = $new_course_name;
    }

    function setEnrollDate($new_course_number)
    {
      $this->course_number = $new_course_number;
    }

    function getId()
    {
      return $this->id;
    }

    function getCourseName()
    {
      return $this->course_name;
    }

    function getCourseNumber()
    {
      return $this->course_number;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses");
        $courses = array();

        foreach ($returned_courses as $course)
        {
            $id = $course['id'];
            $course_name = $course['course_name'];
            $course_number = $course['course_number'];
            $new_course = new Courses($id, $course_name, $course_number);
            array_push($courses, $new_course);
        }
        return $courses;
    }

    static function find($search_id)
    {
        $found_course = null;
        $courses = Courses::getAll();

        foreach($courses as $course)
        {
            $course_id = $course->getId();
            if ($course_id == $search_id)
            {
                $found_course = $course;
            }
        }
        return $found_course;
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()}");
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM courses");
    }

    function addStudent($student)
    {
        $GLOBALS['DB']->exec("INSERT INTO student_courses (student_id, course_id) VALUES ({$student->getId()}, {$this->getId()});");
    }

    function getStudents()
    {
        $students = $GLOBALS['DB']->query("SELECT student.* FROM courses
            JOIN student_courses ON (courses.id = student_courses.course_id)
            JOIN student ON (student_courses.student_id = student.id)
            WHERE courses.id = {$this->getId()};");

        $result_students = array();
        foreach($students as $student)
        {
            $student_id = $student['id'];
            $student_name = $student['name'];
            $student_enroll = $student['enroll_date'];
            $new_student = new Student($student_id, $student_name, $student_enroll);
            array_push($result_students, $new_student);
        }
        return $result_students;
    }
}

?>
