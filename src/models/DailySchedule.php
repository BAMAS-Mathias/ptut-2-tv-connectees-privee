<?php

namespace Models;

class DailySchedule{

    /**
     * @var Course[]
     */
    private array $courseList;
    private string $date;
    private string $group;

    public function __construct($date,$group)
    {
        $this->date = date('Ymd',$date);
        $this->courseList = array();
        $this->group = $group;
    }


    public function addCourse($event){
        $professeur = '';
        $location = '';
        $duration = str_replace(':', 'h', date("H:i", strtotime($event['deb']))) . ' - ' . str_replace(':', 'h', date("H:i", strtotime($event['fin'])));
        $group = '';
        $label = str_replace(array(' (INFO)', ' G1', ' G2', ' G3', ' G4', ' 4h', ' 2h', '*'), '', $event['label']);



        if(isset($event['description'])){
            $professeur = substr($event['description'], 0, -30);
            $professeur = preg_split('/(Groupe [1-9].?)|G[1-9].? |.?[0-9](ère|ème) (A|a)nnée.?|an[1-3]|[A-B].?-[1-3]/',$professeur);
            $professeur = $professeur[sizeof($professeur)-1];

            $group = preg_split('/' . $professeur . '/',$event['description']);
            $group = preg_replace(array('/G1/','/G2/','/G3/','/G4/'), array('Groupe 1', 'Groupe 2', 'Groupe 3', 'Groupe 4'),$group[0]);
            $group = str_replace(array('an1','an2','an3'),'',$group);
        }

        if(isset($event['location'])){
            $location = $event['location'];
        }

        $this->courseList[] = new Course($label, $professeur, $location, $duration, $group);
    }

    /**
     * @return mixed
     */
    public function getCourseList()
    {
        return $this->courseList;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }




}
