var kesimgiris = new Vue({
            el: "#kesim-giris",
            data: {
                sepetler1: [],
                sepetler2: [],
                sepetler3: [],
                isSepet1Dolu: false,
                isSepet2Dolu: false,
                isSepet3Dolu: false,
                sepet1Adet: 0,
                sepet2Adet: 0,
                sepet3Adet: 0,
                netAdet: 0,
                satirNo: "",
                kayitTarih: "",
                profil: "",
                istenilenBoy: "",
                siparisTur: "",
                istenilenTermik: "",
                baskiId: 0,
                basilanNetAdet: "",
                kesilenBoy: "",
                sepet1: 0,
                sepet2: 0,
                sepet3: 0,
                siparisId: 0,
                hurdaAdet: 0,
                adim: "",
                kesimFarkli: true,
                bitir : false,
                hurdaAdetKontrolHata : false,

            },

            mounted: async function () {

            },

            methods: {
                handleHurda($event) {
                    this.hurdaAdet = this.hurdaAdet ? this.hurdaAdet : "";
                    debugger;
                    if(this.hurdaAdet) {

                        if(Number(this.hurdaAdet )> 0 && Number(this.hurdaAdet) >= Number(this.basilanNetAdet))  {
                            this.hurdaAdetKontrolHata = true;
                        } else {
                            this.hurdaAdetKontrolHata = false;
                        }
                    } else {
                        this.hurdaAdetKontrolHata =  false;
                    }
                    this.hesapla($event);
                },
                kesimOranHesapla($event) {
                    this.kesimFarkli = true;
                    if (this.kesilenBoy && this.kesilenBoy > 0 && this.istenilenBoy && this.istenilenBoy > 0) {
                        this.kesilenBoy = parseFloat(this.kesilenBoy);
                        this.istenilenBoy = parseFloat(this.istenilenBoy);
                        if (this.kesilenBoy >= this.istenilenBoy && this.kesilenBoy <= this.istenilenBoy + 10) {
                            this.kesimFarkli = true;
                        } else  {
                            this.kesimFarkli = false;
                        }

                    } else {
                        this.kesimFarkli = true;
                    }
                },

                hesapla($event) {
                    this.sepet1Adet = this.sepet1Adet ? this.sepet1Adet : "";
                    this.sepet2Adet = this.sepet2Adet ? this.sepet2Adet : "";
                    this.sepet3Adet = this.sepet3Adet ? this.sepet3Adet : "";
                    this.hurdaAdet = this.hurdaAdet ? this.hurdaAdet : "";

                    let sepet1 = this.sepet1Adet ? this.sepet1Adet : 0;
                    let sepet2 = this.sepet2Adet ? this.sepet2Adet : 0;
                    let sepet3 = this.sepet3Adet ? this.sepet3Adet : 0;
                    let hurda = this.hurdaAdet ? this.hurdaAdet : 0;
                    this.netAdet = (Number(sepet1) + Number(sepet2) + Number(sepet3));
                    if(Number(sepet1) + Number(sepet2) + Number(sepet3) + Number(hurda) == Number(this.basilanNetAdet)) {
                        this.bitir = true;
                    } else {
                        this.bitir = false;
                    }


                }
            },

        }
    )
;

$('#kesim_baski_id').on("change", async function () {

    kesimgiris.sepetler1 = [];
    kesimgiris.sepetler2 = [];
    kesimgiris.sepetler3 = [];
    kesimgiris.baskiId = $(this).val();
    const response = await axios.post('/sena/netting/kesim/action.php', {
        action: 'baskigetir',
        id: kesimgiris.baskiId,
    }).then((response) => {
        return response.data
    });


    if (kesimgiris.baskiId) {
        kesimgiris.satirNo = response.satirNo;
        kesimgiris.profil = response.profil;
        kesimgiris.istenilenBoy = response.istenilenBoy;
        kesimgiris.siparisTur = response.siparisTur;
        kesimgiris.istenilenTermik = response.istenilenTermik;
        kesimgiris.basilanNetAdet = response.basilanNetAdet;
        kesimgiris.siparisId = response.siparisId;
        kesimgiris.kayitTarih = response.kayitTarih;

        if (kesimgiris.istenilenTermik == "Termiksiz") {

            if (kesimgiris.siparisTur == "Boyalı") {
                kesimgiris.adim = "kromat"
            } else {
                kesimgiris.adim = "araba"
            }
        } else {
            kesimgiris.adim = "termik"
        }


        const response2 = await axios.post('/sena/netting/kesim/action.php', {
            action: 'sepetgetir',
            tur: kesimgiris.adim,
        }).then((res2) => {
            return res2.data
        });
        kesimgiris.sepetler1 = response2;
        kesimgiris.sepetler2 = response2;
        kesimgiris.sepetler3 = response2;

    } else {
        this.baskiId = 0
    }


});

$('#kesim_sepet1').on("change", async function () {

    if ($(this).val()) {
        kesimgiris.sepet1 = $(this).val();
        kesimgiris.isSepet1Dolu = false;

        kesimgiris.sepetler2 = kesimgiris.sepetler1.filter(e => e.id != $(this).val())
    } else {
        kesimgiris.sepetler2 = kesimgiris.sepetler1;
    }
});


$('#kesim_baski_id').select2({});
$('#kesim_sepet1').select2({});

