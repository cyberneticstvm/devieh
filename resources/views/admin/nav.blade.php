<div class="sidebar shadow-sm sticky-xl-top">
    <div class="container">
        <ul class="menu-list">
            <li><a class="m-link active" href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Pages" href="#"><i class="fa fa-file"></i> <span>Home</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Pages">
                    <li><a class="ms-link" href="#">Appointments</a></li>
                    <li><a class="ms-link" href="#">New Registration</a></li>
                    <li><a class="ms-link" href="#">Advertisements</a></li>
                </ul>
            </li>
            <li><a class="m-link" href="#"><i class="fa fa-comments"></i> <span>Search</span></a></li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Operations</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                <!--<ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="{{ route('branch') }}">Branch Management</a></li>
                    <li><a class="ms-link" href="{{ route('doctor') }}">Doctor Management</a></li>
                    <li><a class="ms-link" href="{{ route('user') }}">User Management</a></li>
                    <li><a class="ms-link" href="{{ route('role') }}">Roles & Permissions</a></li>
                    <li><a class="ms-link" href="#">Category Management</a></li>
                    <li><a class="ms-link" href="#">Subcategory Management</a></li>
                    <li><a class="ms-link" href="#">Product Management</a></li>
                    <li><a class="ms-link" href="#">Event Status</a></li>
                    <li><a class="ms-link" href="#">Lab Status</a></li>
                </ul>-->
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('branch-list', route('branch'), 'Branch Management')
                    ->linkIfCan('doctor-list', route('doctor'), 'Doctor Management')
                    ->linkIfCan('user-list', route('user'), 'User Management')
                    ->linkIfCan('role-list', route('role'), 'Roles & Permissions')
                    ->linkIfCan('category-list', route('category'), 'Category Management')
                    ->linkIfCan('subcategory-list', route('subcategory'), 'Subcategory Management')
                    ->linkIfCan('product-list', route('product'), 'Product Management')
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Stock</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="#">Branch Management</a></li>
                </ul>
            </li>
            <li>
                <a class="m-link" href="#"><i class="fa fa-comments"></i> <span>Camp</span></a>
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('branch-list', route('branch'), 'Branch Management')
                    ->linkIfCan('doctor-list', route('doctor'), 'Doctor Management')
                    ->linkIfCan('user-list', route('user'), 'User Management')
                    ->linkIfCan('role-list', route('role'), 'Roles & Permissions')
                    ->linkIfCan('category-list', route('category'), 'Category Management')
                    ->linkIfCan('subcategory-list', route('subcategory'), 'Subcategory Management')
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Reports</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="#">Sign in</a></li>
                    <li><a class="ms-link" href="#">Sign up</a></li>
                    <li><a class="ms-link" href="#">Password reset</a></li>
                    <li><a class="ms-link" href="#">2-Step Authentication</a></li>
                    <li><a class="ms-link" href="#">404</a></li>
                </ul>
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Extras</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="#">Sign in</a></li>
                    <li><a class="ms-link" href="#">Sign up</a></li>
                    <li><a class="ms-link" href="#">Password reset</a></li>
                    <li><a class="ms-link" href="#">2-Step Authentication</a></li>
                    <li><a class="ms-link" href="#">404</a></li>
                </ul>
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Settings</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="#">Sign in</a></li>
                    <li><a class="ms-link" href="#">Sign up</a></li>
                    <li><a class="ms-link" href="#">Password reset</a></li>
                    <li><a class="ms-link" href="#">2-Step Authentication</a></li>
                    <li><a class="ms-link" href="#">404</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>