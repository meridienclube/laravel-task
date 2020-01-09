<?PHP

namespace ConfrariaWeb\Task\Services;

use ConfrariaWeb\Task\Contracts\TaskStatusContract;
use ConfrariaWeb\Vendor\Traits\ServiceTrait;

class TaskStatusService
{

    use ServiceTrait;

    public function __construct(TaskStatusContract $task_status)
    {
        $this->obj = $task_status;
    }

}
