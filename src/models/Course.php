<?php

namespace Models;

class Course
{
    private string $subject;
    private string $teacher;
    private string $location;

    public function __construct($subject = "", $teacher = " ", $location = "")
    {
        $this->subject = $subject;
        $this->teacher = $teacher;
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }




}