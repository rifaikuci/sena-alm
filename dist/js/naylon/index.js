var naylonGiris = new Vue({
        el: "#naylon-giris",
        data: {
            naylonlar : [],
            naylonlar2 : [],
            naylonDurum : 0,
            naylon1 : null,
            naylon2 : null,
            naylon1Max: 0,
            naylon2Max: 0,
            naylon1Adet: 0,
            naylon2Adet: 0,
            baskiId : 0,
            satirNo : 0,
            netAdet : 0,
        },
        methods: {
            check(event) {
                if(this.naylon1Adet && this.naylon1Adet > 0 && this.naylon1Max &&  parseFloat(this.naylon1Max) <= parseFloat(this.naylon1Adet)) {
                    this.naylonlar2 = this.naylonlar.filter(x => x.id != this.naylon1.id);
                    console.log(this.naylonlar2);
                }

            }

        }

    }
);

$('#naylon-select').on("change", async function () {

    if ($(this).val() && $(this).val().length > 0) {

        let array = $(this).val().split(";");
        naylonGiris.naylonDurum = array[2];
        naylonGiris.baskiId = array[0];
        naylonGiris.netAdet = array[1];

        const naylonlar = await axios.post('/sena/netting/naylon/action.php', {
            action: 'naylongetir',
            tur: naylonGiris.naylonDurum,
        }).then((res2) => {
            return res2.data
        });

        naylonGiris.naylonlar = naylonlar;

    } else {

        naylonGiris.naylonlar = [];
    }});

$('#naylon-select').select2({});

$('#naylon1-selected').on("change", async function () {


    if ($(this).val() && $(this).val().length > 0) {
        naylonGiris.naylon1 = naylonGiris.naylonlar.find(x => x.id == $(this).val() );
        naylonGiris.naylon1Max = naylonGiris.naylon1.kalan;
    } else  {
        naylonGiris.naylon1 = null;
        naylonGiris.naylon1Max =0;

    }
});

$('#naylon1-selected').select2({});

$('#naylon2-selected').on("change", async function () {


    if ($(this).val() && $(this).val().length > 0) {
        naylonGiris.naylon2 = naylonGiris.naylonlar2.find(x => x.id == $(this).val() );
        naylonGiris.naylon2Max = naylonGiris.naylon2.kalan;
    } else {
        naylonGiris.naylon2 = null;
        naylonGiris.naylon2Max =0;
    }
});

$('#naylon2-selected').select2({});


