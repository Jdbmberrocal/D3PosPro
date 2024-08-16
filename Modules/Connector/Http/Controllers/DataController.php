<?php

namespace Modules\Connector\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Routing\Controller;
use Menu;

class DataController extends Controller
{
    public function superadmin_package()
    {
        return [
            [
                'name' => 'connector_module',
                'label' => __('connector::lang.connector_module'),
                'default' => false,
            ],
        ];
    }

    /**
     * Adds Connectoe menus
     *
     * @return null
     */
    public function modifyAdminMenu()
    {
        $module_util = new ModuleUtil();

        if (auth()->user()->can('superadmin')) {
            $is_connector_enabled = $module_util->isModuleInstalled('Connector');
        } else {
            $business_id = session()->get('user.business_id');
            $is_connector_enabled = (bool) $module_util->hasThePermissionInSubscription($business_id, 'connector_module', 'superadmin_package');
        }
        if ($is_connector_enabled) {
            Menu::modify('admin-sidebar-menu', function ($menu) {
                $menu->dropdown(
                    __('connector::lang.connector'),
                    function ($sub) {
                        if (auth()->user()->can('superadmin')) {
                            $sub->url(
                                action([\Modules\Connector\Http\Controllers\ClientController::class, 'index']),
                               __('connector::lang.clients'),
                                ['icon' => '', 'active' => request()->segment(1) == 'connector' && request()->segment(2) == 'api']
                            );
                        }
                        $sub->url(
                            url('\docs'),
                           __('connector::lang.documentation'),
                            ['icon' => '', 'active' => request()->segment(1) == 'docs']
                        );
                    },
                    ['icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054z" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg>', 'style' => 'background-color: #2dce89 !important;color:white']
                )->order(89);
            });
        }
    }
}
