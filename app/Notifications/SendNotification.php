<?php

    namespace App\Notifications;

    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Notification;

    class SendNotification extends Notification
    {
        use Queueable;

        protected string $type;
        protected $data;

        public function __construct(string $type, $data)
        {
            $this->type = $type; // product | task
            $this->data = $data;
        }

        public function via(object $notifiable): array
        {
            return ['database']; // ممكن تزود mail/broadcast
        }

        public function toDatabase(object $notifiable): array
        {
            if ($this->type === 'task') {
                return [
                    'message' => "المهندس {$this->data->engineer->name} أنجز طلب الصيانة '{$this->data->device_type}'",
                    'task_id' => $this->data->id,
                    'url' => route('admin.task.show', $this->data->id),
                ];

            } else {
                return [
                    'message' => "⚠️ المنتج '{$this->data->name}' الكمية المتبقية: {$this->data->quantity}",
                    'url' => route('admin.products.lowStock'),
                ];
            }
        }



    }
