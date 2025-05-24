<?php

namespace App\Notifications;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationNotification extends Notification
{
    use Queueable;
    protected Donation $donation;
    protected User $resto;

    /**
     * Create a new notification instance.
     */
    public function __construct(Donation $donation, User $resto)
    {
        //
        $this->donation = $donation;
        $this->resto = $resto;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable) {
        return [
            "title" => "Donasi baru!",
            "message" => "restoran " . $this->resto->name . " baru saja mendonasikan makanan",
            "url" => config('app_url') . "receiver/request/" . $this->donation->id
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
