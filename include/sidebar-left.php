

<div class="sidebar">

    <nav class="mt-2">

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                        Tanımlar
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/firma" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Firmalar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/firmatur" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Firma Türü</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/personel" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Personeller</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/alasim" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Alaşım</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/sektor" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Sektör</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/boya" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Boyalar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/malzemeler" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Malzemeler</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo base_url() . "tanimlar/profil" ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Profiller</p>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "sevkiyat/gelen" ?> " class="nav-link">
                    <i class="nav-icon fa fa-adjust"></i>
                    <p>
                        Sevkiyat - Gelen
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "sevkiyat/giden" ?> " class="nav-link">
                    <i class="nav-icon fa fa-adjust"></i>
                    <p>
                        Sevkiyat - Çıkış
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "kalipci/" ?> " class="nav-link">
                    <i class="nav-icon fa fa-dumbbell"></i>
                    <p>
                        Parçalar
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "takim/" ?> " class="nav-link">
                    <i class="nav-icon fa fa-people-arrows"></i>
                    <p>
                        Takım
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "siparis/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Siparişler
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "siparis-satir/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Sipariş Satır Bazlı
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "baski/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-print"></i>
                    <p>
                        Baskılar
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "kesim/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-cut"></i>
                    <p>
                        Kesimler
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "termik/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-cut"></i>
                    <p>
                        Termikler
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "ayar/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Ayarlar
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "havuz/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Havuzlar
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "havuzKaliphane/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Kalıphane Havuzları
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "kromat/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Kromatlar
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "boya/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Boyanmalar
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "firinlama/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Fırınlama
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "boyapaket/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Boya Paketleme
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "paket/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Paketleme
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "balyalama/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                    Balyalama
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "naylon/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-poo-storm"></i>
                    <p>
                        Naylon
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "sepet/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Sepetler
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url() . "kaliphane/" ?> " class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Kalıphane
                    </p>
                </a>
            </li>


            <li class="nav-item">
                <a href="https://rifaikuci.com/" class="nav-link">
                    <i class="nav-icon far fa-circle text-info"></i>
                    <p>İletişim</p>
                </a>
            </li>
        </ul>
    </nav>