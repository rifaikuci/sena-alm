<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="<?php echo base_url() . "siparis-satir/" ?> " class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
                Sipariş Satır Bazlı
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href=<?php echo base_url() . "tanimlar/profil" ?> class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>Profiller</p>
        </a>
    </li>
    <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>
                Pres
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href=<?php echo base_url() . "baski/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Baskılar</p>
                </a>
            </li>

            <li class="nav-item">
                <a href=<?php echo base_url() . "kesim/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kesimler</p>
                </a>
            </li>

            <li class="nav-item">
                <a href=<?php echo base_url() . "termik/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Termik</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href=<?php echo base_url() . "kaliphane/" ?> class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Kalıphane</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?php echo base_url() . "sepet/" ?> " class="nav-link">
            <i class="nav-icon fas fa-poo-storm"></i>
            <p>
                Sepetler
            </p>
        </a>
    </li>


</ul>
