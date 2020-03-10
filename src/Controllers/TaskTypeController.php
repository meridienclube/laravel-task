<?php

namespace ConfrariaWeb\Task\Controllers;

use ConfrariaWeb\Task\Requests\StoreTaskTypeRequest;
use ConfrariaWeb\Task\Requests\UpdateTaskTypeRequest;
use App\Http\Controllers\Controller;
use ConfrariaWeb\Task\Resources\Select2TaskTypeResource;
use Illuminate\Http\Request;

class TaskTypeController extends Controller
{

    protected $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function select2(Request $request)
    {
        $data = $request->all();
        $data['name'] = isset($data['term']) ? $data['term'] : NULL;
        $types = resolve('TaskTypeService')->where($data)->get();
        return Select2TaskTypeResource::collection($types);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Response
     */
    public function index()
    {
        $this->data['types'] = resolve('TaskTypeService')->all();
        return view('tasks_types.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Response
     */
    public function create()
    {
        $this->data['statuses'] = resolve('StatusService')->pluck();
        return view('tasks_types.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Request $request
     * @return \Illuminate\Response
     */
    public function store(StoreTaskTypeRequest $request)
    {
        $tasks_types = resolve('TaskTypeService')->create($request->all());
        return redirect()
            ->route('admin.tasks.types.edit', $tasks_types->id)
            ->with('status', 'Tipo de tarefa criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Response
     */
    public function show($id)
    {
        $this->data['task_type'] = resolve('TaskTypeService')->find($id);
        return view('tasks_types.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Response
     */
    public function edit($id)
    {
        $this->data['statuses'] = resolve('StatusService')->pluck();
        $this->data['type'] = resolve('TaskTypeService')->find($id);
        return view('tasks_types.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Request $request
     * @param int $id
     * @return \Illuminate\Response
     */
    public function update(UpdateTaskTypeRequest $request, $id)
    {
        $task_type = resolve('TaskTypeService')->update($request->all(), $id);
        return redirect()
            ->route('admin.tasks.types.edit', $task_type->id)
            ->with('status', 'Tipo de tarefa editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Response
     */
    public function destroy($id)
    {
        $task_type = resolve('TaskTypeService')->destroy($id);
        return redirect()
            ->route('admin.tasks.types.index')
            ->with('status', 'Tipo de tarefa deletado com sucesso!');
    }

    public function trashed()
    {
        $this->data['types'] = resolve('TaskTypeService')->trashed();
        $this->data['title'] = 'tasks.types.trashed.list';
        return view('tasks_types.index', $this->data);
    }
}
