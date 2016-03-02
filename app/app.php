<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Courses.php";
    require_once __DIR__."/../src/Student.php";

    // session_start();
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug']= true;
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/courses", function() use ($app){
        return $app['twig']->render('courses.html.twig', array('courses' => Courses::getAll()));
    });

    $app->post("/add_course", function() use ($app) {
        $course_name = $_POST['course_name'];
        $course_number = $_POST['course_number'];
        $id = null;
        $new_course = new Courses($id, $course_name, $course_number);
        $new_course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Courses::getAll()));
    });

    $app->post("/delete_all_courses", function() use ($app){
        Courses::deleteAll();
        return $app['twig']->render('courses.html.twig', array('courses' => Courses::getAll()));
    });

    $app->get("/students", function() use ($app){
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });



    $app->post("/add_to_student", function() use ($app){
        $course = Courses::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $student->addCourse($course);
        return $app['twig']->render('student.html.twig', array('students' => $student, 'all_courses' => Courses::getAll(), 'courses' => $student->getCourses()));
    });

    $app->post("/add_student", function() use ($app){
        $student_name = $_POST['student_name'];
        $enroll_date = $_POST['enroll_date'];
        $id = null;
        $new_student = new Student($id, $student_name, $enroll_date);
        $new_student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->delete("/student/{id}", function($id) use ($app){
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render('students.html.twig', array('students'=>Student::getAll()));
    });

    $app->post("/add_to_course", function() use ($app){
        $course = Courses::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $course->addStudent($student);
        return $app['twig']->render('course.html.twig', array('courses' => $course, 'all_courses' => Courses::getAll(), 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->delete("/course/{id}", function($id) use ($app){
        $course = Courses::find($id);
        $course->delete();
        return $app['twig']->render('courses.html.twig', array('courses' => Courses::getAll()));
    });

    $app->post("/delete_all_students", function() use ($app){
        Student::deleteAll();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/student/{id}/edit", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('edit_student.html.twig', array('student' => $student));
    });

    $app->get("/student/{id}", function($id) use ($app){
        $students = Student::find($id);
        return $app['twig']->render('student.html.twig', array('courses' => $students->getCourses(), 'students' => $students, 'all_courses' => Courses::getAll()));
    });

    $app->patch("/student/{id}", function($id) use ($app) {
        $new_name = $_POST['new_name'];
        $student = Student::find($id);
        $student->update($new_name);
        return $app['twig']->render('student.html.twig', array('courses' => $student->getCourses(), 'students' => $student, 'all_courses' => Courses::getAll()));
    });


    $app->get("/course/{id}", function($id) use ($app) {
        $courses = Courses::find($id);
        return $app['twig']->render('course.html.twig', array('students' => $courses->getStudents(), 'courses' => $courses, 'all_students' => Student::getAll()));
    });




    return $app;
 ?>
