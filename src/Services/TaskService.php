<?PHP

namespace ConfrariaWeb\Task\Services;

use ConfrariaWeb\Task\Contracts\TaskContract;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Validator;
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
            $value->name = $value->type->name . ' - ' . $value->user->name . ' - ' . $value->datetime->format('d/m/Y');
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
        if (isset($data['datetime']) && is_array($data['datetime'])) {
            $text_convert = ['dia' => 'day', 'dias' => 'days', 'mes' => 'month', 'meses' => 'months'];
            $carbon = new Carbon();
            $datetime = $carbon->toDateTimeString();
            $date = isset($data['datetime']['date']) ? trim($data['datetime']['date']) : null;
            $time = isset($data['datetime']['time']) ? trim($data['datetime']['time']) : null;

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
                    $date = explode('/', $data['datetime']['date']);
                    $day = $date[0];
                    $month = $date[1];
                    $year = $date[2];
                    $datetime = $carbon->create($year, $month, $day, $hour, $minute)->toDateTimeString();
                } elseif ($pos_traco !== false) {
                    $date = explode('-', $data['datetime']['date']);
                    $day = $date[2];
                    $month = $date[1];
                    $year = $date[0];
                    $datetime = $carbon->create($year, $month, $day, $hour, $minute)->toDateTimeString();
                } elseif ($pos_carbon !== false) {
                    $date = explode(' ', $data['datetime']['date']);
                    $period = array_key_exists($date[2], $text_convert) ? $text_convert[$date[2]] : $date[2];
                    $datetime = $carbon->add($date[1] . ' ' . $period)->toDateTimeString();
                }
            } else if (isset($data['datetime']) && !is_array($data['datetime'])) {
                $datetime = $data['datetime'];
            }

            $data['datetime'] = $datetime;
        }
        return $data;
    }

}
