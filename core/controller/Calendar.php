<?php


namespace Controller;


class Calendar extends \Controller
{
    public function index()
    {
        $calendar = new \Modules\Calendar();
        $months = $calendar->getMonths();
        $current_month = $calendar->getCurrentMonth();
        $current_year = $calendar->getCurrentYear();
        $days = $calendar->getDays();
        $this->view('calendar', ['months'=>$months, "current_month"=> $current_month,"current_year"=> $current_year,"days"=> $days ]);
    }

    public function render($params){
        $calendar = new \Modules\Calendar($params[0], $params[1]);
        $months = $calendar->getMonths();
        $current_month = $calendar->getCurrentMonth();
        $current_year = $calendar->getCurrentYear();
        $days = $calendar->getDays();
        $this->view('calendar', ['months'=>$months,"current_month"=> $current_month,"current_year"=> $current_year,"days"=> $days ]);
    }

    public function year($params){
        $calendar = new \Modules\Calendar($params[0]);
        $months = $calendar->getMonths();
        $months[12] = '';
        $current_year = $calendar->getCurrentYear();
        $all_days = $calendar->getAllDays();
        $this->view('year', ['months'=>$months,"current_year"=> $current_year,"all_days"=> $all_days ]);
    }

    public function show(array $params)
    {

        try {
            $calendar = new \Models\Calendar();
            if(count($params[1]) < 2){
                $params[1] = '0'.$params[1];
            }
            $date = $params[0] . '-' . $params[1] . '-' . $params[2];
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descript']) && trim($_POST['descript']) !== '') {
                $stm = $calendar->table()->from('(description, time, created_at, creator)')->set([$_POST['descript'], $date, date('Y-m-d H:i:s'), $_SESSION['creator']]);
            }
        } catch (PDOException $e) {
            trigger_error('');
        }
        $note = $calendar->table()->from('*')->where('time', '=', $date)->getAll();
        $this->view->assign('note', $note);
        $this->view('calendarform');
    }

    public function delete(array $params){
        $calendar = new \Models\calendar();
        $stm=$calendar->table()->from('*')->where('id', '=', $params[0])->delete();
    }

}