<?php global $functionsSMS; ?>

<div class="modal fade bs-example-modal-xl "tabindex="-1" role="dialog" id="modal" aria-labelledby="gridSystemModalLabel" >
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div id="modalHeader"></div>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </div>
            <div class="modal-body" id="modalbody">
                ...
            </div>

        </div>
    </div>
</div>
<div class="wrapper">


<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="<?php print URL; ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Plataforma</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php print URL; ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php print $_SESSION['login']['user']; ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <?php
                    $arrMenu = $functionsSMS->get_menu();
                    $strClassAdd = "";
                    $strFnM = "";
                    $strFnSm = "";
                    $strAdition = "";
                    $boolData = false;
                    //bin_debug($arrMenu);
                    foreach ($arrMenu as $intKeyMenu => $strValMenu) {
                    //            bin_debug($strValMenu);
                    if (!isset($strValMenu['SubMenu'])) {
                        $boolData = false;
                        $strClassAdd = "";
                        $strAdition = "";
                        $strFnM ="fn_sendMenu({$strValMenu['id_menu']})";
                        //$strFnSm="";
                    } else {
                        $boolData = true;
                        $strClassAdd = "menu-open";
                        $strAdition = "data-toggle=\"collapse\" data-target=\"#list{$strValMenu['menu']}\" aria-expanded=\"true\" aria-controls=\"collapsePages\"  ";
                        $strFnM ="";
                        //$strFnSm="fn_sendSubMenu({$strValMenu['id_menu']})";
                    }
                    ?>

                    <li class="nav-item has-treeview <?php print $strClassAdd; ?>" style="cursor: pointer;" onclick="<?php print $strFnM; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy <?php print $strValMenu{'icono'}; ?>"></i>
                            <p>
                                <?php print $strValMenu{'menu'}; ?>

                                <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <?php
                        if ($boolData) {
                        ?>
                        <ul class="nav nav-treeview" id='<?php print "list{$strValMenu{'menu'}}"; ?>'>
                            <?php
                            foreach ($strValMenu['SubMenu'] as $keySubmenu => $valSubMenu) {
                            //bin_debug($valSubMenu);
                            ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="fn_sendSubMenu(<?php print $valSubMenu['idsMenu'] ?>)">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?php print $valSubMenu['sMenu'] ?></p>
                                </a>
                            </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                        }
                        ?>
                    </li>
                    <?php
                    }
                    ?>

                    <li class="nav-item">
                        <a href="index.php?UserLogout=true" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Salir
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
            </div>
            <!-- /.card -->
        </section>
    </div>