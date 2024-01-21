<ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
    <li class="nav-item {{ preg_match('/account\/dashboard/', Request::path()) ? 'active' : null }}"><a class=" nav-link" href="{{ route('dashboard') }}">
        <i class="feather icon-home"></i><span data-i18n="Dashboard">Dashboard</span></a>
    </li>
    <li class="nav-item {{ preg_match('/account\/budgets/', Request::path()) ? 'active' : null }}"><a class=" nav-link" href="{{ route('budgets.index') }}">
        <i class="feather icon-folder"></i><span data-i18n="Budgets">Budgets</span></a>
    </li>
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="index.html" data-toggle="dropdown">
        <i class="feather icon-box"></i><span data-i18n="Categories">Categories</span></a>
        <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="#" data-i18n="Income Categories" data-toggle="dropdown">Income Categories</a>
            </li>
            <li data-menu=""><a class="dropdown-item" href="#" data-i18n="Expense Categories" data-toggle="dropdown">Expense Categories</a>
            </li>
        </ul>
    </li>
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="index.html" data-toggle="dropdown">
        <i class="fa fa-money"></i><span data-i18n="Transactions">Transactions</span></a>
        <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="#" data-i18n="Incomes" data-toggle="dropdown">Incomes</a>
            </li>
            <li data-menu=""><a class="dropdown-item" href="#" data-i18n="Expenses" data-toggle="dropdown">Expenses</a>
            </li>
        </ul>
    </li>
</ul>