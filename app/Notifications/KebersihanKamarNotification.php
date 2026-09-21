<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KebersihanKamarNotification extends Notification
{
    use Queueable;

    public $kamar;

    public $status;

    public function __construct($kamar, $status)
    {
        $this->kamar = $kamar;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $title = $this->status == 'kotor' ? 'Kamar Perlu Dibersihkan' : ($this->status == 'kotor_sebagian' ? 'Pembersihan Parsial' : 'Kamar Sudah Bersih');
        
        $msg = '';
        if ($this->status == 'kotor') {
            $msg = 'Kamar '.$this->kamar->nomor_kamar.' perlu dibersihkan segera.';
        } elseif ($this->status == 'kotor_sebagian') {
            $msg = 'Tamu telah checkout dari Kamar '.$this->kamar->nomor_kamar.'. Harap bersihkan kasur yang kosong (tamu lain masih ada).';
        } else {
            $msg = 'Kamar '.$this->kamar->nomor_kamar.' telah dibersihkan.';
        }

        return ['type' => 'kebersihan', 'title' => $title, 'message' => $msg, 'url' => route('admin.kamar')];
    }
}
