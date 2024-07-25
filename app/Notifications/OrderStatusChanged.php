<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    public $user;
    public $order;
    public $status;

    public function __construct($user, $order, $status)
    {
        $this->user = $user;
        $this->order = $order;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Изменение статуса заказа')
            ->greeting('Здравствуйте, ' . ($this->user->personal->name ?? $this->user->login) . '!')
            ->line('Статус вашего заказа №' . $this->order->code . ' был изменен на "' . $this->status->name_status . '".')
            ->action('Просмотреть заказ', route('myorderdetails',$this->order->code))
            ->line('Спасибо за использование нашего сервиса!');
    }
}