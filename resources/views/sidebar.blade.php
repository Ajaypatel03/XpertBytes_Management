<aside class="left-sidebar sidebar-dark" id="left-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand text-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/images/xb2logo.png') }}" alt="XpertBytes"
                    style="display: block; margin: 0 auto; width:100%;height: 90%;margin-left:-10px;">
                {{-- Adjust the width value (300px) as needed --}}
                {{--  <h6 class="text-primary">Account Management ERP</h6>  --}}
            </a>
        </div>

        <!-- begin sidebar scrollbar -->
        <div class="sidebar-left" data-simplebar style="height: 100%;">
            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">

                <li class="active">
                    <a class="sidenav-item-link" href="{{ route('dashboard') }}">
                        <i class="mdi mdi-palette"></i>
                        <span class="nav-text"> Dashboard</span>
                    </a>
                </li>

                <li class="section-title">
                    Apps
                </li>


                <li
                    class="has-sub {{ request()->is('boardMembers*') || request()->is('clients*') || request()->is('employs*') ? 'active open' : '' }}">
                    <a class="sidenav-item-link collapsed" href="javascript:void(0)" data-toggle="collapse"
                        data-target="#member" aria-expanded="false" aria-controls="member">
                        <i class="mdi mdi-account-group"></i>
                        <span class="nav-text">Add</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="member" data-parent="#sidebar-menu"
                        style="{{ request()->is('boardMembers*') || request()->is('clients*') || request()->is('employs*') ? 'display: block;' : '' }}">
                        <div class="sub-menu">
                            <li class="{{ request()->is('boardMembers*') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('boardMembers.index') }}">
                                    <i class="mdi mdi-account-group"></i>
                                    <span class="nav-text">Board Members</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('clients*') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('clients.index') }}">
                                    <i class="mdi mdi-account-circle"></i>
                                    <span class="nav-text">Clients</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('employs*') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('employs.index') }}">
                                    <i class="mdi mdi-account-multiple-outline"></i>
                                    <span class="nav-text">Employees</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>




                <li
                    class="has-sub {{ request()->is('expenses*') || request()->is('salaries*') || request()->is('debit*') || request()->is('invest*') ? 'active open' : '' }}">
                    <a class="sidenav-item-link collapsed" href="javascript:void(0)" data-toggle="collapse"
                        data-target="#email" aria-expanded="false" aria-controls="email">
                        <i class="mdi mdi-currency-inr"></i>
                        <span class="nav-text">Management</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="email" data-parent="#sidebar-menu"
                        style="{{ request()->is('expenses*') || request()->is('salaries*') || request()->is('debit*') || request()->is('invest*') ? 'display: block;' : '' }}">
                        <div class="sub-menu">
                            <li class="{{ request()->is('expenses*') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('expenses.index') }}">
                                    <i class="mdi mdi-home-currency-usd"></i>
                                    <span class="nav-text">Expenses</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('salaries*') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('salaries.index') }}">
                                    <i class="mdi mdi-currency-inr"></i>
                                    <span class="nav-text">Salary</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('debit*') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('debit.index') }}">
                                    <i class="mdi mdi-credit-card"></i>
                                    <span class="nav-text">Debit</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('invest*') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('invest.index') }}">
                                    <i class="mdi mdi-bullseye-arrow"></i>
                                    <span class="nav-text">Investment</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>


                <li>
                    <a class="sidenav-item-link" href="{{ route('entries.index') }}">
                        <i class="mdi mdi-laptop-windows"></i>
                        <span class="nav-text">Entries</span>
                    </a>
                </li>

                <li>
                    <a class="sidenav-item-link" href="{{ route('report.index') }}">
                        <i class="mdi mdi-calculator-variant"></i>
                        <span class="nav-text">Report</span>
                    </a>
                </li>

            </ul>

        </div>

        <div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <ul class="d-flex">
                    {{--  <li>
                                <a href="#" data-toggle="tooltip" title="Profile settings"><i
                                        class="mdi mdi-settings"></i></a>
                            </li>
                            <li>
                                <a href="#" data-toggle="tooltip" title="No chat messages"><i
                                        class="mdi mdi-chat-processing"></i></a>
                            </li>  --}}
                </ul>
            </div>
        </div>
    </div>
</aside>
