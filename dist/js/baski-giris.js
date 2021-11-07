var deneme = ""
var app = new Vue({
        el: "#baski-giris",
        data: {
            satirNo: "",
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
            isCheck : false,

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

                var day = date.getFullYear() + '-' + ay + '-' + gun + " " + date.getHours() + ":" + date.getMinutes();
                var baslazamani = gun + "." + ay + "." + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes()


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
                debugger;
                if (this.basilanNetKg && this.basilanNetKg > 0 && this.kg && this.kg > 0) {
                    var kalan = this.kg - this.basilanNetKg;
                    var bitirebilirDeger = (this.kg / 10);


                    if (kalan > 0) {
                        if (kalan < bitirebilirDeger) {
                            this.isCheck = true;
                        } else {
                            this.isCheck = false;
                        }
                    } else {
                        this.isCheck = false;
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
        app.isSelected = true;
        app.satirNo = selectedRow.satirNo;
        app.musteriAd = selectedRow.musteriAd;
        app.profil = selectedRow.profil;
        app.alasim = selectedRow.alasim;
        app.tolerans = selectedRow.tolerans;
        app.boy = selectedRow.boy;
        app.kg = selectedRow.kg;
        app.adet = selectedRow.adet;
        app.aciklama = selectedRow.aciklama;
        app.biyetBirimGramaj = selectedRow.biyetBirimGramaj;
        app.basilanKilo = selectedRow.basilanKilo;
        app.basilanAdet = selectedRow.basilanAdet;
        app.kiloAdet = selectedRow.kiloAdet;
        app.siparisId = $(this).val();

        const takimlar = await axios.post('/sena/netting/baski/action.php', {
            action: 'takimgetir',
            profil: selectedRow.profilId,
        }).then((response) => {
            return response.data
        });

        app.takimlar = takimlar;

    } else {
        app.isSelected = false;
    }


});

$('#takim_id').on("change", async function () {

    app.takimId = $(this).val();
});

$('#supplier_id').select2({});
$('#takim_id').select2({});