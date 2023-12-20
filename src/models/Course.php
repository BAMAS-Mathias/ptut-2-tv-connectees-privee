<?php

namespace Models;

class Course
{
    private string $subject;
    private string $teacher;
    private string $location;
    private string $heureDeb;
    private string $heureFin;
    private string $group;

    public function __construct($subject = "", $teacher = " ", $location = "", $duration = "", $group = "")
    {
        $this->subject = $subject;
        $this->teacher = $teacher;
        $this->location = $location;
        $duration = preg_split("/ - /",$duration);
        $this->heureDeb = $duration[0];
        $this->heureFin = $duration[1];
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
    public function getHeureDeb(): string
    {
        return $this->heureDeb;
    }

    /**
     * @return string
     */
    public function getHeureFin(): string
    {
        return $this->heureFin;
    }


    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }








}