<?PHP

namespace ConfrariaWeb\Task\Repositories;

use ConfrariaWeb\Task\Contracts\TaskStatusContract;
use ConfrariaWeb\Task\Models\TaskStatus;
use ConfrariaWeb\Vendor\Traits\RepositoryTrait;

class TaskStatusRepository implements TaskStatusContract
{

    use RepositoryTrait;

    function __construct(TaskStatus $task_status)
    {
        $this->obj = $task_status;
    }

}
