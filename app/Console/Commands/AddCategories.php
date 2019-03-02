<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\CouponRepository;

class AddCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupomated:add-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add categories from coupomated';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CouponRepository $coupon)
    {
        return $coupon->updateCategories();
    }
}
