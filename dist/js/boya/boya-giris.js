var boyaGiris = new Vue({
        el: "#boya-giris",
        data: {
            maxAdet: 0,
            hurdaAdet: 0,
            rutusAdet: 0,
            topAdet: "",
            oran: "",
            ortAskiAdet: "",
            topAski: "",
            kullanilanBoya: 0,
            siklonKullanilanKg: 0,
            siklonAyrilanKg: 0,
            netBoya: 0,
            sepetId: 0,
            siklonId: 0,
            boyalar: [],
            firinSicaklik : 0,
            rutusId : 0,
            satirNo: 0,
            baskiId: 0,
            profilId: 0
        },


        methods: {
            changeTopAdet(event) {
                if (event.target.value && event.target.value > 0) {
                    this.topAdet = event.target.value;
                    if (this.maxAdet && this.maxAdet) {
                        this.oran =   this.topAdet / this.maxAdet;
                        this.oran =this.oran * 100
                        this.oran =  this.oran
                    } else {
                        this.oran = 0;
                    }

                    if (this.topAski && this.topAski > 0 && this.topAdet && this.topAdet > 0)
                        this.ortAskiAdet = this.topAski / this.topAdet
                    else
                        this.ortAskiAdet = 0
                } else {
                    this.oran = 0;
                }
            },

            changeTopAski(event) {
                if (event.target.value && event.target.value > 0) {
                    this.topAski = event.target.value;
                    if (this.topAski && this.topAski > 0 && this.topAdet && this.topAdet > 0)
                        this.ortAskiAdet = this.topAski / this.topAdet
                    else
                        this.ortAskiAdet = 0;
                }
            },

            changeBoya(event) {
                this.netBoya = parseInt(this.kullanilanBoya ? this.kullanilanBoya : 0) +
                    parseInt(this.siklonKullanilanKg ? this.siklonKullanilanKg : 0) -
                    parseInt(this.siklonAyrilanKg ? this.siklonAyrilanKg : 0)

            },

        }

    }
);


$('#boyanma_sepet').on("change", async function () {

    if ($(this).val() && $(this).val().length > 0) {

        let array = $(this).val().split(";");

        boyaGiris.sepetId = array[0];
        boyaGiris.maxAdet = array[1];
        boyaGiris.satirNo = array[2];
        boyaGiris.baskiId = array[3];
        boyaGiris.profilId = array[4];
        if (boyaGiris.topAdet && boyaGiris.topAdet > 0) {
            boyaGiris.oran = boyaGiris.maxAdet / boyaGiris.topAdet;
        }

    } else {

        boyaGiris.maxAdet = 0
        boyaGiris.oran = 0;
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

$('#boyanma_firin_sicaklik').on("change", async function () {

    boyaGiris.boyalar = []

    if ($(this).val() && $(this).val().length > 0) {
        boyaGiris.firinSicaklik = $(this).val();
        const response = await axios.post('/sena/netting/boya/action.php', {
            action: 'boyagetir',
            sicaklik : boyaGiris.firinSicaklik

        }).then((response2) => {
            return response2.data
        });

        boyaGiris.boyalar  = response;

    } else {

        boyaGiris.firinSicaklik = 0;
        boyaGiris.boyalar  = []

    }

});


$('#boyanma_sepet').select2({});
$('#boya_siklon_giris').select2({});
$('#boyanma_firin_sicaklik').select2({});
$('#boya_rutus_id').select2({});
