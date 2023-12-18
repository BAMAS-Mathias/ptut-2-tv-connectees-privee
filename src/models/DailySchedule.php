<?php

namespace Models;

class DailySchedule{

    /**
     * @var Course[]
     */
    private array $courseList;


    public function addCourse($event){
        $subject = "";
        $teacher = "";
        $location = "";

        if(isset($event['description'])){
            $subject = $event['description'];
            $teacher = $event['description'];
        }

        if(isset($event['location'])){
            $location = $event['location'];
        }

        $this->courseList[] = new Course($subject, $teacher, $location);
    }

    /**
     * @return mixed
     */
    public function getCourseList()
    {
        return $this->courseList;
    }


}
