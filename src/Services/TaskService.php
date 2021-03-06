<?PHP

namespace ConfrariaWeb\Task\Services;

use ConfrariaWeb\Task\Contracts\TaskContract;
use Carbon\Carbon;
use ConfrariaWeb\Task\Resources\TaskResource;
use Illuminate\Support\Facades\Log;
use ConfrariaWeb\Vendor\Traits\ServiceTrait;
use Illuminate\Support\Str;

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
            $this->createComment('Tarefa concluida: ' . $comment, $id);
            $updateStatus = resolve('TaskService')
                ->update(['status_id' => $task->type->closedStatus->id], $id);
            if ($updateStatus) {

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

        //$carbon = new Carbon();
        $formatsDates = [
            'd/m/Y H:i',
            'd/m/Y H:i:s',
            'Y-m-d H:i',
            'Y-m-d H:i:s'
        ];
        $start = $data['start']?? NULL;
        $end = $data['end']?? NULL;
        //$data['start'] = NULL;
        //$data['end'] = NULL;

        foreach ($formatsDates as $dateFormat) {
            if (isset($start) && $this->validateDate($start, $dateFormat)) {
                $data['start'] = \DateTime::createFromFormat($dateFormat, $start)
                    ->format('Y-m-d H:i:s');
            }
            if (isset($end) && $this->validateDate($end, $dateFormat)) {
                $data['end'] = \DateTime::createFromFormat($dateFormat, $end)
                    ->format('Y-m-d H:i:s');
            }
        }

        /*if (!isset($data['start']) && !isset($data['end']) && isset($data['datetime'])) {
            $text_convert = [
                'minuto' => 'minute',
                'minutos' => 'minutes',
                'hora' => 'hour',
                'horas' => 'hours',
                'dia' => 'day',
                'dias' => 'days',
                'mes' => 'month',
                'meses' => 'months',
                'ano' => 'year',
                'anos' => 'years'
            ];
            $pos_carbon = strpos($data['datetime'], '+');
            if ($pos_carbon !== false) {
                $date = explode(' ', $data['datetime']);
                $period = array_key_exists($date[2], $text_convert) ? $text_convert[$date[2]] : $date[2];
                $data['start'] = $carbon->add($date[1] . ' ' . $period)->toDateTimeString();
                $data['end'] = $carbon->add($date[1] . ' ' . $period)->addMinutes(30)->toDateTimeString();
            }

        }*/

        /*
        if (!isset($data['start']) || !$this->validateDate($data['start'])) {
            $data['start'] = date('Y-m-d H:i:s');
        }

        if (isset($data['start']) && (!isset($data['end']) || !$this->validateDate($data['end']))) {
            //$data['end'] = $carbon->instance($data['start'])->addMinutes(30)->toDateTimeString();
            $data['end'] = $carbon->setDateTimeFrom($data['start'])->addMinutes(30)->toDateTimeString();
        }

        if (!isset($data['end']) || !$this->validateDate($data['end'])) {
            $data['end'] = date('Y-m-d H:i:s');
        }
        */

        //dd($data);

        return $data;
    }

    public function calendar($data)
    {
        $data['format'] = $data['f'] ?? 'month';
        $data['day'] = isset($data['d']) ? date('Y-m-d', strtotime($data['d'])) : date('Y-m-d');
        $data['title'] = date('d/m/Y', strtotime($data['day']));
        //$diferencadias = strtotime($data['day']) - strtotime("now");
        //$diferencadias = ($diferencadias < 0)? $diferencadias * -1 : $diferencadias;

        /*dd(
            date('Y-m-d H:i:s', strtotime($data['day'])),
            date('Y-m-d H:i:s', strtotime('monday this week', strtotime($data['day'])))
        );*/

        if (isset($data['f']) && $data['f'] == 'day') {
            $data['prev'] = date('Y-m-d', strtotime($data['day'] . "-1 days"));
            $data['next'] = date('Y-m-d', strtotime($data['day'] . "+1 days"));
            $data['tasks'] = resolve('TaskService')->whereDate('start', $data['day'])->get();

        } else if (isset($data['f']) && $data['f'] == 'week') {
            $data['prev'] = date('Y-m-d', strtotime($data['day'] . "-7 days"));
            $data['next'] = date('Y-m-d', strtotime($data['day'] . "+7 days"));
            $data['days_of_the_week'] = [];
            $this_weeks = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            foreach ($this_weeks as $this_week) {
                $data['days_of_the_week'][$this_week] = date('Y-m-d H:i:s', strtotime($this_week . ' this week', strtotime($data['day'])));
            }

            $monday_this_week = date('Y-m-d H:i:s', strtotime('monday this week', strtotime($data['day'])));
            $friday_this_week = date('Y-m-d H:i:s', strtotime('sunday this week', strtotime($data['day'])));

            $data['tasks'] = resolve('TaskService')->whereBetween('start', $monday_this_week, $friday_this_week)->get();

        } else {
            $ym = date('Y-m', strtotime($data['day']));
            $timestamp = strtotime($ym . '-01');
            if ($timestamp === false) {
                $ym = date('Y-m');
                $timestamp = strtotime($ym . '-01');
            }
            $today = date('Y-m-j', time());
            $data['title'] = date('m/Y', $timestamp);
            $data['prev'] = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
            $data['next'] = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));
            $day_count = date('t', $timestamp);
            $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
            $tasksFrom = $ym . '-01';
            $tasksTo = $ym . '-' . $day_count;
            //dd($tasksFrom, $tasksTo);
            $tasks = $this->obj->whereBetween('start', $tasksFrom, $tasksTo)->get();
            //dd($tasks);
            $data['weeks'] = array();
            $week = '';
            $week .= str_repeat('<td></td>', $str);
            //$teste = [];
            for ($day = 1; $day <= $day_count; $day++, $str++) {

                $tasksDay = $ym . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                //$tasksDayFrom = $ym . '-' . str_pad($day, 2, '0', STR_PAD_LEFT) . ' 00:00:00';
                //$tasksDayTo = $ym . '-' . str_pad($day, 2, '0', STR_PAD_LEFT) . ' 11:59:59';
                //dd($tasksDayFrom);
                //$tasksDay = $tasks->whereBetween('start', [$tasksDayFrom, $tasksDayTo]);
                $tasksDay = $tasks->filter(function ($value, $key) use($tasksDay) {
                    return (Str::contains($value->start->format('Y-m-d'), $tasksDay))? $value : false;
                });
                //$teste[$day] = $tasksDay;
                //dd($tasksDayFrom, $tasksDayTo, $day_count);
                $date = $ym . '-' . $day;
                if ($today == $date) {
                    $week .= "<td class='today' scope='row' class='bg-warning'><span class='span_day bg-info text-white'>" . $day . "</span>";
                } else {
                    $week .= "<td scope='row'><span class='span_day bg-info text-white'>" . $day . "</span>";
                }
                $week .= "<ul>";
                foreach ($tasksDay as $taskDay) {

                    $week .= "<li><a data-task='" . $taskDay->format() . "' href='javascript:void(0)' style='background:" . $taskDay->type->color . "' class='task_link'>" . $taskDay->type->name . " para " . $taskDay->destinateds->implode('name', ' | ')  . "</a></li>";
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
            //dd($teste);
        }

        return $data;
    }

}
