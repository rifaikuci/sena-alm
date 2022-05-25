var boyaGiris = new Vue({
        el: "#boya-giris",
        data: {
            rutusAdet: "",
            topAdet: "",
            ortAskiAdet: "",
            topAski: "",
            kullanilanBoya: "",
            siklonKullanilanKg: "",
            siklonAyrilanKg: "",
            netBoya: "",
            sepetId: "",
            siklonId: "",
            boyalar: [],
            firinSicaklik: "",
            rutusId: "",
            boyanmaData: false,

            array: [],
            arraySepetId: [],
            arraySatirNo: [],
            arrayBaskiId: [],
            arrayProfilId: [],
            arrayAdet: [],
            arrayHurdaAdet: [],
            arrayHurdaSebep: [],

            boyanma: {
                sepetId: "",
                satirNo: "",
                baskiId: "",
                profilId: "",
                adet: "",
                hurdaAdet: "",
                hurdaSebep: ""
            }

        },


        methods: {

            changeTopAski() {
                if (this.topAski && this.topAski > 0 && this.topAdet && this.topAdet > 0) {
                    if (this.topAski && this.topAski > 0 && this.topAdet && this.topAdet > 0) {
                        this.ortAskiAdet = this.topAski / this.topAdet
                        this.ortAskiAdet = this.ortAskiAdet.toFixed(2);
                    } else
                        this.ortAskiAdet = 0;
                }
            },

            changeBoya(event) {
                this.netBoya = parseInt(this.kullanilanBoya ? this.kullanilanBoya : 0) +
                    parseInt(this.siklonKullanilanKg ? this.siklonKullanilanKg : 0) -
                    parseInt(this.siklonAyrilanKg ? this.siklonAyrilanKg : 0)

            },

            ekle(event) {

                event.preventDefault();
                if (this.boyanma.sepetId &&
                    this.boyanma.satirNo &&
                    this.boyanma.baskiId &&
                    this.boyanma.profilId &&
                    this.boyanma.adet) {

                    this.array.push(this.boyanma);
                    this.arraySepetId.push(this.boyanma.sepetId);
                    this.arraySatirNo.push(this.boyanma.satirNo);
                    this.arrayBaskiId.push(this.boyanma.baskiId);
                    this.arrayProfilId.push(this.boyanma.profilId);
                    this.arrayAdet.push(this.boyanma.adet);
                    this.arrayHurdaAdet.push(this.boyanma.hurdaAdet);
                    this.arrayHurdaSebep.push(this.boyanma.hurdaSebep);


                    this.boyanmaData = false;
                    this.boyanma = {
                        sepetId: "",
                        satirNo: "",
                        baskiId: "",
                        profilId: "",
                        adet: "",
                        hurdaAdet: "",
                        hurdaSebep: ""
                    }
                }
                this.tophesapla();
            },

            tophesapla: function () {
                this.topAdet = 0;
                this.arrayAdet.forEach((item) => {
                    this.topAdet = Number(this.topAdet) + Number(item);
                });
                this.topAdet = Number(this.topAdet) + Number(this.rutusAdet ? this.rutusAdet : 0);

                this.changeTopAski()
            },

            sil: function (index) {
                this.$delete(this.array, index);
                this.$delete(this.arraySepetId, index);
                this.$delete(this.arraySatirNo, index);
                this.$delete(this.arrayBaskiId, index);
                this.$delete(this.arrayProfilId, index);
                this.$delete(this.arrayAdet, index);
                this.$delete(this.arrayHurdaAdet, index);
                this.$delete(this.arrayHurdaSebep, index);
                this.tophesapla();

            },

            dataKontrol() {
                if (
                    this.boyanma.sepetId &&
                    this.boyanma.satirNo &&
                    this.boyanma.baskiId &&
                    this.boyanma.profilId &&
                    this.boyanma.adet
                ) {
                    this.boyanmaData = true
                } else this.boyanmaData = false;
            }

        }

    }
);


$('#boyanma_sepet').on("change", async function () {

    if ($(this).val() && $(this).val().length > 0) {

        let array = $(this).val().split(";");

        boyaGiris.boyanma.sepetId = array[0];
        boyaGiris.boyanma.satirNo = array[1];
        boyaGiris.boyanma.baskiId = array[2];
        boyaGiris.boyanma.profilId = array[3];
        boyaGiris.dataKontrol();
    }

});

$('#boya_siklon_giris').on("change", async function () {


    if ($(this).val() && $(this).val().length > 0) {
        boyaGiris.siklonId = $(this).val();
    } else {

        boyaGiris.siklonId = 0;

    }

});

$('#boya_rutus_id').on("change", async function () {


    if ($(this).val() && $(this).val().length > 0) {
        boyaGiris.rutusId = $(this).val();
    } else {

        boyaGiris.rutusId = 0;
    }

});


$('#boyanma_sepet').select2({});
$('#boya_siklon_giris').select2({});
$('#boya_rutus_id').select2({});
