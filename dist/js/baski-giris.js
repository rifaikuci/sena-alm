var baskigiris = new Vue({
        el: "#baski-giris",
        data: {
            satirNo: 0,
            musteriAd: "",
            profil: "",
            alasim: "",
            tolerans: "",
            biyetBirimGramaj: "",
            boy: "",
            kg: "",
            adet: "",
            aciklama: "",
            isSelected: false,
            profilId: "",
            takimlar: [],
            secilenTakim: "",
            siparisId: '',
            takimıd: '',
            baskiId: '',
            biyetBoy: '',
            araIsFire: '',
            konveyorBoy: '',
            boylamFire: '',
            baskiFire: '',
            biyetFire: '',
            verilenBiyet: '',
            guncelGr: '',
            basilanBrutKg: 0,
            basilanNetAdet: 0,
            basilanNetKg: 0,
            kovanSicaklik: '',
            kalipSicaklik: '',
            biyetSicaklik: '',
            hiz: '',
            fire: '',
            baskiBitir: false,
            baskiBasla: false,
            baslazamani: '',
            basilanKilo: '',
            basilanAdet: '',
            kiloAdet: '',
            isCheck: false,
            baskiDurum: false,
            kalanKg: 0

        },


        methods: {
            async baskiekle(event) {
                event.preventDefault();
                var date = new Date();
                date.setMonth(date.getMonth() + 1);

                gun = date.getDate().toString().length == 1 ? "0" + date.getDate() : date.getDate();
                ay = date.getMonth().toString().length == 1 ? "0" + date.getMonth() : date.getMonth();
                if (ay == "00")
                    ay = "01"

                saat = date.getHours().toString().length == 1 ? "0" + date.getHours() : date.getHours();
                dakika = date.getMinutes().toString().length == 1 ? "0" + date.getMinutes() : date.getMinutes();
                var day = date.getFullYear() + '-' + ay + '-' + gun + " " + saat + ":" + dakika;
                var baslazamani = gun + "." + ay + "." + date.getFullYear() + " " + saat + ":" + dakika


                const response = await axios.post('/sena/netting/baski/action.php', {
                    action: 'baskibaslat',
                    baslazamani: day,
                    siparisId: this.siparisId,
                    takimId: this.takimId
                }).then((response) => {
                    return response.data
                });

                this.baskiId = response.baski;
                this.baskiBasla = true;
                this.baslazamani = baslazamani;
            },

            handleBoylamFire(event) {
                if (event.target.value && event.target.value > 0 && this.konveyorBoy && this.konveyorBoy > 0) {
                    this.baskiFire = (event.target.value * 2) / this.konveyorBoy;
                }

                this.fireHesapla();
            },

            handleChangeKonveyor(event) {
                if (event.target.value && event.target.value > 0 && this.boylamFire && this.boylamFire > 0) {
                    this.baskiFire = (this.boylamFire * 2) / event.target.value;
                }
                this.fireHesapla();
            },

            handleBiyetBoy(event) {

                if (event.target.value && event.target.value > 0 &&
                    this.verilenBiyet && this.verilenBiyet > 0 &&
                    this.biyetBirimGramaj && this.biyetBirimGramaj > 0) {
                    this.basilanBrutKg = event.target.value * this.verilenBiyet * this.biyetBirimGramaj
                }
                this.fireHesapla();
            },
            handleVerilenBiyet(event) {
                if (event.target.value && event.target.value > 0 &&
                    this.biyetBoy && this.biyetBoy > 0 &&
                    this.biyetBirimGramaj && this.biyetBirimGramaj > 0) {
                    this.basilanBrutKg = event.target.value * this.biyetBoy * this.biyetBirimGramaj
                }
                this.fireHesapla();
            },
            handleBasilanNetAdet(event) {
                if (event.target.value && event.target.value > 0 &&
                    this.guncelGr && this.guncelGr > 0 &&
                    this.boy && this.boy > 0) {
                    this.basilanNetKg = event.target.value * this.boy * this.guncelGr
                }
                this.fireHesapla();
            },
            handleGuncelGr(event) {
                if (event.target.value && event.target.value > 0 &&
                    this.basilanNetAdet && this.basilanNetAdet > 0 &&
                    this.boy && this.boy > 0) {
                    this.basilanNetKg = event.target.value * this.boy * this.basilanNetAdet
                }
                this.fireHesapla();
            },
            fireHesapla() {
                if (this.basilanNetKg > 0 && this.basilanBrutKg > 0) {
                    this.fire = this.basilanNetKg - this.basilanBrutKg;
                }
                this.dataKontrol();
                this.checkBitir();

            },

            checkBitir() {
                if (this.basilanNetKg && this.basilanNetKg > 0 && this.kg && this.kg > 0) {
                    var kalan = (this.kalanKg - this.basilanNetKg);
                    var bitirebilirDeger = (this.kg / 10);


                    if (kalan > 0) {
                        if (kalan < bitirebilirDeger) {
                            this.isCheck = true;
                        } else {
                            this.isCheck = false;
                            this.baskiDurum = false;
                        }
                    } else {
                        this.isCheck = false;
                        this.baskiDurum = true;
                    }
                }
            },
            handleKovanSicaklik(event) {
                this.fireHesapla();
            },
            handleKalipSicaklik(event) {
                this.fireHesapla();
            },
            handleBiyetSicaklik(event) {
                this.fireHesapla();
            },
            handleHiz(event) {
                this.fireHesapla();
            },
            dataKontrol() {
                if (
                    this.basilanNetKg &&
                    this.satirNo &&
                    this.isSelected == true &&
                    this.boy &&
                    this.hiz &&
                    this.kg &&
                    this.adet &&
                    this.takimId &&
                    this.verilenBiyet &&
                    this.konveyorBoy &&
                    this.biyetSicaklik &&
                    this.kalipSicaklik &&
                    this.guncelGr &&
                    this.basilanBrutKg &&
                    this.basilanNetAdet &&
                    this.basilanNetKg &&
                    this.fire) {
                    this.baskiBitir = true;
                } else {
                    this.baskiBitir = false;
                }
            }
        }
    }
);


