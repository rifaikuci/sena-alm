<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item">
        <a href=<?php echo base_url() . "siparis-satir" ?> class="nav-link">
            <i class="nav-icon fas fa-list"></i>
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
                Boyahane
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href=<?php echo base_url() . "boya/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Boyanmalar</p>
                </a>
            </li>

            <li class="nav-item">
                <a href=<?php echo base_url() . "firinlama/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fırınlamalar</p>
                </a>
            </li>

            <li class="nav-item">
                <a href=<?php echo base_url() . "kromat/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kromatlar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href=<?php echo base_url() . "boyaPaket/" ?> class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Boya Paketleme</p>
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

    
</ul>
