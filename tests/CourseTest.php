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

            $this->assertEquals($test_course, $result[0]);
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

        function testFind() {
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
            $search_id = $test_course->getId();
            $result = Course::find($search_id);

            //Assert;
            $this->assertEquals($test_course, $result);
        }
        function testUpdateMem(){
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $new_course_name = "American History: Sons of Liberty";
            $new_course_number = "HIST102";

            //act
            $test_course->update($new_course_name, $new_course_number);

            //assert
            $this->assertEquals($new_course_name, $test_course->getCourseName());
            $this->assertEquals($new_course_number, $test_course->getCourseNumber());
        }
        function testUpdateDB(){
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $new_course_name = "American History: Sons of Liberty";
            $new_course_number = "HIST102";

            //act
            $test_course->update($new_course_name, $new_course_number);
            $result = Course::getAll();

            //assert
            $this->assertEquals($new_course_name, $result[0]->getCourseName());
            $this->assertEquals($new_course_number, $result[0]->getCourseNumber());
        }

        function testSearchByName() {
            //Arrange;
            $course_name = "American History";
            $course_number = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $course_name2 = "";
            $course_number2 = "AFHIST101";
            $id2 = 2;
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();

            //Act;
            $search_term = 'American';
            $result = Course::search($search_term);

            //Assert;
            $this->assertEquals([$test_course], $result);

        }
    }
 ?>
