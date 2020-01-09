<?php

namespace MeridienClube\Meridien\Notifications;

use MeridienClube\Meridien\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCommentCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return isset($notifiable->settings['notifications'])? $notifiable->settings['notifications'] : ['database'];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Um comentario na tarefa de ' . $this->task->type->name . ' foi criado');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('tasks.notification'))
            ->greeting('Olá!')
            ->line('Um comentário na tarefa de ' . $this->task->type->name . ' foi criado')
            ->action('Ver Tarefa' . $this->task->type->name, route('admin.tasks.show', $this->task->id))
            ->line('Notificação gerada pelo sistema Meridien Clube!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => __('tasks.comment.created'),
            'route' => route('admin.tasks.show', $this->task->id) . '#comments',
            'icon' => 'flaticon2-add-1',
            'notifiable' => $notifiable
        ];
    }
}
