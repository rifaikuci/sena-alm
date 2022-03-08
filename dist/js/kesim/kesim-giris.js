var kesimgiris = new Vue({
        el: "#kesim-giris",
        data: {
            sepetler1: [],
            sepetler2: [],
            sepetler3: [],
            isSepet1Dolu : false,
            isSepet2Dolu : false,
            isSepet3Dolu : false,
            sepet1Adet: 0,
            sepet2Adet: 0,
            sepet3Adet: 0,
            netAdet: 0,
            satirNo: "",
            kayitTarih : "",
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
            adim: ""

        },

        mounted: async function () {

        },

        methods: {

        }
    }
);

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

        if(kesimgiris.istenilenTermik  == "Termiksiz") {

            if(kesimgiris.siparisTur == "Boyalı") {
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

        console.log(response2)

        kesimgiris.sepetler1 = response2;
        kesimgiris.sepetler2 = response2;
        kesimgiris.sepetler3 = response2;

    } else {
       this.baskiId = 0
    }


});

$('#kesim_sepet1').on("change", async function () {

    if($(this).val()) {
        kesimgiris.sepet1=$(this).val();
        kesimgiris.isSepet1Dolu = false;

        kesimgiris.sepetler2 = kesimgiris.sepetler1.filter(e=> e.id != $(this).val() )
    } else {
        kesimgiris.sepetler2 = kesimgiris.sepetler1;
    }
});




$('#kesim_baski_id').select2({});
$('#kesim_sepet1').select2({});

