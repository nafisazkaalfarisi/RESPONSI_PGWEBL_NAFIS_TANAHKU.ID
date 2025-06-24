<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PolygonAdded extends Notification
{
    use Queueable;

    public $polygon;

    public function __construct($polygon)
    {
        $this->polygon = $polygon;
    }

    public function via($notifiable)
    {
        return ['database']; // Disimpan ke tabel notifikasi
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Data Tanah Baru Ditambahkan',
            'message' => 'Tanah "' . $this->polygon->name . '" telah ditambahkan.',
            'polygon_id' => $this->polygon->id,
        ];
    }
}

