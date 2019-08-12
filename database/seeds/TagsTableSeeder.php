<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert(
            [
                [
                    'title' => 'VueJs',
                ],
                [
                    'title' => 'HTML',
                ],
                [
                    'title' => 'CSS',
                ],
                [
                    'title' => 'React',
                ],
                [
                    'title' => 'Angular',
                ],
                [
                    'title' => 'JavaScrpt',
                ],
                [
                    'title' => 'Pyton',
                ],
                [
                    'title' => 'Ruby',
                ],
                [
                    'title' => 'PHP',
                ],
                [
                    'title' => 'NodeJs',
                ],
                [
                    'title' => 'Laravel',
                ],
                [
                    'title' => 'Rail',
                ],
                [
                    'title' => 'PHP',
                ],
                [
                    'title' => 'Django',
                ],
                [
                    'title' => 'AdonisJs',
                ],
                [
                    'title' => 'MySql',
                ],
                [
                    'title' => 'Postgres',
                ],
                [
                    'title' => 'MongoDb',
                ],
                [
                    'title' => 'Webpack',
                ],
                [
                    'title' => 'Gulp',
                ],
                [
                    'title' => 'Socket IO',
                ]
            ]
        );
    }
}
