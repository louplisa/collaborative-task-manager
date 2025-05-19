<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private Task $task,
        private Project $project,
        private array $data,
        private string $context,
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $actionText = $this->context === 'created' ?
            'Une nouvelle tâche vous a été assignée ' :
            'Une tâche a été mise à jour ';
        return (new MailMessage)
            ->subject($actionText . ': ' . $this->task->title)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line($actionText . 'dans le projet : ' . $this->task->project->name . '.')
            ->line('**Titre :** ' . $this->task->title)
            ->line('**Description :** ' . $this->task->description)
            ->line('**Date limite :** ' . $this->task->deadline?->format('d/m/Y'))
            ->action('Voir la tâche', route('admin.projects.task.show', [$this->project, $this->task]))
            ->line('Merci pour votre collaboration.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'project_id' => $this->project->id,
            ...$this->data
        ];
    }
}
