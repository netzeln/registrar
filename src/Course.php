<?php
    class Course  {
        private $course_name;
        private $course_number;
        private $id;

        public function __construct($course_name, $course_number, $id = null) {
            $this->course_name = $course_name;
            $this->course_number = $course_number;
            $this->id = $id;
        }

        //Setters;
        public function setCourseName($course_name) {
            $this->course_name = $course_name;
        }

        public function setCourseNumber($course_number) {
            $this->course_number = $course_number;
        }

        //Getters;
        public function getCourseName() {
            return $this->course_name;
        }

        public function getCourseNumber() {
            return $this->course_number;
        }

        public function getId() {
            return $this->id;
        }

        public function save(){
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll(){
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();

            foreach($returned_courses as $course)
            {$course_name = $course['course_name'];
             $course_number = $course['course_number'];
             $id = $course['id'];
             $new_course = new Course($course_name, $course_number, $id);
             array_push($courses, $new_course);
            }
            return $courses;
         }

         static function deleteAll(){
             $GLOBALS['DB']->exec("DELETE FROM courses;");

         }

         static function find($search_id) {
             $courses = Course::getAll();
             $found_course = null;
             foreach($courses as $course){
                 $course_id = $course->getId();
                 if($course_id == $search_id){
                     $found_course = $course;
                 }
             }
             return $found_course;
         }

         public function delete() {
             $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
         }

         public function update($new_course_name, $new_course_number){
             $GLOBALS['DB']->exec("UPDATE courses SET course_name = '{$new_course_name}', course_number = '{$new_course_number}' WHERE id = {$this->getId()};");
             $this->setCourseName($new_course_name);
             $this->setCourseNumber($new_course_number);
         }

         static function search($search_term) {
             $found_courses = array();
             $courses = Course::getAll();
             foreach ($courses as $course) {
                 $course_name = $course->getCourseName();
                 similar_text($search_term, $course_name, $percentage);
                 if ($percentage > 35) {
                     array_push($found_courses, $course);
                 }
             }
             return $found_courses;
         }
         public function addStudent($student){
             $GLOBALS['DB']->exec("INSERT INTO courses_students (student_id, course_id) VALUES ({$student->getId()}, {$this->getId()});");
         }

         public function getStudents(){
             $query = $GLOBALS['DB']->query("SELECT student_id FROM courses_students WHERE course_id = {$this->getId()};");
             $student_ids = $query->fetchAll(PDO::FETCH_ASSOC);

             $students = array();
             foreach($student_ids as $id){
                 $student_id = $id['student_id'];
                 $result = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$student_id};");
                 $returned_student = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_student[0]['name'];
                $enrollment = $returned_student[0]['enrollment'];
                $id = $returned_student[0]['id'];
                $new_student = new Student($name, $enrollment,$id);

                array_push($students, $new_student);
              }
              return $students;

        }
} ?>
