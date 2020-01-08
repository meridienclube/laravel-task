<?php

namespace ConfrariaWe\task\Models;

use ConfrariaWe\task\Scopes\TaskStatusCompletedScope;
use MeridienClube\Meridien\Traits\CommentTrait;
use Illuminate\Database\Eloquent\Model;
use MeridienClube\Meridien\Scopes\TaskUserScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Session;
use ConfrariaWeb\Historic\Traits\HistoricTrait;
use ConfrariaWeb\Option\Traits\OptionTrait;
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
        'datetime',
        'priority'
    ];

    protected $dates = [
        'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new TaskUserScope);
        static::addGlobalScope(new TaskStatusCompletedScope);
    }

    /**
     * Busca todos os contatos de todos os destinatarios desta tarefa
     * @return \Staudenmeir\EloquentHasManyDeep\HasManyDeep
     */
    /*
    public function contactsDestinateds()
    {
        return $this->hasManyDeep('MeridienClube\Meridien\UserContact', ['task_destinated', 'MeridienClube\Meridien\UserAuth']);
    }
    */
    public function status()
    {
        return $this->belongsTo('MeridienClube\Meridien\Status');
    }

    public function type()
    {
        return $this->belongsTo('MeridienClube\Meridien\TaskType', 'type_id');
    }

    public function user()
    {
        return $this->belongsTo('MeridienClube\Meridien\UserAuth', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany('MeridienClube\Meridien\UserAuth', 'users','task_id', 'user_id');
    }

    public function associates()
    {
        return $this->belongsToMany('MeridienClube\Meridien\UserAuth', 'task_associated', 'task_id', 'user_id');
    }

    public function destinateds()
    {
        return $this->belongsToMany('MeridienClube\Meridien\UserAuth', 'task_destinated', 'task_id', 'user_id');
    }

    public function responsibles()
    {
        return $this->belongsToMany('MeridienClube\Meridien\UserAuth', 'task_responsible', 'task_id', 'user_id');
    }

    public function employees()
    {
        return $this->belongsToMany('MeridienClube\Meridien\UserAuth', 'task_employee', 'task_id', 'user_id');
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }

    public function format()
    {
        return collect($this->format_array());
    }

    public function format_array()
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
            'status' => $this->status->name,
            'priority' => $this->priority,
            'options' => $this->options,
            'optionsValues' => $this->optionsValues,
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'destinateds' => $this->destinateds,
            'implode' => [
                'destinateds' => $this->destinateds->implode('name', ', '),
                'responsibles' => $this->responsibles->implode('name', ', ')
            ],
            'employees' => $this->employees,
            'datetime' => $this->datetime->format('d/m/Y'),
            'date' => $this->datetime->format('d/m/Y'),
            'time' => $this->datetime->format('h:m'),
            'created_at' => isset($this->created_at) ? $this->created_at->diffForHumans() : NULL,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->diffForHumans() : NULL,
            'closed' => ($this->type->closedStatus->id == $this->status_id),
            'closedStatus' => $this->type->closedStatus->id,
            'closedStatusName' => $this->type->closedStatus->name,
            'historics' => $this->historics,
            'comments' => $this->comments,
        ]);
    }

}
