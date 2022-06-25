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
                Paketleme
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href=<?php echo base_url() . "paket/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Paketleme</p>
                </a>
            </li>

            <li class="nav-item">
                <a href=<?php echo base_url() . "naylon/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Naylon</p>
                </a>
            </li>

            <li class="nav-item">
                <a href=<?php echo base_url() . "balyalama/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Balyalama</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>
                Sevkiyat
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href=<?php echo base_url() . "sevkiyat/gelen/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sevkiyat Gelen</p>
                </a>
            </li>

            <li class="nav-item">
                <a href=<?php echo base_url() . "sevkiyat/giden/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sevkiyat Çıkış</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="<?php echo base_url() . "sepet/" ?> " class="nav-link">
            <i class="nav-icon fas fa-poo-storm"></i>
            <p>
                Sepetler
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?php echo base_url() . "netting/login/index.php/?cikisyap=true" ?>" class="nav-link">
            <i class="nav-icon far fa-circle text-danger"></i>
            <p>Çıkış Yap</p>
        </a>
    </li>
</ul>
