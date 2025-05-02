<?php
namespace App\Enums;

enum Status: int
{
    case PENDING = 0;
    case IN_PROGRESS = 1;
    case DONE = 2;

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Ожидает',
            self::IN_PROGRESS => 'В процессе',
            self::DONE => 'Готово',
        };
    }
    public function colorClass(): string
    {
        return match($this) {
            self::PENDING => 'text-gray-500',
            self::IN_PROGRESS => 'text-blue-500',
            self::DONE => 'text-green-500',
        };
    }
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
    }

}

