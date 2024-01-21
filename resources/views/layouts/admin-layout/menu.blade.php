<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
    <li class=" nav-item {{ preg_match('/account\/dashboard/', Request::path()) ? 'active' : null }}"><a
            href="{{ route('dashboard') }}"><i class="feather icon-home"></i><span class="menu-title"
                data-i18n="Dashboard">Dashboard</span></a></li>
        
    <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span class="menu-title"
                data-i18n="Users">Users</span></a>
        <ul class="menu-content">
            <li class="{{ preg_match('/account\/clients/', Request::path()) ? 'active' : null }}"><a class="menu-item"
                    href="{{ route('clients.index') }}" data-i18n="Clients">Clients</a>
            </li>
            <li class="{{ preg_match('/account\/admins/', Request::path()) ? 'active' : null }}"><a class="menu-item"
                    href="#" data-i18n="Admins">Admins</a>
            </li>
        </ul>
    </li>

    <li class=" nav-item"><a href="#"><i class="feather icon-box"></i><span class="menu-title"
                data-i18n="User Categories">User Categories</span></a>
        <ul class="menu-content">
            <li class="{{ preg_match('/account\/income-categories/', Request::path()) ? 'active' : null }}"><a
                    class="menu-item" href="{{ route('income-categories.index') }}" data-i18n="Income Categories">Income
                    Categories</a>
            </li>
            <li class="{{ preg_match('/account\/expense-categories/', Request::path()) ? 'active' : null }}"><a
                    class="menu-item" href="{{ route('expense-categories.index') }}"
                    data-i18n="Expense Categories">Expense Categories</a>
            </li>
        </ul>
    </li>
    <li class=" nav-item {{ preg_match('/account\/budgets/', Request::path()) ? 'active' : null }}"><a
            href="{{ route('budgets.index') }}"><i class="fa fa-money"></i><span class="menu-title"
                data-i18n="Budgets">Budgets</span></a>
    <li class=" nav-item {{ preg_match('/account\/expenses/', Request::path()) ? 'active' : null }}"><a
            href="{{ route('expenses.index') }}"><i class="fa fa-money"></i><span class="menu-title"
                data-i18n="Expenses">Expenses</span></a>
    <li class=" nav-item {{ preg_match('/account\/incomes/', Request::path()) ? 'active' : null }}"><a
            href="{{ route('incomes.index') }}"><i class="fa fa-money"></i><span class="menu-title"
                data-i18n="Incomes">Incomes</span></a>
</ul>
