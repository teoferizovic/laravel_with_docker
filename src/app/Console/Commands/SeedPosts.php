<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;

class SeedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        $post = new Post();
        $post->first_name = substr(md5(microtime()),rand(0,26),5);
        $post->last_name = substr(md5(microtime()),rand(0,26),5);
        $post->active = 1;
        $post->save();
    }
}
