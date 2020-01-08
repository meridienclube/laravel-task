<?php

namespace MeridienClube\Meridien\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->type->name,
            'status' => $this->status->name,
            'priority' => $this->priority($this->priority),
            'datetime' => $this->datetime,
            'start' => $this->datetime,
            'end' => Carbon::parse($this->datetime)->addHour(),
            'date' => $this->datetime->format('d/m/Y'),
            'time' => $this->datetime->format('H:i'),
            'description' => option($this, 'description', NULL),
            'destinateds' => isset($this->destinateds)? UserResource::collection($this->destinateds) : NULL,
            'responsibles' => isset($this->responsibles)? UserResource::collection($this->responsibles) : NULL,
            $this->mergeWhen(Auth::check(), [
                'id' => $this->id,
                'links' => [
                    'show' => route('tasks.show', $this->id),
                    'edit' => route('tasks.edit', $this->id),
                    'destroy' => route('tasks.destroy', $this->id)
                ]
            ])
        ];
    }

    private function priority($n = 3){
        $p = [
            5 => 'Muito alta',
            4 =>'Alta',
            3 => 'Normal',
            2 => 'Baixa',
            1=> 'Muito baixa'
        ];
        return isset($p[$n])? $p[$n] : NULL;
    }
}
