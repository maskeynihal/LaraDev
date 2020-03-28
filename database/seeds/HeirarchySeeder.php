<?php

use App\Heirarchy;
use App\HeirarchyDescription;
use Illuminate\Database\Seeder;

class HeirarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $heirarchies = [
            [
                [
                    'heirarchy_id' => 1,
                    'title' => 'HQ',
                    'slug' => 'hq'
                ],
                [
                    'heirarchy_id' => 1,
                    'is_root' => true,
                    'parent_id' => null
                ]
            ],
            [
                [
                    'heirarchy_id' => 2,
                    'title' => 'Province',
                    'slug' => 'province'
                ],
                [
                    'heirarchy_id' => 2,
                    'is_root' => false,
                    'parent_id' => 1
                ]
            ],
            [
                [
                    'heirarchy_id' => 3,
                    'title' => 'International',
                    'slug' => 'international'
                ],
                [
                    'heirarchy_id' => 3,
                    'is_root' => false,
                    'parent_id' => 1
                ]
            ],
            [
                [
                    'heirarchy_id' => 4,
                    'title' => 'District',
                    'slug' => 'district'
                ],
                [
                    'heirarchy_id' => 4,
                    'is_root' => false,
                    'parent_id' => 2
                ]
            ]
        ];

        foreach($heirarchies as $heirarchy)
        {
            Heirarchy::insert($heirarchy[0]);
            HeirarchyDescription::insert($heirarchy[1]);
        }
    }
}
