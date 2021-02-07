<?php

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;

class MyTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:test{id=默认值}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '我的测试命令';

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
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');
        $name = $this->ask('What is your name?');
        $password = $this->secret('What is the password?');
        $this->info('输入的ID：'.$id);
        $this->info('姓名：'.$name);
        $this->info('密码：'.$password);
        $this->error('Something went wrong!');
        $this->line('Display this on the screen');
        $headers = ['名称', '描述'];
        $users = Activity::all(['name', 'description'])->toArray();
        $this->table($headers, $users);

        return '';
    }
}
