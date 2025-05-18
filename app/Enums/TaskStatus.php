<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Done = 'done';
    case Cancelled = 'cancelled';
    case Blocked = 'blocked';

    public static function labels(): array
    {
        return [
            self::Todo->value => 'À faire',
            self::InProgress->value => 'En cours',
            self::Done->value => 'Terminé',
            self::Cancelled->value => 'Annulé',
            self::Blocked->value => 'Bloqué',
        ];
    }
}
