<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert some app_function
        DB::table('app_function')->insert(
            array(
                'code' => 'D01.LANDING_PAGE',
                'description' => 'Landing Page',
                'name' => 'Landing Page',
                'path' => '/home'
            )
        );
        
        // Insert some menu_item
        DB::table('menu_item')->insert(
            array(
                'name' => 'Home',
                'description' => 'Home',
                'parent_flag' => true,
                'sort_order' => '1',
                'function_code' => 'D01.LANDING_PAGE'
            )
        );

        DB::table('role')->insert(
            array(
                'nama' => 'Landing Page Only',
                'sort_order' => '1',
                'description' => 'Landing Page Only'
            )
        );
        
        DB::table('role')->insert(
            array(
                'nama' => 'Pentadbir Sistem',
                'sort_order' => '2',
                'description' => 'Pentadbir Sistem'
            )
        );
        
        DB::table('role_function')->insert(
            array(
                'function_code' => 'D01.LANDING_PAGE',
                'role_id' => DB::raw('(select id from role where nama = \'Landing Page Only\' )'),
                'createable' => true,
                'deleteable' => true,
                'readable' => true,
                'updateable' => true
            )
        );
        
        // Insert some app_function
        DB::table('app_function')->insert(
            array(
                'code' => 'U01.ROLE',
                'description' => 'Role Page',
                'name' => 'Role Page',
                'path' => '/role'
            )
        );
        
        // Insert some menu_item
        DB::table('menu_item')->insert(
            array(
                'name' => 'Role',
                'description' => 'Role',
                'parent_flag' => true,
                'sort_order' => '1',
                'function_code' => 'U01.ROLE'
            )
        );
        
        DB::table('role_function')->insert(
            array(
                'function_code' => 'U01.ROLE',
                'role_id' => DB::raw('(select id from role where nama = \'Pentadbir Sistem\' )'),
                'createable' => true,
                'deleteable' => true,
                'readable' => true,
                'updateable' => true
            )
        );
        
        // Insert some app_function
        DB::table('app_function')->insert(
            array(
                'code' => 'M01.MENU',
                'description' => 'Menu Menagment',
                'name' => 'Menu Menagment',
                'path' => '/menuMgmt'
            )
            );
        
        // Insert some menu_item
        DB::table('menu_item')->insert(
            array(
                'name' => 'Menu',
                'description' => 'Menu',
                'parent_flag' => true,
                'sort_order' => '1',
                'function_code' => 'M01.MENU'
            )
            );
        
        // Insert some app_function
        DB::table('app_function')->insert(
            array(
                'code' => 'U02.USER',
                'description' => 'User Page',
                'name' => 'User Page',
                'path' => '/userInfo'
            )
            );
        
        // Insert some menu_item
        DB::table('menu_item')->insert(
            array(
                'name' => 'User',
                'description' => 'User',
                'parent_flag' => true,
                'sort_order' => '2',
                'function_code' => 'U02.USER'
            )
            );
    }
}
