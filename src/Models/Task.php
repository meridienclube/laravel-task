<?php

namespace ConfrariaWeb\Task\Models;

use ConfrariaWe\task\Scopes\TaskStatusCompletedScope;
use ConfrariaWeb\Comment\Traits\CommentTrait;
use ConfrariaWeb\Fullcalendar\Event;
use ConfrariaWeb\Fullcalendar\IdentifiableEvent;
use Illuminate\Database\Eloquent\Model;
use MeridienClube\Meridien\Scopes\TaskUserScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Session;
use ConfrariaWeb\Historic\Traits\HistoricTrait;
use ConfrariaWeb\Option\Traits\OptionTrait;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Task extends Model implements IdentifiableEvent
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
        'start',
        'end'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        //static::addGlobalScope(new TaskUserScope);
        //static::addGlobalScope(new TaskStatusCompletedScope);
    }


    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return (bool)$this->all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }





    public function status()
    {
        return $this->belongsTo('ConfrariaWeb\Task\Models\TaskStatus');
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
        return $this->belongsToMany('App\User', 'users','task_id', 'user_id');
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
