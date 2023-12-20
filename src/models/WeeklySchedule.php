<?php

namespace Models;
use Controllers\UserController;

class WeeklySchedule
{

    /**
     * @var DailySchedule[]
     */
    private array $dailySchedules;

    public function __construct($code)
    {
        $this->init_schedule($code);
    }

    private function init_schedule($code)
    {
        for ($i = 0; $i < 5; $i++) {
            $this->dailySchedules[] = new DailySchedule(strtotime("monday this week +" . $i . " day"));
        }

        global $R34ICS;
        $R34ICS = new \R34ICS();
        $url = (new UserController())->getFilePath($code);

        $datas = $R34ICS->display_calendar($url, $code, true, array(), true);
        $ics_data = $datas[0];
        $dayOfTheWeek = 0;

        if (isset($ics_data['events'])) {
            foreach (array_keys((array)$ics_data['events']) as $year) {
                for ($m = 1; $m <= 12; $m++) {
                    $month = $m < 10 ? '0' . $m : '' . $m;
                    if (array_key_exists($month, (array)$ics_data['events'][$year])) {
                        foreach ((array)$ics_data['events'][$year][$month] as $day => $day_events) {
                            $dayOfTheWeek++;
                            foreach ($day_events as $day_event => $events) {
                                foreach ($events as $event) {
                                    $this->dailySchedules[$dayOfTheWeek-1]->addCourse($event);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getDailySchedules(): array
    {
        return $this->dailySchedules;
    }


}