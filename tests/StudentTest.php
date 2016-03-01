<?php

    //if using database
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    require_once "src/Course.php";

    //if using database
    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class  StudentTest  extends PHPUnit_Framework_TestCase {

        function teardown() {
            Course::deleteAll();
            Student::deleteAll();
        }

        function testGetName() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $test_student = new Student($name, $enrollment);

            //Act;
            $result = $test_student->getName();

            //Assert;
            $this->assertEquals($name, $result);
        }

        function testgetEnrollment() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $test_student = new Student($name, $enrollment);

            //Act;
            $result = $test_student->getEnrollment();

            //Assert;
            $this->assertEquals($enrollment, $result);
        }

        function testGetId() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);

            //Act;
            $result = $test_student->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testSave() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);

            //Act;
            $test_student->save();
            $result = Student::getAll();

            //Assert;

            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "African John";
            $enrollment2 = "2016-02-28";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2);
            $test_student2->save();
            //Act;

            $result = Student::getAll();

            //Assert;

            $this->assertEquals([$test_student, $test_student2], $result);
        }
        function testDeleteAll() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "African John";
            $enrollment2 = "2015-02-02";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2);
            $test_student2->save();
            //Act;

            Student::deleteAll();
            $result = Student::getAll();

            //Assert;

            $this->assertEquals([], $result);
        }

        function testFind() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "African John";
            $enrollment2 = "2014-03-21";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2);
            $test_student2->save();

            //Act;
            $search_id = $test_student->getId();
            $result = Student::find($search_id);

            //Assert;
            $this->assertEquals($test_student, $result);
        }
        function testUpdateMem(){
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $new_student_name = "Bridgette";
            $new_enrollment = "2015-02-20";

            //act
            $test_student->update($new_student_name, $new_enrollment);

            //assert
            $this->assertEquals($new_student_name, $test_student->getName());
            $this->assertEquals($new_enrollment, $test_student->getEnrollment());
        }
        function testUpdateDB(){
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $new_student_name = "John2";
            $new_enrollment = "2015-01-20";

            //act
            $test_student->update($new_student_name, $new_enrollment);
            $result = Student::getAll();

            //assert
            $this->assertEquals($new_student_name, $result[0]->getName());
            $this->assertEquals($new_enrollment, $result[0]->getEnrollment());
        }

        function testSearchByName() {
            //Arrange;
            $name = "John";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "";
            $enrollment2 = "2010-01-20";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2);
            $test_student2->save();

            //Act;
            $search_term = 'John2';
            $result = Student::search($search_term);

            //Assert;
            $this->assertEquals([$test_student], $result);

        }
    }
 ?>
