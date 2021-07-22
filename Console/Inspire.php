<?php

namespace Modules\MyBlog\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my-blog:inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $quote = Inspiring::quote();

        $this->info($quote);
    }
}
