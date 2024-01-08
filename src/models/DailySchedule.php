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
        if(sizeof($this->courseList) == 0) return [];
        $courseList = $this->courseList;
        $dailyScheduleWithPause = [];
        $listeHorraireDebut = ["8:15","9:15","10:40","11:10","13:30","14:35","15:40","16:25"];
        $indexHorraire = 0;
        $indexCourse = 0;
        while($indexHorraire < sizeof($listeHorraireDebut) && $indexHorraire < 8){
            if($indexCourse >= sizeof($courseList)){
                $dailyScheduleWithPause[] = null;
                $indexHorraire++;
                continue;
            }
            $heureDebutCours = strtotime(str_replace('h',':',$courseList[$indexCourse]->getHeureDeb()));
            if($heureDebutCours <= strtotime($listeHorraireDebut[$indexHorraire])){
                $dailyScheduleWithPause[] = $courseList[$indexCourse];
                $indexHorraire += $courseList[$indexCourse]->getDuration();
                $indexCourse++;
            }else{
                $dailyScheduleWithPause[] = null;
                $indexHorraire++;
            }
        }
        return $dailyScheduleWithPause;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }




}
