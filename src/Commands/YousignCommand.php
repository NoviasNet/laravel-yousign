<?php

namespace NoviasNet\Yousign\Commands;

use Illuminate\Console\Command;

class YousignCommand extends Command
{
    public $signature = 'laravel-yousign';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
