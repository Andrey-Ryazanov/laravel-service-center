<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     function __construct()
     {
         $this->middleware('permission:смотреть информацию о ролях', ['only' => ['index']]);
         $this->middleware('permission:редактировать роль', ['only' => ['edit','update']]);
         $this->middleware('permission:создавать роль', ['only' => ['create','store']]);
     }

    public function index()
    {
        $roles = Role::orderBy('id','asc')->get();
        return view('admin.roles.index')->with([
            'roles'  => $roles
        ]);
    }

    public function create(){
        $permissions =  Permission::all();
        return view('admin.roles.create')->with([
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request){
        $role = Role::create(['name' => $request->name]);
        $array_permissions = $request->input('array_permissions');
        foreach ($array_permissions as $permission){
            $role->givePermissionTo($permission);
        }
        return redirect()->back()->with('status', 'Роль успешно создана');
    }

    public function edit(Role $role){
        $permissions =  Permission::all();
        return view('admin.roles.edit')->with([
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role){
        $role->update(['name'=>$request->name]);
        $array_permissions = $request->input('array_permissions');
        $role->syncPermissions([]);
        foreach ($array_permissions as $permission){
            $role->givePermissionTo($permission);
        }
        return redirect()->back()->with('status', 'Роль успешно обновлена');
    }

    public function destroy(Role $role){
        $users = User::all();
        $role->syncPermissions([]);
        foreach ($users as $user){
            $user->removeRole($role);
        }
        $role->delete();
        return redirect()->back()->with('status', 'Роль успешно удалена');
    }
}
