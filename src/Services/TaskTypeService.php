<?PHP

namespace ConfrariaWeb\Task\Services;

use ConfrariaWeb\Task\Contracts\TaskTypeContract;
use ConfrariaWeb\Vendor\Traits\ServiceTrait;

class TaskTypeService
{

    use ServiceTrait;

    public function __construct(TaskTypeContract $task_type)
    {
        $this->obj = $task_type;
    }

}
