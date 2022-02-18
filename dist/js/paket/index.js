var paketGiris = new Vue({
        el: "#paket-giris",
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
            sepetAlinanAdet: 0,
            netAdet: 0,
            paketIcAdet: 0,
            korumaBandiId: "",
            korumaBandiAd: "",
            araKagitId: "",
            araKagitAd: "",
            confirmContent: "",
            kesimId: 0,
            baskiId: 0,
            profilId: 0,
            boyaId: 0,
            tamPaket: 0,
            yarimPaket: 0,
            toplamPaket: 0,
            kalanAdet: 0,
            sepetId: 0,
            sepetAdet: 0,


        },
        methods: {
            netAdetCalculate() {
                this.hurdaAdet = this.hurdaAdet ? this.hurdaAdet : 0;
                this.rutusAdet = this.rutusAdet ? this.rutusAdet : 0;
                this.sepetAlinanAdet = this.sepetAlinanAdet ? this.sepetAlinanAdet : 0;
                this.netAdet = this.sepetAlinanAdet - this.rutusAdet - this.hurdaAdet;

                if (this.netAdet % this.paketIcAdet === 0) {
                    this.tamPaket = this.netAdet / this.paketIcAdet
                    this.yarimPaket = 0
                    this.kalanAdet = 0
                    this.toplamPaket = this.tamPaket;
                } else {
                    this.kalanAdet = this.netAdet % this.paketIcAdet;
                    let kalanTam = this.netAdet - this.kalanAdet;
                    this.tamPaket = kalanTam / this.paketIcAdet;
                    this.yarimPaket = 1;
                    this.toplamPaket = this.tamPaket + this.yarimPaket;
                }

            },
            async bitir(event) {
                if (this.araKagitId == 1 && (this.korumaBandiId == 1 || this.korumaBandiId == 2) && this.satirNo) {
                    this.confirmContent = await confirm("Ara Kağıt ve koruma Bandı yerleştirildi mi ?")
                    if (!this.confirmContent) {
                        event.preventDefault();
                    }
                } else if (this.araKagitId == 1 && !(this.korumaBandiId == 1 || this.korumaBandiId == 2) && this.satirNo) {
                    this.confirmContent = confirm("Ara Kağıt yerleştirildi mi ?")
                    if (!this.confirmContent) {
                        event.preventDefault();
                    }
                } else if (this.araKagitId == 0 && (this.korumaBandiId == 1 || this.korumaBandiId == 2) && this.satirNo) {
                    this.confirmContent = confirm("Koruma Bandı yerleştirildi mi ?")
                    if (!this.confirmContent) {
                        event.preventDefault();
                    }
                } else if (this.araKagitId == 0 && !(this.korumaBandiId == 1 || this.korumaBandiId == 2) && this.satirNo) {
                    this.confirmContent = confirm("Paketleme işlemi kapatılıyor ?")
                    if (!this.confirmContent) {
                        event.preventDefault();
                    }
                } else {
                    this.confirmContent = confirm("Verileri Doldurunuz ?")
                    event.preventDefault();
                }
            }
        }

    }
);

$('#paket-giris-select').on("change", async function () {


    let array = $(this).val().split(";");
    paketGiris.sepetId = array[0];
    paketGiris.kesimId = array[1];
    paketGiris.sepetAdet = array[2];

    console.log(paketGiris.sepetId);
    const selectedRow = await axios.post('/sena/netting/paket/action.php', {
        action: 'siparisgetir',
        id: paketGiris.kesimId,
    }).then((response) => {
        return response.data
    });

    if (selectedRow && array != "0") {
        paketGiris.siparisId = selectedRow.siparisId;
        paketGiris.satirNo = selectedRow.satirNo;
        paketGiris.musteriAd = selectedRow.musteriAd;
        paketGiris.profil = selectedRow.profil;
        paketGiris.profilId = selectedRow.profilId;
        paketGiris.alasim = selectedRow.alasim;
        paketGiris.tolerans = selectedRow.tolerans;
        paketGiris.boy = selectedRow.boy;
        paketGiris.kg = selectedRow.kg;
        paketGiris.adet = selectedRow.adet;
        paketGiris.paketAciklama = selectedRow.paketAciklama;
        paketGiris.biyetBirimGramaj = selectedRow.biyetBirimGramaj;
        paketGiris.basilanKilo = selectedRow.basilanKilo;
        paketGiris.basilanAdet = selectedRow.basilanAdet;
        paketGiris.kiloAdet = selectedRow.kiloAdet;
        paketGiris.kalanKg = selectedRow.kalanKg;
        paketGiris.paketIcAdet = selectedRow.paketIcAdet;
        paketGiris.araKagitId = selectedRow.araKagit;
        paketGiris.araKagitAd = selectedRow.araKagit == 1 ? "Var" : "Yok";
        paketGiris.baskiId = selectedRow.baskiId;
        paketGiris.korumaBandiId = selectedRow.korumaBandiId;
        paketGiris.korumaBandiAd =  selectedRow.korumaBandiId == 1 ? "Baskılı" :
            selectedRow.korumaBandiId== 2 ? "Baskısız" :  selectedRow.korumaBandiId == 3 ? "Yok" : "";
        paketGiris.isSelected = true;

    } else {
        paketGiris.isSelected = false;
    }
    paketGiris.netAdetCalculate();

});

$('#paket-giris-select').select2({});



