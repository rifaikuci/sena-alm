var baskiguncelle = new Vue({
        el: "#baski-guncelle",
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
            istenilenTermik: '',
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
            kalanKg: 0,
            baslaSaat: "00:00",
            baslaTarih: "00:00",
            bitisSaat: "",
            bitisTarih: "",
            kayitTarih: "",
            vardiya: "",
            vardiyaKod: ""

        },

        mounted: async function () {
            this.baskiId = $(this)[0]._vnode.data.attrs.baski;

            const baskiresponse = await axios.post('/sena/netting/baski/action.php', {
                action: 'baskiguncellegetir',
                id: this.baskiId
            }).then((response) => {
                return response.data
            });
            this.profilId = baskiresponse.profilId;
            this.siparisId = baskiresponse.siparisId;
            this.takimId = baskiresponse.takimId;
            this.baslaSaat = baskiresponse.baslaSaat;
            this.bitisSaat = baskiresponse.bitisSaat;
            this.baslaTarih = baskiresponse.baslaTarih;
            this.bitisTarih = baskiresponse.bitisTarih;
            this.kayitTarih = baskiresponse.kayitTarih;
            this.vardiya = baskiresponse.vardiya;
            this.vardiyaKod = baskiresponse.vardiyaKod;
            this.operatorId = baskiresponse.operatorId;
            this.biyetId = baskiresponse.biyetId;
            this.biyetBoy = baskiresponse.biyetBoy;
            this.araIsFire = baskiresponse.araIsFire;
            this.konveyorBoy = baskiresponse.konveyorBoy;
            this.boylamFire = baskiresponse.boylamFire;
            this.baskiFire = baskiresponse.baskiFire;
            this.biyetFire = baskiresponse.biyetFire;
            this.verilenBiyet = baskiresponse.verilenBiyet;
            this.guncelGr = baskiresponse.guncelGr;
            this.basilanBrutKg = baskiresponse.basilanBrutKg;
            this.istenilenTermik = baskiresponse.istenilenTermik;
            this.basilanNetKg = baskiresponse.basilanNetKg;
            this.basilanNetAdet = baskiresponse.basilanNetAdet;
            this.kovanSicaklik = baskiresponse.kovanSicaklik;
            this.kalipSicaklik = baskiresponse.kalipSicaklik;
            this.biyetSicaklik = baskiresponse.biyetSicaklik;
            this.hiz = baskiresponse.hiz;
            this.fire = baskiresponse.fire;
            this.performans = baskiresponse.performans;
            this.takimSonDurum = baskiresponse.takimSonDurum;
            this.aciklama = baskiresponse.aciklama;
            this.sonlanmaNeden = baskiresponse.sonlanmaNeden;
            this.profilId = baskiresponse.profilId;

            const takimlar = await axios.post('/sena/netting/baski/action.php', {
                action: 'takimgetir',
                profil: this.profilId,
            }).then((response) => {
                return response.data
            });

            this.takimlar = takimlar;


            const data = await axios.post('/sena/netting/baski/action.php', {
                action: 'baskigetir',
                id: this.siparisId,
            }).then((response) => {
                return response.data
            });


            if (data) {
                this.isSelected = true;
                this.satirNo = data.satirNo;
                this.musteriAd = data.musteriAd;
                this.profil = data.profil;
                this.alasim = data.alasim;
                this.tolerans = data.tolerans;
                this.boy = data.boy;
                this.kg = data.kg;
                this.adet = data.adet;
                this.aciklama = data.aciklama;
                this.biyetBirimGramaj = data.biyetBirimGramaj;
                this.basilanKilo = data.basilanKilo;
                this.basilanAdet = data.basilanAdet;
                this.kiloAdet = data.kiloAdet;
                this.kalanKg = data.kalanKg;

            } else {
                this.isSelected = false;
            }
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


$('#siparis_guncelle').on("change", async function () {

    const selectedRow = await axios.post('/sena/netting/baski/action.php', {
        action: 'baskigetir',
        id: $(this).val(),
    }).then((response) => {
        return response.data
    });


    if (selectedRow) {
        baskiguncelle.isSelected = true;
        baskiguncelle.satirNo = selectedRow.satirNo;
        baskiguncelle.istenilenTermik = selectedRow.istenilenTermik;
        baskiguncelle.musteriAd = selectedRow.musteriAd;
        baskiguncelle.profil = selectedRow.profil;
        baskiguncelle.alasim = selectedRow.alasim;
        baskiguncelle.tolerans = selectedRow.tolerans;
        baskiguncelle.boy = selectedRow.boy;
        baskiguncelle.kg = selectedRow.kg;
        baskiguncelle.adet = selectedRow.adet;
        baskiguncelle.aciklama = selectedRow.aciklama;
        baskiguncelle.biyetBirimGramaj = selectedRow.biyetBirimGramaj;
        baskiguncelle.basilanKilo = selectedRow.basilanKilo;
        baskiguncelle.basilanAdet = selectedRow.basilanAdet;
        baskiguncelle.kiloAdet = selectedRow.kiloAdet;
        baskiguncelle.kalanKg = selectedRow.kalanKg;
        baskiguncelle.siparisId = $(this).val();

        const takimlar = await axios.post('/sena/netting/baski/action.php', {
            action: 'takimgetir',
            profil: selectedRow.profilId,
        }).then((response) => {
            return response.data
        });

        baskiguncelle.takimlar = takimlar;

    } else {
        baskiguncelle.isSelected = false;
    }


});

$('#takim_id_guncelle').on("change", async function () {

    baskiguncelle.takimId = $(this).val();
});

$('#siparis_guncelle').select2({});
$('#takim_id_guncelle').select2({})
