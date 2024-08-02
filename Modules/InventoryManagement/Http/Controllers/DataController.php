<?php

namespace Modules\InventoryManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Utils\ModuleUtil;
use Menu;

class DataController extends Controller
{    
    public function superadmin_package()
    {
        return [
            [
                'name' => 'inventorymanagement_module',
                'label' => __('inventorymanagement::inventory.stock_inventory'),
                'default' => false
            ]
        ];
    }

    /**
      * Defines user permissions for the module.
      * @return array
      */
    public function user_permissions()
    {
        return [
            [
                'value' => 'inventorymanagement.view',
                'label' => __('inventorymanagement::app.view'),
                'default' => false
            ],
            [
                'value' => 'inventorymanagement.empty',
                'label' => __('inventorymanagement::app.remove_inv'),
                'default' => false
            ],
      
        ];
    }

    /**
    * Function to add module taxonomies
    * @return array
    */
    public function addTaxonomies()
    {
        $business_id = request()->session()->get('user.business_id');

        $module_util = new ModuleUtil();
        if (!(auth()->user()->can('superadmin') || $module_util->hasThePermissionInSubscription($business_id, 'inventorymanagement_module'))) {
            return ['inventory' => []];
        }
        
        return [
            'inventory' => [
                'taxonomy_label' =>  __('inventorymanagement::inventory.stock_inventory'),
                'heading' => __('inventorymanagement::inventory.stock_inventory'),
                'sub_heading' => __('inventorymanagement::inventory.stock_inventory'),
                'enable_taxonomy_code' => false,
                'enable_sub_taxonomy' => false,
                'navbar' => 'inventorymanagement::layouts.nav'
            ]
        ];
    }

    /**
     * Adds Repair menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        $business_id = session()->get('user.business_id');
        $module_util = new ModuleUtil();
        $is_inventorymanagement_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'inventorymanagement_module');

        $background_color = '';
        if (config('app.env') == 'demo') {$background_color = '#C7E9C0  !important';}


        if ($is_inventorymanagement_enabled && (auth()->user()->can('superadmin') || auth()->user()->can('inventorymanagement.view'))) {
            $menuparent = Menu::instance('admin-sidebar-menu');
            $menuparent->dropdown (__('inventorymanagement::inventory.inventory' ), 

                            function ($sub) use ($background_color){
                                $sub->url(action('\Modules\InventoryManagement\Http\Controllers\InventoryManagementController@index'),
                                __('inventorymanagement::inventory.create_new_inventory'),
                                ['active' => request()->segment(2) == 'createNewInventory']);

                                $sub->url(action('\Modules\InventoryManagement\Http\Controllers\InventoryManagementController@showInventoryList'),
                                __('inventorymanagement::inventory.stock_inventory'),
                                [
                                'active' =>  request()->segment(2) == 'showInventoryList']);
                         
 
                                
                            },
            
            ['icon' => 'fas fa fa-boxes', 'style' => "background-color:$background_color"]
            )->order(89);


            // Menu::modify('admin-sidebar-menu', function ($menu) use ($background_color) {
            //     $menu->url(
            //                 action('\Modules\InventoryManagement\Http\Controllers\InventoryManagementController@index'),
            //                 __('inventorymanagement::inventory.stock_inventory'),
            //                 ['icon' => 'fas fa fa-boxes', 'active' => request()->segment(1) == 'inventorymanagement', 'style' => 'background-color:'.$background_color]
            //             )
            //     ->order(89);
            // });
        }
    }


}
