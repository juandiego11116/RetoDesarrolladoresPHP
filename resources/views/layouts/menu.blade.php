@role('admin')
    <li class="side-menus {{ Request::is('*') ? 'active' : '' }}" >
        <a class="nav-link" href="/home">
            <i class=" fas fa-building"></i><span>Dashboard</span>
        </a>
        <a class="nav-link" href="/users">
            <i class=" fas fa-users"></i><span>Users</span>
        </a>
        <a class="nav-link" href="/roles">
            <i class=" fas fa-user-lock"></i><span>Roles</span>
        </a>
        <a class="nav-link" href="/products">
            <i class=" fas fa-layer-group"></i><span>Products</span>
        </a>
        <a class="nav-link" href="/reports/index">
            <em class=" fas fa-file"></em><span>Reports</span>
        </a>
    </li>
@endrole

@role('customer')
<li class="side-menus {{ Request::is('*') ? 'active' : '' }}" >
    <a class="nav-link" href="/">
        <i class="fas fa-shopping-basket"></i><span>Shopping</span>
    </a>
    <a class="nav-link" href="history">
        <i class="fas fa-file"></i><span>Histoty</span>
    </a>
    <a class="nav-link" href="cart">
        <i class="fas fa-shopping-cart"></i><span>Cart</span>
    </a>

</li>
@endrole


