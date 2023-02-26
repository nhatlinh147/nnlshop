<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Product;
use Illuminate\Session\Store;

class ViewProductHandler
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    private $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function handle(Product $product)
    {
        if (!$this->isPostViewed($product)) {
            $product->increment('Product_View');
            $this->storePost($product);
        }
    }

    private function isPostViewed($product)
    {
        $viewed = $this->session->get('viewed_products', []);

        return array_key_exists($product->Product_ID, $viewed);
    }

    private function storePost($post)
    {
        $key = 'viewed_products.' . $post->Product_ID;
        $this->session->put($key, time());
    }
}