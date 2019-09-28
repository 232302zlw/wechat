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
            \Log::Info('执行了任务调度-推送签到模板');
            $info = DB::table('wechat_openid')->get()->toArray();
//            dd($info[0]->sign_day);
            $today = date('Y-m-d',time());
            foreach ($info as $k => $v){
                if($today !== $info[$k]->sign_day){
                    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
                    $data = [
                        'touser' => $info[$k]->openid,
                        'template_id' => 'vB4YtNG4q1G51UfI4nobWBzdfhuXu4-qYEVXTFkVUNQ',
                        'data' => [
                            'keyword1' => [
                                'value' => $info[$k]->nickname,
                                'color' => '#3300ff'
                            ],
                            'keyword2' => [
                                'value' => ' 未签到',
                                'color' => '#ff0066'
                            ],
                            'keyword3' => [
                                'value' => '总积分'.$info[$k]->score,
                                'color' => '#ff0000'
                            ],
                            'keyword4' => [
                                'value' => $info[$k]->sign_day,
                                'color' => '#ff33ff'
                            ]
                        ]
                    ];
                    $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
                }elseif($today == $info[$k]->sign_day){
                    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
                    $data = [
                        'touser' => $info[$k]->openid,
                        'template_id' => 'vB4YtNG4q1G51UfI4nobWBzdfhuXu4-qYEVXTFkVUNQ',
                        'data' => [
                            'keyword1' => [
                                'value' => $info[$k]->nickname,
                                'color' => '#3300ff'
                            ],
                            'keyword2' => [
                                'value' => ' 已签到',
                                'color' => '#ff0066'
                            ],
                            'keyword3' => [
                                'value' => '总积分'.$info[$k]->score,
                                'color' => '#ff0000'
                            ],
                            'keyword4' => [
                                'value' => $today,
                                'color' => '#ff33ff'
                            ]
                        ]
                    ];
                    $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
                }
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
