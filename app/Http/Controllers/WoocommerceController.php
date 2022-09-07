<?php

namespace App\Http\Controllers;

use App\Jobs\MakeApiRequest;
use Illuminate\Http\Request;
use Codexshaper\WooCommerce\Facades\Product; 

class WoocommerceController extends Controller
{
   


public function products(){



        $products = Product::all();


         dispatch(new MakeApiRequest($products))->delay(now()->addMinute(1));

        return response()->json(['message' => 'post has been sent']);
  



}




}
