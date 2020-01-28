<?php

namespace ConfrariaWeb\Task\Models;

use ConfrariaWeb\Comment\Traits\CommentTrait;
use ConfrariaWeb\Historic\Traits\HistoricTrait;
use ConfrariaWeb\Option\Traits\OptionTrait;
use ConfrariaWeb\Task\Scopes\TaskStatusClosedScope;
use ConfrariaWeb\Task\Scopes\TaskUserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Session;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Task extends Model
{
    use CommentTrait;
    use HistoricTrait;
    use Notifiable;
    use OptionTrait;
    use HasRelationships;
    use SoftDeletes;

    protected $fillable = [
        'status_id',
        'type_id',
        'user_id',
        //'datetime',
        'priority',
        'start',
        'end'
    ];

    protected $dates = [
        //'datetime',
        'start',
        'end'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new TaskUserScope);
        static::addGlobalScope(new TaskStatusClosedScope);
    }

    public function status()
    {
        return $this->belongsTo('ConfrariaWeb\Task\Models\TaskStatus', 'status_id');
    }

    public function steps()
    {
        return $this->belongsToMany('ConfrariaWeb\Task\Models\TaskStep', 'task_step', 'task_id', 'step_id');
    }

    public function type()
    {
        return $this->belongsTo('ConfrariaWeb\Task\Models\TaskType', 'type_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'users', 'task_id', 'user_id');
    }

    public function destinateds()
    {
        return $this->belongsToMany('App\User', 'task_destinated', 'task_id', 'user_id');
    }

    public function responsibles()
    {
        return $this->belongsToMany('App\User', 'task_responsible', 'task_id', 'user_id');
    }

    public function format()
    {
        return collect([
            'id' => $this->id,
            'title' => $this->type->name,
            'type' => $this->type->name,
            'color' => $this->type->color,
            'icon' => $this->type->icon,
            'icon_html' => (isset($this->type->icon)) ?
                '<i class="' . $this->type->icon . '"></i>' :
                Str::substr($this->type->name, 0, 1),
            'description' => option($this, 'description', NULL),
            'status' => $this->status->name ?? '',
            'priority' => $this->priority,
            'options' => $this->options,
            'optionsValues' => $this->optionsValues,
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'destinateds' => $this->destinateds->map(function ($item, $key) {
                $item->optionsValues = $item->optionsValues;
                $item->contact = $item->contacts;
                return $item;
            }),

            'responsibles' => $this->responsibles->map(function ($item, $key) {
                $item->optionsValues = $item->optionsValues;
                $item->contact = $item->contacts;
                return $item;
            }),

            'implode' => [
                'destinateds' => $this->destinateds->implode('name', ', '),
                'responsibles' => $this->responsibles->implode('name', ', ')
            ],
            'employees' => $this->employees,
            'datetime' => $this->start->format('d/m/Y'),
            'date' => $this->start->format('d/m/Y'),
            'time' => $this->start->format('h:m'),
            'start' => isset($this->start) ? $this->start->diffForHumans() : NULL,
            'end' => isset($this->end) ? $this->end->diffForHumans() : NULL,
            'created' => isset($this->created_at) ? $this->created_at->diffForHumans() : NULL,
            'created_at' => isset($this->created_at) ? $this->created_at : NULL,
            'updated' => isset($this->updated_at) ? $this->updated_at->diffForHumans() : NULL,
            'updated_at' => isset($this->updated_at) ? $this->updated_at : NULL,
            'closed' => isset($this->type->closedStatus) && ($this->type->closedStatus->id == $this->status_id),
            'closedStatus' => $this->type->closedStatus->id?? NULL,
            'closedStatusName' => $this->type->closedStatus->name?? NULL,
            'historics' => $this->historics,
            'comments' => $this->comments,
        ]);
    }

}
