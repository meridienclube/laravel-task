<?php


namespace MeridienClube\Meridien\Historics;

use MeridienClube\Meridien\Comment;
use MeridienClube\Meridien\Task;
use ConfrariaWeb\Historic\Contracts\HistoricContract;

class TaskCommentCreatedHistoricContract implements HistoricContract
{

    protected $comment;
    protected $task;

    public function __construct(Task $task, Comment $comment)
    {
        $this->comment = $comment;
        $this->task = $task;
    }

    public function data()
    {
        return [
            'action' => 'created',
            'content' => $this->comment->content
        ];
    }

    public function title()
    {
        return 'Comentário inserido na tarefa ' . $this->task->type->name;
    }

    public function user($collunn = null)
    {
        if($collunn == 'id'){
            return auth()->id();
        }
        return auth()->user();
    }
}
