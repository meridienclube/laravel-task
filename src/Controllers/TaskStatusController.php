<?php

namespace ConfrariaWeb\Task\Controllers;

use ConfrariaWeb\Task\Requests\StoreTaskTypeRequest;
use ConfrariaWeb\Task\Requests\UpdateTaskTypeRequest;
use App\Http\Controllers\Controller;

class TaskStatusController extends Controller
{

    protected $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(StoreTaskTypeRequest $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(UpdateTaskTypeRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function trashed()
    {
        //
    }
}
