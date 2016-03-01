<?php

    //if using database
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    //if using database
    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class  CourseTest  extends PHPUnit_Framework_TestCase {

        function teardown() {
            Course::deleteAll();
        }

        function testGetCourseName() {
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $test_course = new Course($course_name, $course_number);

            //Act;
            $result = $test_course->getCourseName();

            //Assert;
            $this->assertEquals($course_name, $result);
        }

        function testGetCourseNumber() {
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $test_course = new Course($course_name, $course_number);

            //Act;
            $result = $test_course->getCourseNumber();

            //Assert;
            $this->assertEquals($course_number, $result);
        }

        function testGetId() {
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);

            //Act;
            $result = $test_course->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testSave() {
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);

            //Act;
            $test_course->save();
            $result = Course::getAll();

            //Assert;

            $this->assertEquals([$test_course], $result);
        }

        function testGetAll() {
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $course_name2 = "African American History";
            $course_number2 = "HIST102";
            $id2 = 2;
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();
            //Act;

            $result = Course::getAll();

            //Assert;

            $this->assertEquals([$test_course, $test_course2], $result);
        }
        function testDeleteAll() {
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $course_name2 = "African American History";
            $course_number2 = "HIST102";
            $id2 = 2;
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();
            //Act;

            Course::deleteAll();
            $result = Course::getAll();

            //Assert;

            $this->assertEquals([], $result);
        }
    }
 ?>
