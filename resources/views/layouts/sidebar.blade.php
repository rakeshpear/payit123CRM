<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>

                @can('manage.dashboard')
                <li>
                    <a href="{{url('/index')}}" class="waves-effect">
                        <i class="bx bx-grid-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endcan


                @can('Users.Users')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        @can('Role.Manage')
                        <li><a href="{{url('/roles')}}" key="">Roles</a></li>
                        @endcan

                        @can('User.Manage')
                        <li><a href="{{url('/users')}}" key="">Users</a></li>
                        @endcan

                        @can('Payment.Manage')
                        <li><a href="{{url('/payments')}}" key="">Payment</a> </li>
                        @endcan

                    </ul>
                </li>
                @endcan

                @can('Agents.Agents')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Agents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Agent.Manage')
                        <li><a href="{{url('/agent/users')}}" key="">Agent Account</a></li>
                        @endcan
                        @can('AgentSetting.Manage')
                        <li><a href="{{url('/agent/setting')}}" key="">Agent Setting</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Employees.Employees')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Employees</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        @can('Employee.Manage')
                        <li><a href="{{url('/employee/users')}}" key="">Employee</a></li>
                        @endcan
                        <li><a href="#" key=""> </a></li>

                    </ul>

                </li>
                @endcan

                @canany(['payment.requested', 'payment.request'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-card"></i>
                        <span key="t-contacts">Payment</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('payment.request')
                        <li><a href="{{ route('request.payment') }}" key="">Request Payment</a></li>
                        @endcan
                        @can('payment.requested')
                        <li><a href="{{ route('requested.payment') }}" key="">Requested Payment</a></li>
                        @endcan

                    </ul>
                </li>
                @endcan

                @can('crypto.manage')
                <li>
                    <a href="{{ route('crypto') }}" class="waves-effect">
                        <i class="bx bx-detail"></i>
                        <span>Crypto</span>
                    </a>
                </li>
                @endcan

                <li>
                    <a href="{{ route('merchant.application') }}" class="waves-effect">
                        <i class="bx bx-detail"></i>
                        <span>Merchant Application</span>
                    </a>
                </li>

                @can('network.manage')
                <li>
                    <a href="{{ route('network') }}" class="waves-effect">
                        <i class="bx bx-detail"></i>
                        <span>Network</span>
                    </a>
                </li>
                @endcan

                @can('Clients.Clients')
                <!-- <li>
                        <a href="{{url('/customer/clients')}}" class="waves-effect">
                            <i class="bx bx-chat"></i>
                            <span>Merchant</span>
                        </a>
                    </li> -->
                @endcan

                @can('All.Clients')
                <li>
                    <a href="{{url('/admin/allclients')}}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>All Merchants</span>
                    </a>
                </li>
                @endcan

                @can('onboarding.manage')
                <li>
                    <a href="{{ route('onboardings') }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Onboardings</span>
                    </a>
                </li>
                @endcan

                <!-- RK -->

                @can('onboarding.manage')
                <li>
                    <a href="{{ route('kycrequests') }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>KYC Requests</span>
                    </a>
                </li>
                @endcan

                <!-- RK -->

                @can('merchant_payment.manage')
                <li>
                    <a href="{{url('/admin/client/payment')}}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Merchant Payments</span>
                    </a>
                </li>
                @endcan

                @can('payment_method.manage')
                <li>
                    <a href="{{route('payment.method')}}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Payment Method</span>
                    </a>
                </li>
                @endcan

                @can('Attendance.Attendance')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-notepad"></i>
                        <span key="t-contacts">Attendance</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        @can('Attendance.Manage')
                        <li><a href="{{url('employee/attendance')}}" key="">Attendance</a></li>
                        @endcan
                        @can('MonthlyAttendance.Manage')
                        <li><a href="{{url('monthly/attendance')}}" key="">Monthly Attendance</a></li>
                        @endcan
                        @can('Leave.Manage')
                        <li><a href="{{url('employee/leaves')}}" key="">Leave</a></li>
                        @endcan
                        @can('LeaveType.Manage')
                        <li><a href="{{url('leave_types/index/')}}" key="">Leave Type</a></li>
                        @endcan

                    </ul>

                </li>
                @endcan

                @canany(['accounting.accounts', 'accounting.account_create', 'accounting.deposit', 'accounting.expense', 'accounting.transfer', 'accounting.bills', 'accounting.times'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Accounting</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('accounting.accounts')
                        <li><a href="{{url('/accounts')}}" key="">Accounts</a></li>
                        @endcan
                        @can('accounting.account_create')
                        <li><a href="{{route('accounts.create')}}" key="">New Account</a></li>
                        @endcan
                        @can('accounting.deposit')
                        <li><a href="{{url('/deposit')}}" key="">New Deposit</a></li>
                        @endcan
                        @can('accounting.expense')
                        <li><a href="{{url('/expense')}}" key="">New Expense</a></li>
                        @endcan
                        @can('accounting.transfer')
                        <li><a href="{{url('/transfer')}}" key="">Transfer</a></li>
                        @endcan
                        @can('accounting.bills')
                        <li><a href="{{url('/bills')}}" key="">Bills</a></li>
                        @endcan
                        @can('accounting.times')
                        <li><a href="{{url('/times')}}" key="">Time</a></li>
                        @endcan
                        <li><a href="#" key="">View Transactions</a></li>
                        <li><a href="#" key="">Uncleared Transactions</a></li>
                        <li><a href="#" key="">Assets</a></li>

                    </ul>
                </li>
                @endcan


                @can('Projects.Management')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Project Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Projects.Show')
                        <li><a href="{{url('/projects')}}" key="">Projects</a></li>
                        @endcan

                        @can('Task.Show')
                        <li><a href="{{url('/tasks_master')}}" key="">Task Master</a></li>
                        @endcan


                    </ul>
                </li>
                @endcan

                @can('Sales.Manage')
                <li>
                    <a href="{{url('/adminstatssales')}}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Sales</span>
                    </a>
                </li>
                @endcan

                @can('Reports.Manage')
                <li>
                    <a href="{{url('/new/adminstatsreports')}}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Reports</span>
                    </a>
                </li>
                @endcan

                @can('WeeklyReports.manage')
                <li>
                    <a href="{{url('/weeklyreports')}}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Weekly Reports</span>
                    </a>
                </li>
                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->