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
            istenilenTermik: '',
            baskiId: '',
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
            kalanKg: 0,

            arrayBiyetBoy: [],
            arrayBiyetId: [],
            arrayBiyetAd: [],
            arrayBiyetFirma: [],
            arrayBiyetVerilenBiyet: [],
            arrayBiyetAraisFire: [],
            arrayBiyetKonveyorBoy: [],
            arrayBiyetBoylamFire: [],
            arrayBiyetFireBiyet: [],
            arrayBiyetBaskiFire: [],
            arrayBiyetler: [],
            arrayBiyetBrut: [],

            biyet: {
                biyetId: "",
                biyetAd: "",
                biyetFirma: "",
                biyetBoy: "",
                biyetVerilenBiyet: "",
                biyetAraisFire: "",
                biyetKonveyorBoy: "",
                biyetBoylamFire: "",
                biyetFireBiyet: "",
                biyetBaskiFire: "",
                biyetBrut: 0
            },
            biyetData: false
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

            biyetbaskisiekle(event) {
                event.preventDefault();
                if (this.biyet.biyetBoy &&
                    this.biyet.biyetVerilenBiyet &&
                    this.biyet.biyetAraisFire &&
                    this.biyet.biyetKonveyorBoy &&
                    this.biyet.biyetBoylamFire &&
                    this.biyet.biyetFireBiyet &&
                    this.biyet.biyetBaskiFire) {

                    this.arrayBiyetler.push(this.biyet);
                    this.arrayBiyetBoy.push(this.biyet.biyetBoy);
                    this.arrayBiyetVerilenBiyet.push(this.biyet.biyetVerilenBiyet);
                    this.arrayBiyetAraisFire.push(this.biyet.biyetAraisFire);
                    this.arrayBiyetKonveyorBoy.push(this.biyet.biyetKonveyorBoy);
                    this.arrayBiyetBoylamFire.push(this.biyet.biyetBoylamFire);
                    this.arrayBiyetFireBiyet.push(this.biyet.biyetFireBiyet);
                    this.arrayBiyetBaskiFire.push(this.biyet.biyetBaskiFire);
                    this.arrayBiyetId.push(this.biyet.biyetId);
                    this.arrayBiyetAd.push(this.biyet.biyetAd);
                    this.arrayBiyetFirma.push(this.biyet.biyetFirma);
                    this.arrayBiyetBrut.push(this.biyet.biyetBrut);

                    this.biyetData = false;
                    this.biyet = {
                        biyetBoy: "",
                        biyetVerilenBiyet: "",
                        biyetAraisFire: "",
                        biyetKonveyorBoy: "",
                        biyetBoylamFire: "",
                        biyetFireBiyet: "",
                        biyetBaskiFire: "",
                        biyetId: "",
                        biyetAd: "",
                        biyetFirma: "",
                        biyetBrut: 0
                    }
                }
                this.brutHesapla();
            },

            brutHesapla: function () {
                this.basilanBrutKg = 0;
              this.arrayBiyetBrut.forEach((item) => {
                this.basilanBrutKg = Number(this.basilanBrutKg) + Number(item);
              });
            },

            biyetSil: function (index) {
                this.$delete(this.arrayBiyetler, index);
                this.$delete(this.arrayBiyetBoy, index);
                this.$delete(this.arrayBiyetVerilenBiyet, index);
                this.$delete(this.arrayBiyetAraisFire, index);
                this.$delete(this.arrayBiyetKonveyorBoy, index);
                this.$delete(this.arrayBiyetBoylamFire, index);
                this.$delete(this.arrayBiyetFireBiyet, index);
                this.$delete(this.arrayBiyetBaskiFire, index);
                this.$delete(this.arrayBiyetId, index);
                this.$delete(this.arrayBiyetAd, index);
                this.$delete(this.arrayBiyetFirma, index);
                this.$delete(this.arrayBiyetBrut, index);
                this.brutHesapla();

            },

            calculateBrut: function (index) {
                if (this.biyet.biyetBoylamFire && this.biyet.biyetKonveyorBoy && this.biyet.biyetBoylamFire > 0 && this.biyet.biyetKonveyorBoy > 0) {
                    this.biyet.biyetBaskiFire = (this.biyet.biyetBoylamFire * 2) / this.biyet.biyetKonveyorBoy;
                    this.biyet.biyetBaskiFire = (this.biyet.biyetBaskiFire).toFixed(2);
                    this.biyet.biyetBaskiFire = (this.biyet.biyetBaskiFire) * 100;
                }
            },

            handleBiyetBrut: function () {
                if(this.biyet.biyetBoy && this.biyet.biyetBoy > 0  &&
                    this.biyetBirimGramaj && this.biyetBirimGramaj > 0 &&
                    this.biyet.biyetVerilenBiyet && this.biyet.biyetVerilenBiyet > 0) {

                    this.biyet.biyetBrut = this.biyet.biyetVerilenBiyet * this.biyet.biyetBoy * this.biyetBirimGramaj
                    this.biyet.biyetBrut = ( this.biyet.biyetBrut / 1000).toFixed(3);
                }

                this.fireHesapla();
            },

            handleBiyetFire(event) {
                this.fireHesapla()
            },

            handleBiyetBoy(event) {

                if (event.target.value && event.target.value > 0 &&
                    this.verilenBiyet && this.verilenBiyet > 0 &&
                    this.biyetBirimGramaj && this.biyetBirimGramaj > 0) {
                    this.biyet.biyetBrut = event.target.value * this.verilenBiyet * this.biyetBirimGramaj
                    this.biyet.biyetBrut = (this.biyet.biyetBrut / 1000).toFixed(3);
                }

            },

            handleVerilenBiyet(event) {
                if (event.target.value && event.target.value > 0 &&
                    this.biyetBoy && this.biyetBoy > 0 &&
                    this.biyetBirimGramaj && this.biyetBirimGramaj > 0) {

                }
                this.fireHesapla();
            },
            handleBasilanNetAdet(event) {
                if (event.target.value && event.target.value > 0 &&
                    this.guncelGr && this.guncelGr > 0 &&
                    this.boy && this.boy > 0) {
                    this.basilanNetKg = event.target.value * this.boy * this.guncelGr
                    this.basilanNetKg = (this.basilanNetKg / 1000000).toFixed(3);
                }
                this.fireHesapla();
            },
            handleGuncelGr(event) {
                if (event.target.value && event.target.value > 0 &&
                    this.basilanNetAdet && this.basilanNetAdet > 0 &&
                    this.boy && this.boy > 0) {
                    this.basilanNetKg = event.target.value * this.boy * this.basilanNetAdet
                    this.basilanNetKg = (this.basilanNetKg / 1000000).toFixed(3);
                }
                this.fireHesapla();
            },

            fireHesapla() {
                if (this.basilanNetKg > 0 && this.basilanBrutKg > 0) {
                    this.fire = this.basilanBrutKg - this.basilanNetKg;
                    this.fire = (this.fire).toFixed(3);
                }
                this.biyetDataKontrol()
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
                    this.biyetSicaklik &&
                    this.kalipSicaklik &&
                    this.guncelGr &&
                    this.basilanBrutKg &&
                    this.basilanNetAdet &&
                    this.basilanNetKg &&
                    this.arrayBiyetler.length > 0 &&
                    this.fire) {
                    this.baskiBitir = true;
                } else {
                    this.baskiBitir = false;
                }
            },

            biyetDataKontrol() {
                if (
                    this.biyet.biyetId &&
                    this.biyet.biyetAd &&
                    this.biyet.biyetFirma &&
                    this.biyet.biyetVerilenBiyet &&
                    this.biyet.biyetAraisFire &&
                    this.biyet.biyetKonveyorBoy &&
                    this.biyet.biyetBoylamFire &&
                    this.biyet.biyetFireBiyet &&
                    this.biyet.biyetBaskiFire
                ) {
                    this.biyetData = true
                } else  this.biyetData = false;
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
        baskigiris.istenilenTermik = selectedRow.istenilenTermik;
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

$('#biyet_id').on("change", async function () {

    var array = $(this).val().split(";");
    baskigiris.biyet.biyetId = array[0];
    baskigiris.biyet.biyetAd = array[2];
    baskigiris.biyet.biyetFirma = array[3];
    baskigiris.biyetBirimGramaj = array[4];
    console.log(array)

});

$('#takim_id').on("change", async function () {

    baskigiris.takimId = $(this).val();
});

$('#supplier_id').select2({});
$('#takim_id').select2({});
$('#biyet_id').select2({});