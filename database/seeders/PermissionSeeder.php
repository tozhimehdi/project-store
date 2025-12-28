<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //add user sample
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'سوپر ادمین',
                'email' => 'admin@elicms.ir',
                'mobile' => '09210034734',
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        //Roles
        DB::table('roles')->insert([
            [
                'id' => 1,
                'title' => 'super-admin',
                'description' => 'سوپر ادمین',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        //Role User Admin
        DB::table('role_user')->insert([
            [
                'role_id' => 1,
                'user_id' => 1
            ]
        ]);

        //Permissions
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'title' => 'dashboard',
                'description' => 'دسترسی به داشبورد',
                'parent_id' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'title' => 'articles',
                'description' => 'مقالات',
                'parent_id' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'title' => 'create-articles',
                'description' => 'ایجاد مقاله',
                'parent_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'title' => 'edit-articles',
                'description' => 'ویرایش مقاله',
                'parent_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]

        ]);

        foreach(Permission::all() as $permission){
            DB::table('permission_role')->insert([
                [
                    'permission_id' => $permission->id,
                    'role_id' => 1
                ]
            ]);
        }
    }
}
