<?php

namespace ConfrariaWeb\Task\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->type->name,
            'status' => $this->status->name ?? '',
            'priority' => $this->priority($this->priority),
            'datetime' => $this->datetime?? '',
            'start' => $this->start?? '',
            //'end' => Carbon::parse($this->start)->addHour(),
            'end' => $this->end?? '',
            'date' => isset($this->start)? $this->start->format('d/m/Y') : '',
            'time' => isset($this->start)? $this->start->format('H:i') : '',
            'description' => option($this, 'description', NULL),
            'destinateds' => isset($this->destinateds)? $this->destinateds : NULL,
            'responsibles' => isset($this->responsibles)? $this->responsibles : NULL,
            'user' => isset($this->user)? $this->user : NULL,
            $this->mergeWhen(Auth::check(), [
                'id' => $this->id,
                'links' => [
                    'show' => route('admin.tasks.show', $this->id),
                    'edit' => route('admin.tasks.edit', $this->id),
                    'destroy' => route('admin.tasks.destroy', $this->id)
                ]
            ])
        ];
    }

    private function priority($n = 3)
    {
        $p = config('cw_task.priorities');
        return isset($p[$n]) ? $p[$n] : NULL;
    }
}
