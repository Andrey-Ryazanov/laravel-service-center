<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\CategoryService;

class AddOrderItem extends Notification
{
    use Queueable;
    
    public $user;
    public $order;
    public $order_item;


    /**
     * Create a new notification instance.
     */
    public function __construct($user, $order, $order_item)
    {
        $this->user = $user;
        $this->order = $order;
        $this->order_item = CategoryService::join('services', 'services.id_service','service_id')
        ->join('categories','categories.id_category','category_id')
        ->where('id_category_service','=',$order_item->category_service_id)
        ->select('services.name_service','categories.title')->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->subject('Добавление позиции в заказ')
                ->greeting('Здравствуйте, ' . ($this->user->personal->name ?? $this->user->login) . '!')
                ->line('Была добавлена новая позиция в заказ №'. $this->order->code)
                ->line('- ' . $this->order_item->title)
                ->line('- ' . $this->order_item->name_service)
                ->action('Просмотреть заказ', route('myorderdetails',$this->order->code))
                ->line('Спасибо за использование нашего сервиса!');
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
