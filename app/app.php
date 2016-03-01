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
        return $app['twig']->render('students.html.twig');
    });

    $app->post("/add_student", function() use ($app){
        $student_name = $_POST['student_name'];
        $enroll_date = $_POST['enroll_date'];
        $id = null;
        $new_student = new Student($id, $student_name, $enroll_date);
        $new_student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/delete_all_students", function() use ($app){
        Student::deleteAll();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/course/{id}", function($id) use ($app) {

        return $app['twig']->render('course.html.twig', array('students' => Student::getAll(), 'courses' => Courses::getAll()));
    });


    return $app;
 ?>
