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
            
        }




} ?>
