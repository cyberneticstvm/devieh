<div class="sidebar shadow-sm sticky-xl-top">
    <div class="container">
        <ul class="menu-list">
            <li><a class="m-link active" href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Pages" href="#"><i class="fa fa-file"></i> <span>Home</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('appointment-list', route('appointment'), 'Appointments')
                    ->linkIfCan('consultation-list', route('consultation'), 'New Registration')
                    ->linkIfCan('ad-list', route('ads'), 'Advertisement')
                    ->linkIfCan('search', route('search'), 'Search')
                }}
            </li>
            <!--<li><a class="m-link" href="#"><i class="fa fa-comments"></i> <span>Search</span></a></li>-->
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Operations</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('branch-list', route('branch'), 'Branch Management')
                    ->linkIfCan('doctor-list', route('doctor'), 'Doctor Management')
                    ->linkIfCan('user-list', route('user'), 'User Management')
                    ->linkIfCan('role-list', route('role'), 'Roles & Permissions')
                    ->linkIfCan('category-list', route('category'), 'Category Management')
                    ->linkIfCan('subcategory-list', route('subcategory'), 'Subcategory Management')
                    ->linkIfCan('product-list', route('product'), 'Product Management')
                    ->linkIfCan('product-unique-list', route('product.unique.list'), 'Product Unique List')
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Order</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('store-order-list', route('store.order'), 'Store Orders')
                    ->linkIfCan('pharmacy-order-list', route('pharmacy.order'), 'Pharmacy Orders')
                    ->linkIfCan('payment-list', route('payments'), 'Payments')
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Stock</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('store-purchase-list', route('store.purchase'), 'Purchase - Store')
                    ->linkIfCan('pharmacy-purchase-list', route('pharmacy.purchase'), 'Purchase - Pharmacy')
                    ->linkIfCan('store-transfer-list', route('store.transfer'), 'Transfer - Store')
                    ->linkIfCan('pharmacy-transfer-list', route('pharmacy.transfer'), 'Transfer - Pharmacy')
                }}
            </li>
            <li>
                <a class="m-link" href="#"><i class="fa fa-comments"></i> <span>Camp</span></a>
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('camp-list', route('camp'), 'Camp Register')
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Reports</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('report-daybook', route('report.daybook'), 'Daybook')
                    ->linkIfCan('report-daybook', route('report.daybook'), 'Lab')
                    ->linkIfCan('report-daybook', route('report.daybook'), 'Sales (Store)')
                    ->linkIfCan('report-daybook', route('report.daybook'), 'Sales (Pharmacy)')
                    ->linkIfCan('report-daybook', route('report.daybook'), 'Income & Expense')
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Extras</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('head-list', route('heads'), 'Head')
                    ->linkIfCan('income-expense-list', route('iande'), 'Income & Expense')
                    ->linkIfCan('supplier-list', route('supplier'), 'Supplier')
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-eye"></i> <span>Drishti</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('customer-list', route('drishti.customer'), 'Customer Register')
                    ->linkIfCan('drishti-product-list', route('drishti.item'), 'Product Register')
                    ->linkIfCan('drishti-order-list', route('drishti.order'), 'Order Register')                    
                    ->linkIfCan('drishti-purchase-list', route('drishti.purchase'), 'Purchase')                    
                }}
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-lock"></i> <span>Settings</span> <span class="arrow fa fa-dot-circle-o ms-auto text-end"></span></a>
                <!-- Menu: Sub menu ul -->
                {{
                    Menu::new()->setAttribute('id', 'menu-Authentication')->addClass('sub-menu collapse')->addItemClass('ms-link')
                    ->linkIfCan('settings-extras', route('settings.extras'), 'Extras')                 
                    ->linkIfCan('settings-editor', route('settings.editor'), 'Editor')                 
                }}
            </li>
        </ul>
    </div>
</div>