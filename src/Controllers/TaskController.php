<?php

namespace ConfrariaWeb\Task\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use ConfrariaWeb\Fullcalendar\Calendar;
use ConfrariaWeb\Task\Models\Task;
use ConfrariaWeb\Task\Requests\StoreTaskCommentRequest;
use ConfrariaWeb\Task\Requests\StoreScheduleRequest;
use ConfrariaWeb\Task\Requests\StoreTaskRequest;
use ConfrariaWeb\Task\Requests\UpdateScheduleRequest;
use ConfrariaWeb\Task\Requests\UpdateTaskRequest;
use ConfrariaWeb\Task\Resources\TaskResource;
use ConfrariaWeb\Task\Resources\UserResource;
use ConfrariaWeb\Task\Scopes\TaskStatusClosedScope;
use ConfrariaWeb\Task\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    protected $data;

    public function __construct(Request $request)
    {
        $this->data['types'] = resolve('TaskTypeService')->all();
        $this->data['closure_status'] = resolve('TaskStatusService')->where(['closure' => 1])->first();
        $this->data['statuses'] = resolve('TaskStatusService')->all();
        $this->data['destinateds'] = [];
        $this->data['responsibles'] = [];
        if (isset($request->destinated_id)) {
            $destinated = resolve('UserService')->find($request->destinated_id);
            $this->data['destinateds'][$destinated->id] = $destinated->name;
        }
    }

    public function updateDate(Request $request)
    {
        $data['datetime'] = gmdate('Y-m-d H:i:s', strtotime($request->date));
        return resolve('TaskService')->update($data, $request->task_id);
    }

    public function close(Request $request, $id)
    {
        $task = resolve('TaskService')->find($id);
        abort_unless($task, 404);
        $this->authorize('update', $task);
        $comment = $request->comment;
        if (!isset($comment)) {
            return back()->withInput()
                ->with('danger', 'Para concluir a tarefa é necessário deixar um comentário!');
        }
        $close = resolve('TaskService')->close($id, $comment);
        return redirect()->route('admin.tasks.index')->with('status', 'Tarefa finalizada com sucesso!');
    }

    public function reschedule(Request $request, $id)
    {
        resolve('TaskService')->update($request->all(), $id);
        return back()->withInput()
            ->with('status', 'Tarefa atualizada com sucesso!');
    }

    public function updateStatus($id, $status_id)
    {
        $updateStatus = resolve('TaskService')->update(['status_id' => $status_id], $id);
        return back()->withInput()
            ->with('status', 'Status da tarefa atualizada com sucesso!');
    }

    public function storeComment(StoreTaskCommentRequest $request, $task_id)
    {
        $TaskService = resolve('TaskService')->createComment($request->all(), $task_id);
        return redirect()
            ->route('admin.tasks.show', $task_id)
            ->with('status', 'Comentário criado com sucesso!');
    }

    public function datatable(Request $request)
    {
        $data = $request->all();

        $data['where'] = array();
        if(isset($data['data'])) {
            parse_str($data['data'], $data['where']);
        }

        if(isset($data['where']['see_completed'])){
            $data['where']['withoutGlobalScope'] = 'ConfrariaWeb\Task\Scopes\TaskStatusClosedScope';
        }

        if(isset($data['where']['see_completed'])){
            $data['without_scopes'][] = '\ConfrariaWeb\Task\Scope\TaskStatusClosedScope::class';
        }
        /*Tratamento para datetimepicker*/
        if(isset($data['where']['start']) && $data['where']['start'] == '__/__/____ __:__'){
            unset($data['where']['start']);
        }
        if(isset($data['where']['end']) && $data['where']['end'] == '__/__/____ __:__'){
            unset($data['where']['end']);
        }
        $data['where']['search'] = $data['search'] ?? NULL;


        /*
        foreach ($data['columns'] as $column) {
            $data['where'][$column['name']] = $column['search']['value'];
        }
        */

        $datatable = resolve('TaskService')->datatable($data);
        return (TaskResource::collection($datatable['data']))
            ->additional([
                'draw' => $datatable['draw'],
                'recordsTotal' => $datatable['recordsTotal'],
                'recordsFiltered' => $datatable['recordsFiltered']
            ]);
    }

    /*
        public function calendar(TaskService $taskService)
        {
            $events = [];
            //$tasks = Task::cursor();
            $tasks = resolve('TaskService')->all();

            foreach ($tasks as $task) {
                $events[] = \ConfrariaWeb\Fullcalendar\Facades\Calendar::event(
                    $task->type->name, //event title
                    false, //full day event?
                    $task->start, //start time (you can also use Carbon instead of DateTime)
                    $task->end, //end time (you can also use Carbon instead of DateTime)
                    $task->id, //optional event ID
                    [
                        'url' => route('admin.tasks.show', $task->id)
                    ]
                );
            }
            $eloquentEvent = Task::first();
            $calendar = \ConfrariaWeb\Fullcalendar\Facades\Calendar::addEvents($events)
                ->addEvent($eloquentEvent, [
                    'color' => '#800',
                    'eventClick' => 'function() {alert("teste")}'
                ])->setOptions([
                    'firstDay' => 1
                ])->setCallbacks([
                    'viewRender' => 'function() {}'
                ]);
            return view(config('cw_task.views') . 'tasks.calendar', compact('calendar'));
        }
    */

    public function calendar(Request $request)
    {
        $this->data['calendar'] = resolve('TaskService')->calendar($request->all());
        return view(config('cw_task.views') . 'tasks.calendar', $this->data);
    }

    public function index(Request $request)
    {
        $data = $request->all();

        if(isset($data['see_completed'])){
            $this->data['withoutGlobalScope'] = 'ConfrariaWeb\Task\Scopes\TaskStatusClosedScope';
        }
        $this->data['responsibles'] = isset($data['responsibles']) ? resolve('UserService')->whereIn('id', $data['responsibles'])->get() : NULL;

        return view(config('cw_task.views') . 'tasks.index', $this->data);
    }

    public function create(Request $request)
    {
        $this->data['calendar'] = resolve('TaskService')->calendar($request->all());
        $this->data['responsibles'][auth()->id()] = auth()->user()->name;
        return view(config('cw_task.views') . 'tasks.create', $this->data);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $data['user_id'] ?? auth()->id();
        $task = resolve('TaskService')->create($data);
        return redirect()
            ->route('admin.tasks.edit', $task->id)
            ->with('status', 'Tarefa criada com sucesso!');
    }

    public function show($id)
    {
        $this->data['task'] = resolve('TaskService')->find($id);
        abort_unless($this->data['task'], 404);
        $this->authorize('view', $this->data['task']);
        $this->data['destinateds'] = $this->data['task']->destinateds ?? $this->data['destinateds'];
        $this->data['responsibles'] = $this->data['task']->responsibles ?? $this->data['responsibles'];
        return view(config('cw_task.views') . 'tasks.show', $this->data);
    }

    public function edit(Request $request, $id)
    {
        $this->data['calendar'] = resolve('TaskService')->calendar($request->all());
        $this->data['task'] = resolve('TaskService')->find($id);
        abort_unless($this->data['task'], 404);
        $this->authorize('update', $this->data['task']);
        $this->data['destinateds'] = $this->data['task']->destinateds->pluck('name', 'id') ?? [];
        $this->data['responsibles'] = $this->data['task']->responsibles->pluck('name', 'id') ?? [auth()->id() => auth()->user()->name];
        return view(config('cw_task.views') . 'tasks.edit', $this->data);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = resolve('TaskService')->update($request->all(), $id);
        return redirect()
            ->route('admin.tasks.edit', $task->id)
            ->with('status', 'Tarefa editado com sucesso!');
    }

    public function destroy($id)
    {
        $task = resolve('TaskService')->destroy($id);
        return redirect()
            ->route('admin.tasks.index')
            ->with('status', 'Tarefa deletado com sucesso!');
    }

}
