<?PHP

namespace ConfrariaWeb\Task\Services;

use ConfrariaWeb\Task\Contracts\TaskContract;
use Carbon\Carbon;
use ConfrariaWeb\Task\Resources\TaskResource;
use Illuminate\Support\Facades\Log;
use ConfrariaWeb\Vendor\Traits\ServiceTrait;

class TaskService
{
    use ServiceTrait;

    public function __construct(TaskContract $task)
    {
        $this->obj = $task;
    }

    function pluck()
    {
        return $this->obj->all()->map(function ($value, $key) {
            $value->name = $value->type->name . ' - ' . $value->user->name . ' - ' . $value->start->format('d/m/Y');
            return $value;
        })->pluck('name', 'id');
    }

    /**
     * @param $id - id da tarefa
     * @return bool - retorna false quando não mudar o status para fechado.
     */
    public function close($id, $comment)
    {
        try {
            $task = $this->find($id);
            if (!$task->type->closedStatus) {
                return false;
            }
            $updateStatus = resolve('TaskService')
                ->update(['status_id' => $task->type->closedStatus->id], $id);
            if ($updateStatus) {
                $this->createComment('Tarefa concluida: ' . $comment, $id);
                return true;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $data
     * Formatos aceitos para $data['datetime']['date']:
     * 27/03/1998 - formato brasileiro
     * 1998-03-27 - formato americano
     * + 30 dias || 30 days - formato carbon para adicionar dias
     * + 2 meses || 2 months - formato carbon para adicionar dias
     * @return mixed
     * @throws \Exception
     */
    protected function prepareData($data)
    {
        $formatsDates = [
            'd/m/Y H:i',
            'd/m/Y H:i:s',
            'Y-m-d H:i',
            'Y-m-d H:i:s'
        ];

        foreach($formatsDates as $dateFormat){
            if(isset($data['start']) && $this->validateDate($data['start'], $dateFormat)){
                $data['start'] = \DateTime::createFromFormat($dateFormat, $data['start'])
                    ->format('Y-m-d H:i:s');
            }
            if(isset($data['end']) && $this->validateDate($data['end'], $dateFormat)){
                $data['end'] = \DateTime::createFromFormat($dateFormat, $data['end'])
                    ->format('Y-m-d H:i:s');
            }
        }

        if(!isset($data['start']) || !$this->validateDate($data['start'])){
            $data['start'] = date('Y-m-d H:i:s');
        }

        if(!isset($data['end']) || !$this->validateDate($data['start'])){
            $data['end'] = date('Y-m-d H:i:s');
        }

        //dd(\DateTime::createFromFormat('d/m/Y H:i', $data['start'])->format('Y-m-d H:i:s'));
        //dd($this->validateDate($data['start'], 'd/m/Y H:i'));
        //dd(Carbon::parse($data['start'])->toDateString()); //format('Y-m-d H:i:s'));
/*
        if (isset($data['start']) && is_array($data['start'])) {
            $text_convert = ['dia' => 'day', 'dias' => 'days', 'mes' => 'month', 'meses' => 'months'];
            $carbon = new Carbon();
            $datetime = $carbon->toDateTimeString();
            $date = isset($data['start']['date']) ? trim($data['start']['date']) : null;
            $time = isset($data['start']['time']) ? trim($data['start']['time']) : null;

            if ($time) {
                $time = explode(':', $time);
            }

            if ($date) {
                $pos_contrabarra = strpos($date, '/');
                $pos_traco = strpos($date, '/');
                $pos_carbon = strpos($date, '+');

                $hour = isset($time[0]) ? $time[0] : 0;
                $minute = isset($time[1]) ? $time[1] : 0;
                if ($pos_contrabarra !== false) {
                    $date = explode('/', $data['start']['date']);
                    $day = $date[0];
                    $month = $date[1];
                    $year = $date[2];
                    $datetime = $carbon->create($year, $month, $day, $hour, $minute)->toDateTimeString();
                } elseif ($pos_traco !== false) {
                    $date = explode('-', $data['start']['date']);
                    $day = $date[2];
                    $month = $date[1];
                    $year = $date[0];
                    $datetime = $carbon->create($year, $month, $day, $hour, $minute)->toDateTimeString();
                } elseif ($pos_carbon !== false) {
                    $date = explode(' ', $data['start']['date']);
                    $period = array_key_exists($date[2], $text_convert) ? $text_convert[$date[2]] : $date[2];
                    $datetime = $carbon->add($date[1] . ' ' . $period)->toDateTimeString();
                }
            } else if (isset($data['start']) && !is_array($data['start'])) {
                $datetime = $data['start'];
            }

            $data['start'] = $datetime;
        }

        //$this->validateMysqlDate($data['start']);
*/
        return $data;
    }



    /*
    protected function validateMysqlDate( $date ){
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $date, $matches)) {
            if (checkdate($matches[2], $matches[3], $matches[1])) {
                return true;
            }
        }
        return false;
    }
*/
    public function calendar($data)
    {
        //$from = '2020-01-20 00:00:00';
        //$to = '2020-01-21 11:59:59';
        //$tasks = $this->obj->whereBetween('start', '2020-01-01', '2020-01-31')->get();
        //dd($tasks->whereBetween('start', [$from, $to]));

        $ym = $data['ym']?? NULL;
        if (!isset($ym)) {
            $ym = date('Y-m');
        }
        $timestamp = strtotime($ym . '-01');
        if ($timestamp === false) {
            $ym = date('Y-m');
            $timestamp = strtotime($ym . '-01');
        }
        $today = date('Y-m-j', time());
        $data['html_title'] = date('Y / m', $timestamp);
        $data['prev'] = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
        $data['next'] = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));
        // $prev = date('Y-m', strtotime('-1 month', $timestamp));
        // $next = date('Y-m', strtotime('+1 month', $timestamp));
        $day_count = date('t', $timestamp);
        $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
        //$str = date('w', $timestamp);

        $tasksFrom = $ym. '-01';
        $tasksTo = $ym . '-' . $day_count;
        $tasks = $this->obj->whereBetween('start', $tasksFrom, $tasksTo)->get();
        //dd($tasks);

        // Create Calendar!!
        $data['weeks'] = array();
        $week = '';
        $week .= str_repeat('<td></td>', $str);
        for ($day = 1; $day <= $day_count; $day++, $str++) {
            $tasksDayFrom = $ym . '-' . str_pad($day , 2 , '0' , STR_PAD_LEFT) . ' 00:00:00';
            $tasksDayTo = $ym . '-' . str_pad($day , 2 , '0' , STR_PAD_LEFT) . ' 11:59:59';
            //dd($tasksDayFrom);
            $tasksDay = $tasks->whereBetween('start', [$tasksDayFrom, $tasksDayTo]);
            $date = $ym . '-' . $day;
            if ($today == $date) {
                $week .= "<td class='today' scope='row' class='bg-warning'><span class='span_day bg-info text-white'>" . $day . "</span>";
            } else {
                $week .= "<td scope='row'><span class='span_day bg-info text-white'>" . $day . "</span>";
            }

            //$week .= "<span>(" . $tasksDay->count() . ")</span>";
            $week .= "<ul>";
            foreach ($tasksDay as $taskDay){
                $week .= "<li><a data-task='" . $taskDay->format() . "' href='javascript:void(0)' style='background:" . $taskDay->type->color . "' class='task_link'>" . $taskDay->type->name . "</a></li>";
            }
            $week .= "</ul>";
            $week .= "</td>";
            if ($str % 7 == 6 || $day == $day_count) {
                if ($day == $day_count) {
                    $week .= str_repeat('<td></td>', 6 - ($str % 7));
                }
                $count = 0;
                $data['weeks'][] = '<tr>' . $week . '</tr>';
                $week = '';
            }
        }
        return $data;
    }

}
