<?php

namespace Boravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Boravel\Models\Order;
use Illuminate\Support\Facades\Log;

class NotifyOrderChangeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Service $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Captura Usuário Responsável
        $user = $this->order->user;

        // Avisa Servidor da alteração no status
        Organizer::getOrganizerServiceForUser(
                $this->order->user, $this->order->companyToken
            )->foundOrganizerDataByToken();
    }
}
