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

    public function isAvailable(){
        $isAvailable = true;
        $codeAde = ['8382','8380','8383','8381','8396','8397','8398','42523','42524','42525'];
        foreach($codeAde as $code){
            $weeklySchedule = new WeeklySchedule($code);
            foreach ($weeklySchedule->getDailySchedules() as $dailySchedule){
                if($dailySchedule->getDate() != date('Ymd')) continue;
                foreach ($dailySchedule->getCourseList() as $course){
                    if($course == null) continue;
                    if(strpos($course->getLocation(), $this->getName()) !== false){
                        $currentTime = strtotime(date('G:i'));
                        $heureDebutCours = strtotime(str_replace('h',':',$course->getHeureDeb()));
                        $heureFinCours = strtotime(str_replace('h',':',$course->getHeureFin()));
                        if($heureDebutCours < $currentTime && $heureFinCours > $currentTime){
                            $isAvailable = false;
                        }
                    }
                }
            }
        }
        return $isAvailable;
    }


}
