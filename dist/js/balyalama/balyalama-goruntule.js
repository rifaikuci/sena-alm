var balyalamaGoruntule = new Vue({
    el: "#balyalama-goruntule", data: {
        balyalama: [],
        balyaNo: "balyaNo",
        balyaBoy :"0",
        balyaKilo :"0",
        tarih :"0",
        id : 0,
        selectedItem: null,

        balya: {
            id: 0,
            baskiId : 0,
            netAdet : 0,
            netKilo : 0,
            mtGr : 0,
            paketDetay : "",
            realTolerans : 0,
            teorikTolerans: 0,
            satirNo: "",
            siparisNo: ""
        }

    },

    mounted: async function () {

        this.id = $(this)[0]._vnode.data.attrs.id;
        let balyalama = await axios.post('/sena/netting/balyalama/action.php', {
            action: 'balyalamagetir',
            id: this.id
        }).then((response) => {
            return response.data
        });

        let baskiId = balyalama.baskiId.split(";");
        let netAdet = balyalama.netAdet.split(";");
        let netKilo = balyalama.netKilo.split(";");
        let mtGr = balyalama.mtGr.split(";");
        let paketDetay = balyalama.paketDetay.split(";");
        let realTolerans = balyalama.realTolerans.split(";");
        let teorikTolerans = balyalama.teorikTolerans.split(";");
        let satirNo = balyalama.satirNo.split(";");
        let siparisNo = balyalama.siparisNo.split(";");

        for(let i = 0; i< satirNo.length; i++) {
            this.balya= {
                id: i,
                    baskiId : 0,
                    netAdet : 0,
                    netKilo : 0,
                    mtGr : 0,
                    paketDetay : "",
                    realTolerans : 0,
                    teorikTolerans: 0,
                    satirNo: "",
                    siparisNo: ""
            }
            this.balya.baskiId  = baskiId[i];
            this.balya.netAdet  = netAdet[i];
            this.balya.netKilo  = netKilo[i];
            this.balya.mtGr  = mtGr[i];
            this.balya.id = i
            debugger;
            this.balya.paketDetay  = paketDetay[i];
            this.balya.realTolerans  = realTolerans[i];
            this.balya.teorikTolerans  = teorikTolerans[i];
            this.balya.satirNo  = satirNo[i];
            this.balya.siparisNo  = siparisNo[i];
            this.balyalama.push(this.balya)

        }
        console.log(this.balyalama)
        this.balyaNo = balyalama.balyaNo;
        this.balyaBoy = balyalama.balyaBoy;
        this.balyaKilo = balyalama.balyaKilo;
        this.tarih = balyalama.tarih;


    },

    methods: {
        clickAnbar(event) {
            debugger;
            if(!this.selectedItem || this.selectedItem.id != event) {
                this.selectedItem = this.balyalama.find(x => x.id === event);
            } else {
                this.selectedItem  = null
            }
        }
    }
});

