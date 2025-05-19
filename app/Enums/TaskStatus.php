<?php

namespace App\Enums;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
    case CANCELLED = 'cancelled';
    case BLOCKED = 'blocked';

    public static function labels(): array
    {
        return [
            self::TODO->value => 'À faire',
            self::IN_PROGRESS->value => 'En cours',
            self::DONE->value => 'Terminé',
            self::CANCELLED->value => 'Annulé',
            self::BLOCKED->value => 'Bloqué',
        ];
    }
}
