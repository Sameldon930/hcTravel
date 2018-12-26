<?php

use Illuminate\Database\Seeder;

class ArticleGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ['status'=>1,'name'=>'黄厝资讯'],
            ['status'=>1,'name'=>'公告通知'],
            ['status'=>1,'name'=>'政府政策'],
        ];
        DB::table('article_groups')->insert($array);
    }
}
