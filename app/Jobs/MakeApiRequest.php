<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class MakeApiRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($products)
    {
       
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($products)
    {
     
     foreach($products as $product){

           
      $data = new Product;
      $data->name = $product->name;
      $data->price = $product->price;
      $data->description = $product->description;
      $data -> save();
      
        }


    }
}
