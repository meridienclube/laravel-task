<?php

namespace MeridienClube\Meridien\Notifications;

use MeridienClube\Meridien\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCreatedNotification extends Notification implements ShouldQueue
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
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return isset($notifiable->settings['notifications'])? $notifiable->settings['notifications'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('tasks.notification'))
            ->greeting('Olá!')
            ->line('Uma tarefa de ' . $this->task->type->name . ' foi aberta')
            ->action('Ver ' . $this->task->type->name, route('admin.tasks.show', $this->task->id))
            ->line('Notificação gerada pelo sistema Meridien Clube!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => __('tasks.created.name', ['name' => $this->task->type->name]),
            'route' => route('admin.tasks.show', $this->task->id),
            'icon' => 'flaticon2-add-1',
            'notifiable' => $notifiable
        ];
    }

}
