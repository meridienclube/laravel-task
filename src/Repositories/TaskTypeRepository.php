<?PHP

namespace ConfrariaWeb\Task\Repositories;

use ConfrariaWeb\Task\Contracts\TaskTypeContract;
use ConfrariaWeb\Task\Models\TaskType;
use ConfrariaWeb\Vendor\Traits\RepositoryTrait;

class TaskTypeRepository implements TaskTypeContract
{

    use RepositoryTrait;

    function __construct(TaskType $task_type)
    {
        $this->obj = $task_type;
    }

    public function where(array $data = [], $take = null)
    {
        $w = $this->obj;
        if (isset($data['types']) && is_array($data['types'])) {
            $w = $w->whereIn('tasks.id', $data['types']);
        }
        $w = isset($take) ? $w->paginate($take) : $w->get();
        return $w;
    }

    protected function syncs($obj, $data)
    {
        if (isset($data['permissions'])) {
            $obj->permissions()->sync($data['permissions']);
        }
    }

}
