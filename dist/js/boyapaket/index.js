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
            korumaBandiAd: "",
            araKagitId : "",
            araKagitAd: "",
            confirmContent : "",
            kesimId : 0,
            baskiId: 0,
            profilId: 0,
            boyaId: 0,
            tamPaket : 0,
            yarimPaket: 0,
            toplamPaket : 0,
            kalanAdet : 0


        },
        methods: {
            netAdetCalculate() {
                this.hurdaAdet = this.hurdaAdet ? this.hurdaAdet : 0;
                this.rutusAdet = this.rutusAdet ? this.rutusAdet : 0;
                this.topAdet = this.topAdet ? this.topAdet : 0;
                this.netAdet = this.topAdet - this.rutusAdet - this.hurdaAdet;

                if(this.netAdet % this.paketIcAdet === 0 ) {
                    this.tamPaket =  this.netAdet / this.paketIcAdet
                    this.yarimPaket = 0
                    this.kalanAdet = 0
                    this.toplamPaket = this.tamPaket;
                } else {
                     this.kalanAdet= this.netAdet % this.paketIcAdet;
                    let kalanTam = this.netAdet - this.kalanAdet;
                    this.tamPaket = kalanTam / this.paketIcAdet;
                    this.yarimPaket = 1;
                    this.toplamPaket = this.tamPaket + this.yarimPaket;
                }

            },
           async bitir (event) {
                if(this.araKagitId == 1 && (this.korumaBandiId == 1 || this.korumaBandiId == 2) &&  this.satirNo ) {
                     this.confirmContent =  await confirm("Ara Kağıt ve koruma Bandı yerleştirildi mi ?")
                    if(!this.confirmContent ) {
                        event.preventDefault();
                    }
                } else if (this.araKagitId == 1 && !(this.korumaBandiId == 1 || this.korumaBandiId == 2) && this.satirNo  ){
                    this.confirmContent = confirm("Ara Kağıt yerleştirildi mi ?")
                    if(!this.confirmContent) {
                        event.preventDefault();
                    }
                } else if (this.araKagitId == 0 && (this.korumaBandiId == 1 || this.korumaBandiId == 2) && this.satirNo  ){
                    this.confirmContent = confirm("Koruma Bandı yerleştirildi mi ?")
                    if(!this.confirmContent) {
                        event.preventDefault();
                    }
                } else if (this.araKagitId == 0 && !(this.korumaBandiId == 1 || this.korumaBandiId == 2) && this.satirNo  ){
                    this.confirmContent = confirm("Paketleme işlemi kapatılıyor ?")
                    if(!this.confirmContent) {
                        event.preventDefault();
                    }
                } else  {
                    this.confirmContent = confirm("Verileri Doldurunuz ?")
                    event.preventDefault();
                }
            }
        }

    }
);

$('#boya-paket-giris').on("change", async function () {


    let array = $(this).val().split(";");
    let siparisId = array[2];
    boyaPaketGiris.topAdet = array[3];
    boyaPaketGiris.kesimId = array[0];
    boyaPaketGiris.baskiId = array[1];
    boyaPaketGiris.korumaBandiId = array[4];
    boyaPaketGiris.boyaId = array[5];
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
        boyaPaketGiris.profilId = selectedRow.profilId;
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
        boyaPaketGiris.araKagitId = selectedRow.araKagit;
        boyaPaketGiris.araKagitAd = selectedRow.araKagit == 1 ? "Var" : "Yok";


    } else {
        boyaPaketGiris.isSelected = false;
    }
    boyaPaketGiris.netAdetCalculate();

});

$('#boya-paket-giris').select2({});



