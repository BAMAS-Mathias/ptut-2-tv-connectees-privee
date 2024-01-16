<?php
namespace Models;

class Room{

    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isAvailableAt($time){
        $isAvailable = true;
        $codeAde = ['8382','8380','8383','8381','8396','8397','8398','42523','42524','42525'];
        foreach($codeAde as $code){
            $weeklySchedule = new WeeklySchedule($code);
            foreach ($weeklySchedule->getDailySchedules() as $dailySchedule){
                if($dailySchedule->getDate() != date('Ymd')) continue;
                foreach ($dailySchedule->getCourseList() as $course){
                    if($course == null) continue;
                    if(strpos($course->getLocation(), $this->getName()) !== false){
                        $heureDebutCours = strtotime(str_replace('h',':',$course->getHeureDeb()));
                        $heureFinCours = strtotime(str_replace('h',':',$course->getHeureFin()));
                        if($heureDebutCours < $time && $heureFinCours > $time){
                            $isAvailable = false;
                        }
                    }
                }
            }
        }
        return $isAvailable;
    }

    public function isAvailable(){
        return $this->isAvailableAt(strtotime(date('G:i')));
    }

    public function getAllCourseBetween($startTime, $endTime){

    }

}
