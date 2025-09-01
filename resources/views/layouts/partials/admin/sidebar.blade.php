@php
    $links = [
        [
            'icon'=>'fa-solid fa-gauge',
            'name'=>'Dashboard',
            'route'=>route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard')

        ],
        [
            'header' => 'Administrar página'
        ],
        [
            'icon'=>'fa-solid fa-clipboard-check',
            'name'=>'Familias',
            'route'=>route('admin.families.index'),
            'active' => request()->routeIs('admin.families.*')

        ],
        [
            'icon'=>'fa-solid fa-list',
            'name'=>'Categories',
            'route'=>route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*')

        ],
        [
            'icon'=>'fa-solid fa-layer-group',
            'name'=>'SubCategories',
            'route'=>route('admin.subcategories.index'),
            'active' => request()->routeIs('admin.subcategories.*')

        ],
        [
            'icon'=>'fa-brands fa-product-hunt',
            'name'=>'Productos',
            'route'=>route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*')

        ],
        [
            'icon'=>'fa-solid fa-cog',
            'name'=>'Opciones',
            'route'=>route('admin.options.index'),
            'active' => request()->routeIs('admin.options.*')

        ],
        [
            'icon'=>'fa-solid fa-images',
            'name'=>'Portadas',
            'route'=>route('admin.covers.index'),
            'active' => request()->routeIs('admin.covers.*')

        ],
        [
            'header' => 'Ordenes y envios'
        ],
        [
            'name' => 'Conductores',
            'icon' => 'fa-solid fa-truck',
            'route' => route('admin.drivers.index'),
            'active' => request()->routeIs('admin.drivers.*')
        ],
        [
            'name' => 'Ordenes',
            'icon' => 'fa-solid fa-shopping-cart',
            'route' => route('admin.orders.index'),
            'active' => request()->routeIs('admin.orders.*')
        ],
        [
            'name' => 'Envios',
            'icon' => 'fa-solid fa-shipping-fast',
            'route' => route('admin.shipments.index'),
            'active' => request()->routeIs('admin.shipments.*')
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'fa-solid fa-shipping-fast',
            'route' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*')
        ]
    ];    
@endphp

<aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full bg-slate-600 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        :class="{
            'translate-x-0 ease-out': sidebarOpen,
            '-translate-x-full ease-in': !sidebarOpen
        }"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-slate-600 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                @foreach ($links as $link )
                    <li>
                        @isset($link['header'])

                            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">
                                {{$link['header']}}
                            </div>
                        
                        @else

                            <a href="{{$link['route']}}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 hover:text-black dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-blue-500' : '' }}">
                                <span class="inline-flex w-6 h-6 justify-center items-center">
                                    <i class="{{$link['icon']}} text-gray-500"></i>
                                </span>
                                <span class="ml-2">
                                    {{$link['name']}}
                                </span>
                            </a>

                        @endisset
                    </li>
                @endforeach
            </ul>
        </div>
</aside>