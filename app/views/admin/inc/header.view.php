<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <title>WoodCraft Furniture - Admin</title>
    <link rel="shortcut icon" href="<?php echo ROOT ?>/assets/logo/favicon.ico" type="image/x-icon">
</head>

<body>

    <div class="grid-container">

        <!-- Header -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
            <div class="header-left">
                <!-- <span class="material-icons-outlined">search</span> -->
            </div>
            <div class="header-right" style="display: flex; align-items: center; justify-content: center;">
                <!-- <span class="material-icons-outlined">notifications</span>
          <span class="material-icons-outlined">email</span> -->
                <span style="padding-right:5px">Admin </span>
                <span class="material-icons-outlined">manage_accounts</span>
            </div>
        </header>

        <!-- End Header -->

        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined" style="font-size: 36px; padding-right:5px"> living </span> WoodCraft
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>


            <ul class="sidebar-list">
                <li class="sidebar-list-item nav-btn selected def-selected" id="dash-nav">
                    <a>
                        <span class="material-icons-outlined">dashboard</span><span style="margin-left: 5px;">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-list-item nav-btn" id="products-nav">
                    <a>
                        <span class="material-icons-outlined">chair</span>
                        <span style="margin-left: 5px;">Products</span>
                    </a>
                </li>
                <!-- product categories -->
                <li class="sidebar-list-item nav-btn" id="cat-nav">
                    <a>
                        <span class="material-symbols-outlined">
                            chair_alt
                        </span> <span style="margin-left: 5px;">Categories</span>
                    </a>
                </li>



                <li class="sidebar-list-item nav-btn" id="materials-nav">
                    <a>
                        <span class="material-icons-outlined">
                            handyman
                        </span> <span style="margin-left: 5px;">Materials</span>
                    </a>
                </li>
                <li class="sidebar-list-item nav-btn" id="customers-nav">
                    <a>
                        <span class="material-icons-outlined">people</span> <span style="margin-left: 5px;">Customers</span>
                    </a>
                </li>
                <li class="sidebar-list-item nav-btn" id="workers-nav">
                    <a>
                        <span class="material-icons-outlined">engineering</span> <span style="margin-left: 5px;">Workers</span>
                    </a>
                </li>
                <li class="sidebar-list-item nav-btn" id="staff-nav">
                    <a>
                        <span class="material-icons-outlined">supervised_user_circle</span> <span style="margin-left: 5px;">Staff Members</span>
                    </a>
                </li>
                <li class="sidebar-list-item nav-btn" id="delivery-nav">
                    <a>
                        <span class="material-icons-outlined">local_shipping</span><span style="margin-left: 5px;">Delivery</span>
                    </a>
                </li>
                <!-- <li class="sidebar-list-item">
                <a href="#" >
                    <span class="material-icons-outlined">poll</span> Reports
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" >
                    <span class="material-icons-outlined">settings</span> Settings
                </a>
            </li> -->
                <li class="sidebar-list-item sidebar-logout" id="logoutBtn">
                    <a>
                        <span class="material-icons-outlined">logout</span><span style="margin-left: 5px;">Logout</span>
                    </a>
                </li>

                <script>
                    const dashNav = document.getElementById('dash-nav');
                    const productsNav = document.getElementById('products-nav');
                    const customersNav = document.getElementById('customers-nav');
                    const catNav = document.getElementById('cat-nav');
                    const workersNav = document.getElementById('workers-nav');
                    const staffNav = document.getElementById('staff-nav');
                    const deliveryNav = document.getElementById('delivery-nav');
                    const materialsNav = document.getElementById('materials-nav');


                    // Add event listener to the parent element
                    document.querySelector('.sidebar-list').addEventListener('click', (event) => {
                        const target = event.target;
                        const id = target.closest('.sidebar-list-item').id;

                        // Handle different menu items based on their IDs
                        switch (id) {
                            case 'dash-nav':
                                window.location.href = '<?= ROOT ?>/admin/dashboard';
                                break;
                            case 'products-nav':
                                window.location.href = '<?= ROOT ?>/admin/products';
                                break;
                            case 'cat-nav':
                                window.location.href = '<?= ROOT ?>/admin/categories';
                                break;
                            case 'customers-nav':
                                window.location.href = '<?= ROOT ?>/admin/customers';
                                break;
                            case 'workers-nav':
                                window.location.href = '<?= ROOT ?>/admin/workers';
                                break;
                            case 'staff-nav':
                                window.location.href = '<?= ROOT ?>/admin/staff';
                                break;
                            case 'delivery-nav':
                                window.location.href = '<?= ROOT ?>/admin/delivery';
                                break;
                            case 'materials-nav':
                                window.location.href = '<?= ROOT ?>/admin/materials';
                                break;
                            default:
                                break;
                        }
                    });
                </script>
            </ul>




            <script>
                const listItems = document.querySelectorAll('.nav-btn');

                listItems.forEach(item => {
                    item.addEventListener('click', () => {
                        listItems.forEach(item => item.classList.remove('selected'));
                        item.classList.add('selected');
                        sessionStorage.setItem('selectedItem', item.id);
                    });
                });

                const selectedItem = sessionStorage.getItem('selectedItem');
                if (selectedItem) {
                    const selectedSidebarItem = document.getElementById(selectedItem);
                    if (selectedSidebarItem) {
                        selectedSidebarItem.classList.add('selected');
                        //remove selected from all other items
                        listItems.forEach(item => {
                            if (item.id !== selectedItem) {
                                item.classList.remove('selected');
                            }
                        });
                    }

                }


                const logoutBtn = document.getElementById('logoutBtn');
                logoutBtn.addEventListener('click', () => {
                    window.location.href = '<?= ROOT ?>/logout';
                    for (let i = 0; i < sessionStorage.length; i++) {
                        const key = sessionStorage.key(i);
                        sessionStorage.removeItem(key);
                    }

                    const defaultSelected = document.querySelector('.def-selected');
                    defaultSelected.classList.add('selected');

                });
            </script>
        </aside>
        <!-- End Sidebar -->

        <!-- Main -->
        <main class="main-container">