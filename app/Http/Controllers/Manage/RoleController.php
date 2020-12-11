<?php

namespace App\Http\Controllers\Manage;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function page(Request $request)
    {
        $roles = Role::paginate($request->input('pageSize',10));

        return $this->success_return($roles);
    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function batchDestroy()
    {

    }
}
