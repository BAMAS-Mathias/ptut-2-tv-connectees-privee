<?php

namespace Controllers;

use Models\DailySchedule;
use Models\RoomRepository;
use Models\WeeklySchedule;
use Views\SecretaryView;

class RoomController{

    public function getRoomDailyScheduleList($roomName){
        $codeAde = ['8382','8380','8383','8381','8396','8397','8398','42523','42524','42525'];
        $roomDailyScheduleList = [];
        foreach($codeAde as $code){
            $weeklySchedule = new WeeklySchedule($code);
            for($i = 0; $i < sizeof($weeklySchedule->getDailySchedules()); ++$i){
                $dailySchedule = $weeklySchedule->getDailySchedules()[$i];
                if($roomDailyScheduleList[$i] == null){
                    $roomDailyScheduleList[] = new DailySchedule($dailySchedule->getDate());
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
        if(isset($_POST['roomName'])){
            $roomName = $_POST['roomName'];
            $_SESSION['roomName'] = $roomName;
        }

        if(!isset($_SESSION['roomName'])){
            return $this->displayRoomChoicePage();
        }

        $roomName = $_SESSION['roomName'];
        $dailyScheduleList = $this->getRoomDailyScheduleList($roomName);
        return (new SecretaryView())->displayComputerRoomSchedule($dailyScheduleList);
    }

    public function displayRoomChoicePage() : string{
        $model = new RoomRepository();
        return (new SecretaryView())->displayRoomChoice($model->getAllRoom());
    }
}
