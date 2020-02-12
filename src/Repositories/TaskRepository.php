<?PHP

namespace ConfrariaWeb\Task\Repositories;

use ConfrariaWeb\Task\Contracts\TaskContract;
use ConfrariaWeb\Task\Models\Task;
use ConfrariaWeb\Task\Scopes\TaskStatusClosedScope;
use ConfrariaWeb\Vendor\Traits\RepositoryTrait;

class TaskRepository implements TaskContract
{

    use RepositoryTrait;

    function __construct(Task $task)
    {
        $this->obj = $task;
    }

    public function where(array $data = [], $take = null)
    {

        if (isset($data['withoutGlobalScope'])) {
            $this->obj = $this->obj->withoutGlobalScope($data['withoutGlobalScope']);
        }

        if (isset($data['search']['value'])) {
            $this->obj = $this->obj->whereHas('type', function ($query) use ($data) {
                $query->where('task_types.name', 'like', '%' . $data['search']['value'] . '%');
            });
            $this->obj = $this->obj->orWhereHas('status', function ($query) use ($data) {
                $query->where('task_statuses.name', 'like', '%' . $data['search']['value'] . '%');
            });
            $this->obj = $this->obj->orWhereHas('destinateds', function ($query) use ($data) {
                $query->where('users.name', 'like', '%' . $data['search']['value'] . '%');
            });
            $this->obj = $this->obj->orWhereHas('responsibles', function ($query) use ($data) {
                $query->where('users.name', 'like', '%' . $data['search']['value'] . '%');
            });
        }

        if (isset($data['start']) && isset($data['end'])) {
            $this->obj = $this->obj
                ->whereDate('start', '>=', $data['start'])
                ->whereDate('start', '<=', $data['end']);
        }else if(isset($data['start']) && !isset($data['end'])){
            $this->obj = $this->obj
                ->whereDate('start', '>=', $data['start']);
        }else if(!isset($data['start']) && isset($data['end'])){
            $this->obj = $this->obj
                ->whereDate('start', '<=', $data['end']);
        }

        if (isset($data['type_id'])) {
            $this->obj = $this->obj->where('type_id', $data['type_id']);
        }

        if (isset($data['user_id'])) {
            $this->obj = $this->obj->where('user_id', $data['user_id']);
        }

        if (isset($data['users']) && is_array($data['users'])) {
            $this->obj = $this->obj->whereIn('user_id', $data['users']);
        }

        if (isset($data['types']) && is_array($data['types'])) {
            $this->obj = $this->obj->whereIn('type_id', $data['types']);
        }

        if (isset($data['status']) && is_array($data['status'])) {
            $this->obj = $this->obj->where('status_id', $data['status']);
        }

        if (isset($data['statuses']) && is_array($data['statuses'])) {
            $this->obj = $this->obj->whereIn('status_id', $data['statuses']);
        }

        if (isset($data['destinateds']) && is_array($data['destinateds'])) {
            $this->obj = $this->obj->whereHas('destinateds', function ($query) use ($data) {
                $query->whereIn('users.id', $data['destinateds']);
            });
        }

        if (isset($data['responsibles']) && is_array($data['responsibles'])) {
            $this->obj = $this->obj->whereHas('responsibles', function ($query) use ($data) {
                $query->whereIn('users.id', $data['responsibles']);
            });
        }

        if (isset($data['order'])) {
            $this->obj = $this->obj->orderBy($this->obj, $data['order']);
        }

        //dd($this->obj->toSql());

        return $this;
    }

    public function orderBy($obj, $order, $by = 'ASC')
    {
        if ($order == 'type') {
            $this->obj = $obj->leftJoin('task_types', 'tasks.type_id', '=', 'task_types.id')
                ->orderBy('name', $by);
        }
        if ($order == 'status') {
            $this->obj = $obj->leftJoin('statuses', 'tasks.status_id', '=', 'statuses.id')
                ->orderBy('name', $by);
        }
        if ($order == 'destinateds') {
            $this->obj = $obj->addSelect('tasks.*')
                ->leftJoin('task_destinated', 'tasks.id', '=', 'task_destinated.task_id')
                ->leftJoin('users', 'task_destinated.user_id', '=', 'users.id')
                ->orderBy('task_destinated.task_id');
        }
        if ($order == 'datetime') {
            $this->obj = $obj->orderBy($order, $by);
        }
        return $this;
    }

    protected function syncs($obj, $data)
    {
        if (isset($data['employees'])) {
            //dd($data['employees']);
            //$data['users'] = array_unique(array_merge($data['employees'], isset($data['users']) ? $data['users'] : []));
            $data['users'] = $data['employees'];
            $obj->employees()->sync($data['employees']);
        }

        if (isset($data['responsibles'])) {

            $data['users'] = array_unique(array_merge($data['responsibles'], isset($data['users']) ? $data['users'] : []));
            $obj->responsibles()->sync($data['responsibles']);
        }

        if (isset($data['associates'])) {
            $data['users'] = array_unique(array_merge($data['associates'], isset($data['users']) ? $data['users'] : []));
            $obj->associates()->sync($data['associates']);
        }

        if (isset($data['destinateds'])) {
            $data['users'] = array_unique(array_merge($data['destinateds'], isset($data['users']) ? $data['users'] : []));
            $obj->destinateds()->sync($data['destinateds']);
        }

        if (isset($data['users'])) {
            //$obj->users()->sync($data['users']);
        }

        if (isset($data['optionsValues'])) {
            $obj->optionsValues()->sync($data['optionsValues']);
        }
    }

}
