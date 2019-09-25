<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Tools\Tools;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

//        $schedule->call(function(){
//            DB::table('user_info')->insert(['user_name'=>'琉璃仙','user_pwd'=>md5('liulixian'),'headimg'=>'z1EaUeLedVB77Wy0hyK0j1kNqUdBdwhKWYY6FyBB.png','create_time'=>time()]);
//        })->cron('* * * * *');

        $schedule->call(function () {
            $tools = new Tools;
            $user_url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$tools->get_wechat_access_token().'&next_openid=';
            $openid_info = file_get_contents($user_url);
            $user_result = json_decode($openid_info,1);
            foreach($user_result['data']['openid'] as $v){
                $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tools->get_wechat_access_token();
                $data = [
                    'touser'=>$v,
                    'template_id'=>'vB4YtNG4q1G51UfI4nobWBzdfhuXu4-qYEVXTFkVUNQ',
                    'data'=>[
                    ]
                ];
                $tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
            }
        })->dailyAt('20:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
