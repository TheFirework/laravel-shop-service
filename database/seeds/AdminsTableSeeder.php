<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = factory(Admin::class)->times(50)->create();
        

        // 单独处理第一个用户的数据
        $user = Admin::find(1);
        $user->name = 'Admin';
        $user->username = 'admin';
        $user->nickname = '系统管理员';
        $user->email = '1104305558@qq.com';
        $user->phone = '15681227581';
        $user->remark = '最高权限的系统管理员';
        $user->password = '$2y$10$/2.rdm9d/EdTjOiUyXvX7OpQi2gNoq75g0FijCwmvsl0fSShSw26q';
        $user->dept_id = 1;
        $user->role_id = 1;
        $user->is_delete = 0;
        $user->avatar = 'http://thirdwx.qlogo.cn/mmopen/vi_32/WTocuibah8NhhOxV8AyHqIK9932Taz217biaHDuXb1NX4hX9HWh2LiaLxQgCu8dlT4oSicGB4V5wD4mqKACcrPib8qA/132';
        $user->save();
    }
}
