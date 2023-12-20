<?php

namespace Models;

class Course
{
    private string $subject;
    private string $teacher;
    private string $location;
    private string $duration;
    private string $group;

    public function __construct($subject = "", $teacher = " ", $location = "", $duration = "", $group = "")
    {
        $this->subject = $subject;
        $this->teacher = $teacher;
        $this->location = $location;
        $this->duration = $duration;
        $this->group = $group;
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

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }








}