$('#supplier_id').on("change", async function () {

    const selectedRow = await axios.post('/sena/netting/baski/action.php', {
        action: 'baskigetir',
        id: $(this).val(),
    }).then((response) => {
        return response.data
    });


    if (selectedRow) {
        baskigiris.isSelected = true;
        baskigiris.satirNo = selectedRow.satirNo;
        baskigiris.musteriAd = selectedRow.musteriAd;
        baskigiris.profil = selectedRow.profil;
        baskigiris.alasim = selectedRow.alasim;
        baskigiris.tolerans = selectedRow.tolerans;
        baskigiris.boy = selectedRow.boy;
        baskigiris.kg = selectedRow.kg;
        baskigiris.adet = selectedRow.adet;
        baskigiris.aciklama = selectedRow.aciklama;
        baskigiris.biyetBirimGramaj = selectedRow.biyetBirimGramaj;
        baskigiris.basilanKilo = selectedRow.basilanKilo;
        baskigiris.basilanAdet = selectedRow.basilanAdet;
        baskigiris.kiloAdet = selectedRow.kiloAdet;
        baskigiris.kalanKg = selectedRow.kalanKg;
        baskigiris.siparisId = $(this).val();

        const takimlar = await axios.post('/sena/netting/baski/action.php', {
            action: 'takimgetir',
            profil: selectedRow.profilId,
        }).then((response) => {
            return response.data
        });

        baskigiris.takimlar = takimlar;

    } else {
        baskigiris.isSelected = false;
    }


});

$('#takim_id').on("change", async function () {

    baskigiris.takimId = $(this).val();
});

$('#supplier_id').select2({});
$('#takim_id').select2({});