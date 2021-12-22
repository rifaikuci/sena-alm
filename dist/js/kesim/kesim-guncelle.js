var kesimguncelle = new Vue({
        el: "#kesim-guncelle",
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
            kesimId: 0,
            hurdaAdet: 0,
            eskiHurdaAdet: 0,
            aciklama: '',
            baskilar: [],
            adim: ""

        },

        mounted: async function () {

            this.kesimId = $(this)[0]._vnode.data.attrs.kesim;
            const kesim = await axios.post('/sena/netting/kesim/action.php', {
                action: 'kesimgetir',
                id: this.kesimId
            }).then((response) => {
                return response.data
            });


            this.sepetler1 = kesim.sepetler
            this.sepetler2 = kesim.sepetler
            this.sepetler3 = kesim.sepetler
            this.sepet1Adet = parseInt(kesim.sepet1Adet)
            this.sepet2Adet = parseInt(kesim.sepet2Adet)
            this.sepet3Adet = parseInt(kesim.sepet3Adet)
            this.netAdet = kesim.netAdet
            this.satirNo = kesim.satirNo
            this.profil = kesim.profil
            this.istenilenBoy = kesim.istenilenBoy
            this.siparisTur = kesim.siparisTur
            this.istenilenTermik = kesim.istenilenTermik
            this.baskiId = kesim.baskiId
            this.basilanNetAdet = kesim.basilanNetAdet
            this.kesilenBoy = kesim.kesilenBoy
            this.sepet1 = parseInt(kesim.sepet1)
            this.sepet2 = parseInt(kesim.sepet2)
            this.sepet3 = parseInt(kesim.sepet3)
            this.siparisId = kesim.siparisId
            this.kesimId = kesim.id
            this.hurdaAdet = kesim.hurdaAdet
            this.eskiHurdaAdet = kesim.hurdaAdet
            this.aciklama = kesim.aciklama
            this.baskilar = kesim.baskilar

            if(this.istenilenTermik  == "Termiksiz") {

                if(this.siparisTur == "Boyalı") {
                    this.adim = "kromat"
                } else {
                    this.adim = "araba"
                }
            } else {
                this.adim = "termik"
            }

            if (this.sepet1) {
                isSepet1Dolu = this.sepetler1.find(x => x.id == this.sepet1).durum
                this.isSepet1Dolu = isSepet1Dolu == 1 ? true : false

                this.sepetler2 = this.sepetler1.filter(e => e.id != this.sepet1)
            }

            if (this.sepet2) {
                isSepet2Dolu = this.sepetler2.find(x => x.id == this.sepet2).durum
                this.isSepet2Dolu = isSepet2Dolu == 1 ? true : false

                this.sepetler3 = this.sepetler2.filter(e => e.id != this.sepet2)
            }


        },

        methods: {}
    }
);

$('#kesim_baski_guncelle_id').on("change", async function () {

    kesimguncelle.baskiId = $(this).val();
    const response = await axios.post('/sena/netting/kesim/action.php', {
        action: 'baskigetir',
        id: kesimguncelle.baskiId,
    }).then((response) => {
        return response.data
    });


    if (kesimguncelle.baskiId) {
        kesimguncelle.satirNo = response.satirNo;
        kesimguncelle.profil = response.profil;
        kesimguncelle.istenilenBoy = response.istenilenBoy;
        kesimguncelle.siparisTur = response.siparisTur;
        kesimguncelle.istenilenTermik = response.istenilenTermik;
        kesimguncelle.basilanNetAdet = response.basilanNetAdet;
        kesimguncelle.siparisId = response.siparisId;

    } else {
        this.baskiId = 0
    }


});

$('#kesim_sepet_guncelle1').on("change", async function () {

    if ($(this).val()) {
        kesimguncelle.sepet1 = $(this).val();
        kesimguncelle.isSepet1Dolu = false;

        kesimguncelle.sepetler2 = kesimguncelle.sepetler1.filter(e => e.id != $(this).val())
    } else {
        kesimguncelle.sepetler2 = kesimguncelle.sepetler1;
    }
});


$('#kesim_baski_guncelle_id').select2({});
$('#kesim_sepet_guncelle1').select2({});

