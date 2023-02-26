<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

use App\Notifications\ImportReady;
use App\Model\CategoryModel;
use App\Model\AdminModel;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $admin;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdminModel $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->admin->notify(new ImportReady('Xuất dữ liệu thành công'));
    }
}