var deneme = ""
var appyaribaskiguncelle = new Vue({
        el: "#baski-yari-guncelle",
        data: {
            boy: "",
            kg: "",
            adet: "",
            isSelected: false,
            biyetBoyG: '',
            konveyorBoyG: '',
            boylamFireG: '',
            baskiFireG: '',
            verilenBiyetG: '',
            guncelGrG: '',
            basilanBrutKgG: '',
            basilanNetAdetG: '',
            basilanNetKgG: '',
            kovanSicaklikG: '',
            kalipSicaklikG: '',
            biyetSicaklikG: '',
            hizG: '',
            fireG: '',
            baskiBitirG: false,
            baskiBasla: false,
            basilanKilo: '',
            basilanAdet: '',
            kiloAdet: '',
            isCheckG: false,
            baskiDurumG: false,
            kalanKg: ''

        },

        mounted: function () {
            this.boy = $(this)[0]._vnode.data.attrs.value;
            this.biyetBirimGramaj = $(this)[0]._vnode.data.attrs.birimgr;
            this.kg = $(this)[0]._vnode.data.attrs.kg;
            this.kalanKg = $(this)[0]._vnode.data.attrs.kalankgg;
            
            

        },

        methods: {


            handleBoylamFireG(event) {
                debugger
                if (event.target.value && event.target.value > 0 && this.konveyorBoyG && this.konveyorBoyG > 0) {
                    this.baskiFireG = (event.target.value * 2) / this.konveyorBoyG;
                }

                this.fireGHesapla();
            },

            handleChangeKonveyorG(event) {
                if (event.target.value && event.target.value > 0 && this.boylamFire && this.boylamFire > 0) {
                    this.baskiFireG = (this.boylamFire * 2) / event.target.value;
                }
                this.fireGHesapla();
            },

            handleBiyetBoyG(event) {
                
                if (event.target.value && event.target.value > 0 &&
                    this.biyetBirimGramaj && this.biyetBirimGramaj > 0) {
                    this.basilanBrutKgG = event.target.value * this.verilenBiyetG * this.biyetBirimGramaj
                }
                this.fireGHesapla();
            },
            handleverilenBiyetG(event) {
                
                if (event.target.value && event.target.value > 0 &&
                    this.biyetBoyG && this.biyetBoyG > 0 &&
                    this.biyetBirimGramaj && this.biyetBirimGramaj > 0) {
                    this.basilanBrutKgG = event.target.value * this.biyetBoyG * this.biyetBirimGramaj
                }
                this.fireGHesapla();
            },
            handlebasilanNetAdetG(event) {
                if (event.target.value && event.target.value > 0 &&
                    this.guncelGrG && this.guncelGrG > 0 &&
                    this.boy && this.boy > 0) {
                    this.basilanNetKgG = event.target.value * this.boy * this.guncelGrG
                }
                this.fireGHesapla();
            },
            handleguncelGrG(event) {
                
                if (event.target.value && event.target.value > 0 &&
                    this.basilanNetAdetG && this.basilanNetAdetG > 0 &&
                    this.boy && this.boy > 0) {
                    this.basilanNetKgG = event.target.value * this.boy * this.basilanNetAdetG
                }
                this.fireGHesapla();
            },
            fireGHesapla() {
                if (this.basilanNetKgG > 0 && this.basilanBrutKgG > 0) {
                    this.fireG = this.basilanNetKgG - this.basilanBrutKgG;
                }
                this.dataKontrol();
                this.checkBitir();

            },

            checkBitir() {
                
                if (this.basilanNetKgG && this.basilanNetKgG > 0 && this.kg && this.kg > 0) {
                    var kalan = (this.kalanKg - this.basilanNetKgG);
                    var bitirebilirDeger = (this.kg / 10);
                    
                    if (kalan > 0) {
                        if (kalan < bitirebilirDeger) {
                            this.isCheckG = true;
                        } else {
                            this.isCheckG = false;
                            this.baskiDurumG = false;
                        }
                    } else {
                        this.isCheckG = false;
                        this.baskiDurumG = true;
                    }
                }
            },
            handlekovanSicaklikG(event) {
                this.fireGHesapla();
            },
            handlekalipSicaklikG(event) {
                this.fireGHesapla();
            },
            handlebiyetSicaklikG(event) {
                this.fireGHesapla();
            },
            handlehizG(event) {
                this.fireGHesapla();
            },
            dataKontrol() {
                if (
                    this.basilanNetKgG &&
                    this.boy &&
                    this.hizG &&
                    this.kg &&
                    this.verilenBiyetG &&
                    this.konveyorBoyG &&
                    this.biyetSicaklikG &&
                    this.kalipSicaklikG &&
                    this.guncelGrG &&
                    this.basilanBrutKgG &&
                    this.basilanNetAdetG &&
                    this.basilanNetKgG &&
                    this.fireG) {
                    this.baskiBitirG = true;
                } else {
                    this.baskiBitirG = false;
                }
            }
        }
    }
);

