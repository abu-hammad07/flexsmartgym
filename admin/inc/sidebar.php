<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
?>
<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="index" class="app-brand-link">
            <!-- <span class="app-brand-logo demo"> -->
                <!-- <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                </svg> -->
                <img src="../assets/img/logo/flexsmartgym.png" alt="" width="20%">
            <!-- </span> -->
            <span class="app-brand-text demo menu-text fw-bold">Flex Smart</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>



    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item <?php if ($page == 'index.php') {
                                    echo 'active';
                                } ?>">
            <a href="index" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <!-- Membership -->
        <li class="menu-item <?php if ($page == 'membership-details.php' || $page == 'membership-view.php' || $page == 'membership-edit.php' || $page == 'add-membership.php') {
                                    echo 'active';
                                } ?>">
            <a href="membership-details" class="menu-link">
                <i class="menu-icon ti ti-cash"></i>
                <div data-i18n="Membership">Membership</div>
            </a>
        </li>
        <!-- Notice -->
        <!-- <li class="menu-item <?php //if ($page == 'membership-details.php' || $page == 'membership-view.php' || $page == 'membership-edit.php' || $page == 'add-membership.php') {
                                    //echo 'active';
                                //} ?>">
            <a href="membership-details" class="menu-link">
                <i class="menu-icon ti ti-notes"></i>
                <div data-i18n="Notice">Notice</div>
            </a>
        </li> -->
        <!-- Features -->
        <!-- <li class="menu-item">
            <a href="fetures" class="menu-link">
                <i class="menu-icon ti ti-list-check"></i>
                <div data-i18n="Features">Features</div>
            </a>
        </li> -->
        <!-- Users -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Users">Users</span>
        </li>
        <!-- Memebers -->
        <li class="menu-item <?php if ($page == 'members-details.php' || $page == 'add-member.php' || $page == 'member-view.php' || $page == 'member-edit.php') {
                                    echo 'active';
                                } ?>">
            <a href="members-details" class="menu-link">
                <i class="menu-icon ti ti-users"></i>
                <div data-i18n="Members">Members</div>
            </a>
        </li>
        <!-- Staff -->
        <li class="menu-item <?php if ($page == 'staff-details.php' || $page == 'add-staff.php') {
                                    echo 'active';
                                } ?>">
            <a href="staff-details" class="menu-link">
                <i class="menu-icon ti ti-user"></i>
                <div data-i18n="Staff">Staff</div>
            </a>
            <!-- <ul class="menu-sub">
                <li class="menu-item <?php //if ($page == 'staff-details.php' || $page == 'staff-edit.php' || $page == 'staff-view.php') {
                                            //echo 'active';
                                        //} ?>">
                    <a href="staff-details" class="menu-link">
                        <div data-i18n="Staff Details">Staff Details</div>
                    </a>
                </li>
                <li class="menu-item <?php //if ($page == 'add-staff.php') {
                                            //echo 'active';
                                        //} ?>">
                    <a href="add-staff" class="menu-link">
                        <div data-i18n="Add Staff">Add Staff</div>
                    </a>
                </li>
                <li class="menu-item <?php //if ($page == 'salary.php' || $page == 'add-salary.php' || $page == 'salary-edit.php' || $page == 'salary-view.php') {
                                            //echo 'active';
                                        //} ?>">
                    <a href="salary" class="menu-link">
                        <div data-i18n="Salary">Salary</div>
                    </a>
                </li>
            </ul> -->
        </li>
        <!-- Admin  -->
        <li class="menu-item <?php if ($page == 'admin-details.php' || $page == 'add-admin.php' || $page == 'admin-view.php' || $page == 'admin-edit.php') {
                                    echo 'active open';
                                } ?>">
            <a href="admin-details" class="menu-link">
                <i class="menu-icon ti ti-user-square-rounded"></i>
                <div data-i18n="Admin">Admin</div>
            </a>
            <!-- <ul class="menu-sub">
                <li class="menu-item <?php //if ($page == 'admin-details.php' || $page == 'admin-view.php' || $page == 'admin-edit.php') {
                                            //echo 'active';
                                        //} ?>">
                    <a href="admin-details" class="menu-link">
                        <div data-i18n="Admin Details">Admin Details</div>
                    </a>
                </li>
                <li class="menu-item <?php //if ($page == 'add-admin.php') {
                                            //echo 'active';
                                        //} ?>">
                    <a href="add-admin" class="menu-link">
                        <div data-i18n="Add Admin">Add Admin</div>
                    </a>
                </li>
            </ul> -->
        </li>
        <!-- Attendence  -->
        <li class="menu-item <?php if ($page == 'attendence-details.php' || $page == 'add-attendence.php' || $page == 'attendence-view.php' || $page == 'attendence-edit.php') {
                                    echo 'active';
                                } ?>">
            <a href="attendence-details" class="menu-link">
                <i class="menu-icon ti ti-clipboard-check"></i>
                <div data-i18n="Attendence">Attendence</div>
            </a>
            <!-- <ul class="menu-sub">
                <li class="menu-item <?php //if ($page == 'attendence-details.php' || $page == 'attendence-view.php' || $page == 'attendence-edit.php') {
                                            //echo 'active';
                                        //} ?>">
                    <a href="attendence-details" class="menu-link">
                        <div data-i18n="Attendence Details">Attendence Details</div>
                    </a>
                </li>
                <li class="menu-item <?php //if ($page == 'add-attendence.php') {
                                            //echo 'active';
                                        //} ?>">
                    <a href="add-attendence" class="menu-link">
                        <div data-i18n="Add Attendence">Add Attendence</div>
                    </a>
                </li>
            </ul> -->
        </li>
        <!-- Users -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Accounts">Accounts</span>
        </li>
        <!-- Salary -->
        <li class="menu-item <?php if ($page == 'salary.php' || $page == 'add-salary.php' || $page == 'salary-edit.php' || $page == 'salary-view.php') {echo 'active';} ?>">
            <a href="salary" class="menu-link">
                <i class="menu-icon ti ti-coin-rupee"></i>
                <div data-i18n="Salary">Salary</div>
            </a>
        </li>
        <!-- Expense -->
        <li class="menu-item <?php if ($page == 'expense-details.php' || $page == 'add-expense.php' || $page == 'category.php' || $page == 'expense-edit.php' || $page == 'expense-view.php') {
                                    echo 'active open';
                                } ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ti ti-cash"></i>
                <div data-i18n="Expense">Expense</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?php if ($page == 'expense-details.php' || $page == 'expense-edit.php' || $page == 'expense-view.php' || $page == 'add-expense.php') {
                                            echo 'active';
                                        } ?>">
                    <a href="expense-details" class="menu-link">
                        <div data-i18n="Expense">Expense</div>
                    </a>
                </li>
                <li class="menu-item <?php if ($page == 'category.php') {
                                            echo 'active';
                                        } ?>">
                    <a href="category" class="menu-link">
                        <div data-i18n="Category">Category</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Income -->
        <li class="menu-item <?php if ($page == 'income-details.php' || $page == 'income-deposit.php' || $page == 'add-income.php' || $page == 'income-edit.php' || $page == 'income-view.php') {
                                    echo 'active open';
                                } ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ti ti-businessplan"></i>
                <div data-i18n="Income">Income</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?php if ($page == 'income-details.php' || $page == 'income-edit.php' || $page == 'income-view.php' || $page == 'add-income.php') {
                                            echo 'active';
                                        } ?>">
                    <a href="income-details" class="menu-link">
                        <div data-i18n="Income">Income</div>
                    </a>
                </li>
                <li class="menu-item <?php if ($page == 'income-deposit.php') {
                                            echo 'active';
                                        } ?>">
                    <a href="income-deposit" class="menu-link">
                        <div data-i18n="Deposit">Deposit</div>
                        <!-- <div class="badge bg-danger rounded-pill ms-auto">4</div> -->
                    </a>
                </li>
            </ul>
        </li>



    </ul>



</aside>
<!-- / Menu -->