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

} ?>
