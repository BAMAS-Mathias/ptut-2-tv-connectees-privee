<?php

namespace Controllers;

use Models\DailySchedule;
use Models\WeeklySchedule;
use Views\SecretaryView;

class RoomController{

    public function getRoomDailyScheduleList($roomName){
        $roomName = 'I-010';
        $codeAde = ['8382','8380','8383','8381','8396','8397','8398','42523','42524','42525'];
        $roomDailyScheduleList = [];
        foreach($codeAde as $code){
            $weeklySchedule = new WeeklySchedule($code);
            for($i = 0; $i < sizeof($weeklySchedule->getDailySchedules()); ++$i){
                $dailySchedule = $weeklySchedule->getDailySchedules()[$i];

                // Assurez-vous que la position $i existe dans $roomDailyScheduleList avant de l'utiliser
                if (!isset($roomDailyScheduleList[$i])) {
                    $roomDailyScheduleList[$i] = new DailySchedule($dailySchedule->getDate());
                }

                foreach($dailySchedule->getCourseList() as $course){
                    if($course == null){
                        continue;
                    }
                    if(strpos($course->getLocation(),$roomName) !== false){ // Cours dans la salle recherchée
                        if(!in_array($course, $roomDailyScheduleList[$i]->getCourseList())) {
                            $roomDailyScheduleList[$i]->addExistingCourse($course);
                        }
                    }
                }
            }
        }
        return $roomDailyScheduleList;
    }


    public function displayRoomWeeklySchedule(){
        if(isset($_GET['roomName'])){
            return (new SecretaryView())->displaySecretaryWelcome();
        }

        $roomName = $_GET['roomName'];
        $dailyScheduleList = $this->getRoomDailyScheduleList($roomName);
        return (new SecretaryView())->displayComputerRoomSchedule($dailyScheduleList);
    }
}
