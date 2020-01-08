<?PHP

namespace MeridienClube\Meridien\Services;

use MeridienClube\Meridien\Contracts\TaskTypeContract;
use Validator;
use Auth;
use ConfrariaWeb\Vendor\Traits\ServiceTrait;

class TaskTypeService
{

    use ServiceTrait;

    public function __construct(TaskTypeContract $task_type)
    {
        $this->obj = $task_type;
    }

}
