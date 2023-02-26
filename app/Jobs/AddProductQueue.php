<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendingMail;
use Illuminate\Support\Facades\Mail;
use Storage;
use File;
use Illuminate\Support\Facades\DB;
use App\Model\Product;

class AddProductQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row)
    {
        $this->row = $row;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public $tries = 5;

    public function handle()
    {
        Product::create([
            'Meta_Keywords_Product' => json_decode($this->row[0]),
            'Product_Name' => json_decode($this->row[1]),
            'Product_Slug' => json_decode($this->row[2]),
            'Category_ID' => json_decode($this->row[2]),
            'Brand_ID' => json_decode($this->row[4]),
            'Product_Desc' => json_decode($this->row[5]),
            'Product_Content' => json_decode($this->row[6]),
            'Product_Price' =>  filter_var(json_decode($this->row[7]), FILTER_SANITIZE_NUMBER_INT),
            'Product_Cost' =>  filter_var(json_decode($this->row[8]), FILTER_SANITIZE_NUMBER_INT),
            'Product_Quantity' => filter_var(json_decode($this->row[9]), FILTER_SANITIZE_NUMBER_INT),
            'Product_Image' => json_decode($this->row[10]),
            'Product_Status' => json_decode($this->row[11]),
            'Product_Document' => json_decode($this->row[12]),
            'Product_Path' => json_decode($this->row[13]),
            'Product_Tag' => json_decode($this->row[14]),
            'Product_View' => json_decode($this->row[15]),
        ]);
    }
}