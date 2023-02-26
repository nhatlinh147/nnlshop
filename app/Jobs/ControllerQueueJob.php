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
use Excel;
use Illuminate\Support\Facades\DB;
use App\Model\Product;


class ControllerQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new SendingMail($this->details);
        // Mail::to($this->details['to_email'])->send($email);
        if ($this->details['controller'] == "sendmail") {
            $to_name = $this->details['to_name'];
            $to_email = $this->details['to_email'];
            // $from_email = $this->details['from_email'];
            // $from_name = $this->details['from_name'];

            $data = ["name" => $this->details['name'], "body" => $this->details['body']]; //body of mail.blade.php
            Mail::send('backend.mail.send-mail', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Test Sending Mail using Laravel Queue'); //send this mail with subject
            });
        } else if ($this->details['controller'] == "savedrive") {

            Storage::disk('google')->put($this->details['setNameDocument'], json_decode($this->details['fileData']));
        } else if ($this->details['controller'] == "doiPath") {

            $product = Product::find($this->details['product_id']);

            if ($product->Product_Path == "Path Drive") {
                $get_path = collect(Storage::cloud()->listContents('/', false))
                    ->where('type', '!=', 'dir')
                    ->where('filename', '=', pathinfo($product->Product_Document, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($product->Product_Document, PATHINFO_EXTENSION))
                    ->first();
                DB::table('tbl_product')->where("Product_ID", $product->Product_ID)->update(['Product_Path' => $get_path['path']]);
            }
        } else if ($this->details['controller'] == "deletedrive") {
            $fileinfo = collect(Storage::cloud()->listContents('/', false))
                ->where('type', 'file')
                ->where('path', $this->details['get_path'])
                ->first();
            Storage::disk('google')->delete($fileinfo['path']);
        } else if ($this->details['controller'] == "delete_product_document") {

            $fileinfo = collect(Storage::cloud()->listContents('/', false))
                ->where('type', '!=', 'dir')
                ->where('filename', '=', pathinfo($this->details['get_document'], PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($this->details['get_document'], PATHINFO_EXTENSION))
                ->first();
            Storage::disk('google')->delete($fileinfo['path']);
        }
    }
}