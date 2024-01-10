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
    private int $duration;
    private bool $isDemiGroupe;

    public function __construct($subject = "", $teacher = " ", $location = "", $duration = "", $group = "")
    {
        $this->subject = $subject;
        $this->teacher = $teacher;
        $this->location = $location;
        $duration = preg_split("/ - /",$duration);
        $this->heureDeb = $duration[0];
        $this->heureFin = $duration[1];
        $this->group = $group;
        $this->duration = $this->calcDuration();
        $this->isDemiGroupe = false;
    }

    private function calcDuration(){
        $listeHorraireDebut = ["8:15","9:15","10:40","11:15","13:30","14:35","15:40","16:25"];
        $listeHorraireFin = ["9:15","10:15","11:15","12:15","14:25","15:20","16:35","17:30"];
        $indexHorraire = 0;
        $duration = 0;

        while($indexHorraire < sizeof($listeHorraireDebut)){
            $heureFinCours = strtotime(str_replace('h',':',$this->getHeureFin()));
            $heureDebutCours = strtotime(str_replace('h',':',$this->getHeureDeb()));

            if($heureDebutCours <= strtotime($listeHorraireDebut[$indexHorraire])){
                if($heureFinCours >= strtotime($listeHorraireFin[$indexHorraire])) {
                    $duration++;
                }
            }
            $indexHorraire++;
        }
        return $duration;

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

    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return bool
     */
    public function isDemiGroupe(): bool
    {
        return $this->isDemiGroupe;
    }

    /**
     * @param bool $isDemiGroupe
     */
    public function setIsDemiGroupe(bool $isDemiGroupe): void
    {
        $this->isDemiGroupe = $isDemiGroupe;
    }












}