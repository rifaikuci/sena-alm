var boyaPaketGiris = new Vue({
        el: "#boya-paket",
        data: {
            isSelected: false,
            satirNo: "",
            musteriAd: "",
            profil: "",
            alasim: "",
            tolerans: "",
            boy: "",
            kg: "",
            adet: "",
            paketAciklama: "",
            biyetBirimGramaj: "",
            basilanKilo: "",
            basilanAdet: "",
            kiloAdet: "",
            kalanKg: "",
            siparisId: "",
            hurdaAdet: 0,
            rutusAdet: 0,
            topAdet: 0,
            netAdet: 0,
            paketIcAdet: 0,
            korumaBandiId: "",
            korumaBandiAd: ""

        },
        methods: {
            netAdetCalculate() {
                this.hurdaAdet = this.hurdaAdet ? this.hurdaAdet : 0;
                this.rutusAdet = this.rutusAdet ? this.rutusAdet : 0;
                this.topAdet = this.topAdet ? this.topAdet : 0;
                this.netAdet = this.topAdet - this.rutusAdet - this.hurdaAdet;

            }
        }

    }
);

$('#boya-paket-giris').on("change", async function () {


    let array = $(this).val().split(";");
    let siparisId = array[2];
    boyaPaketGiris.topAdet = array[3];
    boyaPaketGiris.korumaBandiId = array[4];
    boyaPaketGiris.korumaBandiAd = boyaPaketGiris.korumaBandiId == 1 ? "Baskılı" :
        boyaPaketGiris.korumaBandiId == 2 ? "Baskısız" : boyaPaketGiris.korumaBandiId == 3 ? "Yok" : "";

    const selectedRow = await axios.post('/sena/netting/boyapaket/action.php', {
        action: 'siparisgetir',
        id: siparisId,
    }).then((response) => {
        return response.data
    });

    if (selectedRow && array != "0") {
        boyaPaketGiris.siparisId = $(this).val();
        boyaPaketGiris.isSelected = true;
        boyaPaketGiris.satirNo = selectedRow.satirNo;
        boyaPaketGiris.musteriAd = selectedRow.musteriAd;
        boyaPaketGiris.profil = selectedRow.profil;
        boyaPaketGiris.alasim = selectedRow.alasim;
        boyaPaketGiris.tolerans = selectedRow.tolerans;
        boyaPaketGiris.boy = selectedRow.boy;
        boyaPaketGiris.kg = selectedRow.kg;
        boyaPaketGiris.adet = selectedRow.adet;
        boyaPaketGiris.paketAciklama = selectedRow.paketAciklama;
        boyaPaketGiris.biyetBirimGramaj = selectedRow.biyetBirimGramaj;
        boyaPaketGiris.basilanKilo = selectedRow.basilanKilo;
        boyaPaketGiris.basilanAdet = selectedRow.basilanAdet;
        boyaPaketGiris.kiloAdet = selectedRow.kiloAdet;
        boyaPaketGiris.kalanKg = selectedRow.kalanKg;
        boyaPaketGiris.paketIcAdet = selectedRow.paketIcAdet;

    } else {
        boyaPaketGiris.isSelected = false;
    }
    boyaPaketGiris.netAdetCalculate();

});

$('#boya-paket-giris').select2({});



