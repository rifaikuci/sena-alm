
const formatter = new
    Intl.NumberFormat('de-DE', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});

var balyalamaGiris = new Vue({
    el: "#balyalama-giris", data: {
        anbarlar: [],
        toplamKilo: 0,
        anbarFilter: [],
        baskiIds: "",
        netAdets: "",
        netKilos: "",
        mtGrs: "",
        paketDetays: "",
        realToleranss: "",
        teorikToleranss: "",
        satirNos: "",
        anbarIds: "",
        siparisNos: "",
        musteriId : "",
        kontrolKilo: 0,
        balyaBoy : 0,
    },

    mounted: async function () {
        anbarlar = await axios.post('/sena/netting/balyalama/action.php', {
            action: 'anbargetir',
        }).then((response) => {
            return response.data
        });
        console.log(anbarlar);
        this.anbarlar = anbarlar.map(x => {
            return ({
                ...x,
                selected: false,
                netAdet: 0,
                netKilo: 0,
                mtGr: 0,
                paketDetay: "",
                realTolerans: 0,
                teorikTolerans: 0
            })
        })


    },

    methods: {
        bitir(event) {
            this.anbarFilter = this.anbarlar.filter(x => x.selected === true)

            this.anbarFilter.forEach(x => {
                this.musteriId = "";
                this.baskiIds = this.baskiIds + x.baskiId + ";";
                this.netAdets = this.netAdets + x.netAdet + ";";
                this.netKilos = this.netKilos + x.netKilo + ";";
                this.mtGrs = this.mtGrs + x.mtGr + ";";
                this.paketDetays = this.paketDetays + x.paketDetay + ";";
                this.realToleranss = this.realToleranss + x.realTolerans + ";";
                this.teorikToleranss = this.teorikToleranss + x.teorikTolerans + ";";
                this.satirNos = this.satirNos + x.satirNo + ";";
                this.anbarIds = this.anbarIds + x.id + ";";
                this.siparisNos = this.siparisNos + x.siparisNo + ";";
                this.musteriId = x.musteriId;
            })


            this.baskiIds = this.baskiIds.slice(0, -1);
            this.netAdets = this.netAdets.slice(0, -1);
            this.netKilos = this.netKilos.slice(0, -1);
            this.mtGrs = this.mtGrs.slice(0, -1);
            this.paketDetays = this.paketDetays.slice(0, -1);
            this.realToleranss = this.realToleranss.slice(0, -1);
            this.teorikToleranss = this.teorikToleranss.slice(0, -1);
            this.satirNos = this.satirNos.slice(0, -1);
            this.anbarIds = this.anbarIds.slice(0, -1);
            this.siparisNos = this.siparisNos.slice(0, -1);

        }, clickAnbar(event) {

            this.anbarFilter = this.anbarlar.filter(x => x.selected === true)
            if (this.anbarFilter.filter(x => x.id === event).length === 0) {
                musteriId = this.anbarlar.find(x => x.id === event).musteriId;

                if (this.anbarFilter.filter(x => x.musteriId != musteriId).length === 0) {
                    this.anbarlar.find(x => x.id === event).selected = true
                } else {
                    this.anbarlar = anbarlar.map(x => {
                        return ({
                            ...x,
                            selected: false,
                            netAdet: 0,
                            netKilo: 0,
                            mtGr: 0,
                            paketDetay: "",
                            realTolerans: 0,
                            teorikTolerans: 0
                        })
                    })
                    this.anbarlar.find(x => x.id === event).selected = true


                }
            } else {
                this.anbarlar.find(x => x.id === event).selected = false

            }
        },

        hesapla(event) {
            this.kontrolKilo = 0;
            this.toplamKilo = 0;
            item = this.anbarlar.find(x => x.id === event);
            if (item.netKilo && item.netKilo > 0 && item.netAdet && item.netAdet && item.boy && item.boy) {
                item.mtGr = ((item.netKilo / item.netAdet / item.boy) * 1000000).toFixed(1);

                item.teorikTolerans = (item.mtGr / item.gramaj).toFixed(2) * 100;
                item.teorikTolerans = (item.teorikTolerans - 100).toFixed(2);

                item.realTolerans = (item.mtGr / item.ortGramaj).toFixed(2) * 100;
                item.realTolerans = (item.realTolerans - 100).toFixed(2);

            }

            if (item.netAdet && item.netAdet > 0) {

                if (item.netAdet % item.pIA === 0) {
                    let tamPaket = item.netAdet / item.pIA
                    let yarimPaket = 0
                    let kalanAdet = 0
                    let toplamPaket = this.tamPaket;
                    let sonuc = tamPaket * item.pIA;
                    item.paketDetay = tamPaket + "X" + item.pIA + " = " + sonuc
                } else {
                    let kalanAdet = item.netAdet % item.pIA;
                    let kalanTam = item.netAdet - kalanAdet;
                    let tamPaket = kalanTam / item.pIA;
                    let yarimPaket = 1;
                    let toplamPaket = tamPaket + yarimPaket;
                    let sonuc = tamPaket * item.pIA;
                    item.paketDetay = tamPaket + "X" + item.pIA + " = " + sonuc + " , 1X" + kalanAdet + "=" + kalanAdet

                }
            }

            if (item.netKilo && item.netKilo > 0) {
                let filterAnbar = this.anbarlar.filter(x => x.selected === true)
                let kilo = 0;

                filterAnbar.forEach(x => {
                    kilo = parseFloat(kilo) + parseFloat(x.netKilo)
                });
                this.kontrolKilo = kilo;
                this.toplamKilo = formatter.format(kilo);
            }
        },

    }
});

