<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\ServiceDeliveryMethod;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        /**
        // Create permissions
        $permissions = [
            'смотреть информацию о пользователях',
            'редактировать информацию о пользователях',
            'создавать пользователей',
            'смотреть информацию о ролях',
            'смотреть информацию о себе',
            'редактировать информацию о себе',
            'смотреть свои заказы',
            'оформлять заказ',
            'редактировать роль',
            'создавать роль',
            'иметь доступ к главной административной панели',
            'смотреть заказы через административную панель',
            'удалять заказы через административную панель',
            'обновлять заказы через административную панель',
            'смотреть детали своего заказа',
            'изменять статус заказа',
            'добавить позицию в заказ',
            'увеличить количество услуг в позиции заказа',
            'удалить позицию из заказа',
            'смотреть услуги через административную панель',
            'удалять услуги через административную панель',
            'обновлять услуги через административную панель',
            'создавать услуги через административную панель',
            'редактировать услуги через административную панель',
            'смотреть категории через административную панель',
            'удалять категории через административную панель',
            'обновлять категории через административную панель',
            'создавать категории через административную панель',
            'редактировать категории через административную панель',
            'смотреть услуги в категории через административную панель',
            'удалять услуги в категории через административную панель',
            'обновлять услуги в категории через административную панель',
            'создавать услуги в категории через административную панель',
            'редактировать услуги в категории через административную панель',
            'экспортировать категории',
            'экспортировать услуги',
            'импортировать категории',
            'импортировать услуги',
            'добавлять услугу в корзину',
            'редактировать корзину',
            'смотреть содержимое корзины',
            'удалять услугу из корзины'
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        // Create roles and assign permissions
        $rolesPermissions = [
            'user' => $permissions,
            'moderator' => $permissions,
            'admin' => $permissions,
        ];

        foreach ($rolesPermissions as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        }

        // Assign admin role to user with login 'admin'
        $user = User::where('login', 'admin')->first();

        if ($user) {
            $user->assignRole('admin');
        }
        
        // Заполняем service_delivery_methods
         $serviceDeliveryMethods = [
             ['id_sdm' => 1, 'name_sdm' => 'В сервисном центре'],
             ['id_sdm' => 2, 'name_sdm' => 'Выезд по адресу'],
             // Добавьте другие способы доставки здесь при необходимости
         ];

          \Illuminate\Support\Facades\DB::table('service_delivery_methods')->insert($serviceDeliveryMethods);
                  */
          
          
        // Массив с данными для статусов заказа
        $statuses = [
            ['name_status' => 'Оформлен', 'previous_id' => null],
            ['name_status' => 'В обработке', 'previous_id' => 1],
            ['name_status' => 'Принят', 'previous_id' => 2],
            ['name_status' => 'Отклонён', 'previous_id' => 2],
            ['name_status' => 'В работе', 'previous_id' => 3],
            ['name_status' => 'Выполнен', 'previous_id' => 4],
            ['name_status' => 'Завершён', 'previous_id' => 5],
        ];

        \Illuminate\Support\Facades\DB::table('statuses')->insert($statuses);
    }
}
