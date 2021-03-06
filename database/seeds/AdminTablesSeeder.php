<?php

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        Encore\Admin\Auth\Database\Menu::truncate();
        Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    "id" => 2,
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "后台管理",
                    "icon" => "fa-tasks",
                    "uri" => NULL,
                    "permission" => NULL,
                    "created_at" => NULL,
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 3,
                    "parent_id" => 2,
                    "order" => 2,
                    "title" => "后台用户",
                    "icon" => "fa-users",
                    "uri" => "auth/users",
                    "permission" => NULL,
                    "created_at" => NULL,
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 4,
                    "parent_id" => 2,
                    "order" => 3,
                    "title" => "角色管理",
                    "icon" => "fa-user",
                    "uri" => "auth/roles",
                    "permission" => NULL,
                    "created_at" => NULL,
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 5,
                    "parent_id" => 2,
                    "order" => 4,
                    "title" => "权限管理",
                    "icon" => "fa-ban",
                    "uri" => "auth/permissions",
                    "permission" => NULL,
                    "created_at" => NULL,
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 6,
                    "parent_id" => 2,
                    "order" => 5,
                    "title" => "菜单管理",
                    "icon" => "fa-bars",
                    "uri" => "auth/menu",
                    "permission" => NULL,
                    "created_at" => NULL,
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 7,
                    "parent_id" => 2,
                    "order" => 6,
                    "title" => "日志管理",
                    "icon" => "fa-history",
                    "uri" => "auth/logs",
                    "permission" => NULL,
                    "created_at" => NULL,
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 8,
                    "parent_id" => 0,
                    "order" => 7,
                    "title" => "用户管理",
                    "icon" => "fa-bars",
                    "uri" => "/users",
                    "permission" => NULL,
                    "created_at" => "2019-07-30 14:30:05",
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 9,
                    "parent_id" => 0,
                    "order" => 8,
                    "title" => "商品管理",
                    "icon" => "fa-bars",
                    "uri" => NULL,
                    "permission" => NULL,
                    "created_at" => "2019-07-30 14:30:17",
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 10,
                    "parent_id" => 9,
                    "order" => 9,
                    "title" => "分类管理",
                    "icon" => "fa-bars",
                    "uri" => "/category",
                    "permission" => NULL,
                    "created_at" => "2019-07-30 15:32:12",
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 11,
                    "parent_id" => 0,
                    "order" => 10,
                    "title" => "商品添加",
                    "icon" => "fa-bars",
                    "uri" => "/product",
                    "permission" => NULL,
                    "created_at" => "2019-08-02 14:19:55",
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 12,
                    "parent_id" => 0,
                    "order" => 11,
                    "title" => "订单管理",
                    "icon" => "fa-bars",
                    "uri" => "/orders",
                    "permission" => NULL,
                    "created_at" => "2019-08-05 09:49:14",
                    "updated_at" => "2019-08-07 15:34:29"
                ],
                [
                    "id" => 13,
                    "parent_id" => 0,
                    "order" => 0,
                    "title" => "轮播图管理",
                    "icon" => "fa-bars",
                    "uri" => "/banners",
                    "permission" => NULL,
                    "created_at" => "2019-08-16 23:17:20",
                    "updated_at" => "2019-08-16 23:17:20"
                ]
            ]
        );

        Encore\Admin\Auth\Database\Permission::truncate();
        Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    "id" => 1,
                    "name" => "All permission",
                    "slug" => "*",
                    "http_method" => "",
                    "http_path" => "*",
                    "created_at" => NULL,
                    "updated_at" => NULL
                ],
                [
                    "id" => 2,
                    "name" => "Dashboard",
                    "slug" => "dashboard",
                    "http_method" => "GET",
                    "http_path" => "/",
                    "created_at" => NULL,
                    "updated_at" => NULL
                ],
                [
                    "id" => 3,
                    "name" => "Login",
                    "slug" => "auth.login",
                    "http_method" => "",
                    "http_path" => "/auth/login\r\n/auth/logout",
                    "created_at" => NULL,
                    "updated_at" => NULL
                ],
                [
                    "id" => 4,
                    "name" => "User setting",
                    "slug" => "auth.setting",
                    "http_method" => "GET,PUT",
                    "http_path" => "/auth/setting",
                    "created_at" => NULL,
                    "updated_at" => NULL
                ],
                [
                    "id" => 5,
                    "name" => "Auth management",
                    "slug" => "auth.management",
                    "http_method" => "",
                    "http_path" => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
                    "created_at" => NULL,
                    "updated_at" => NULL
                ]
            ]
        );

        Encore\Admin\Auth\Database\Role::truncate();
        Encore\Admin\Auth\Database\Role::insert(
            [
                [
                    "id" => 1,
                    "name" => "Administrator",
                    "slug" => "administrator",
                    "created_at" => "2019-07-30 14:11:06",
                    "updated_at" => "2019-07-30 14:11:06"
                ]
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2,
                    "created_at" => NULL,
                    "updated_at" => NULL
                ]
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 1,
                    "created_at" => NULL,
                    "updated_at" => NULL
                ]
            ]
        );

        // finish
    }
}
