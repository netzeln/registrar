<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Course.php";
    require_once __DIR__."/../src/Student.php";

    // session_start();

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

    $app->get("/students", function() use ($app){
        return $app['twig']->render('students.html.twig', array("all_students"=>Student::getAll()));
    });

    $app->post("/add_student", function() use ($app){

        $new_student = new Student($_POST['name'], $_POST['enrollment']);
        $new_student->save();

      return $app['twig']->render('students.html.twig', array("all_students"=>Student::getAll()));
    });

    $app->post("/delete_students", function() use ($app) {
        Student::deleteAll();
      return $app['twig']->render('students.html.twig', array("all_students"=>Student::getAll()));
    });

    $app->get("/courses", function() use ($app){
        return $app['twig']->render('courses.html.twig', array("all_courses"=>Course::getAll()));
    });

    $app->post("/add_course", function() use ($app){
        $new_course = new Course($_POST['course_name'], $_POST['course_number']);
        $new_course->save();
      return $app['twig']->render('courses.html.twig', array("all_courses"=>Course::getAll()));
    });
    $app->post("/delete_courses", function() use ($app) {
        Course::deleteAll();
      return $app['twig']->render('courses.html.twig', array("all_courses"=>Course::getAll()));
    });

    return $app;
 ?>
