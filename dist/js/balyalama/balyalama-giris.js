var balyalamaGiris = new Vue({
        el: "#balyalama-giris",
        data: {
            anbarlar: [],
            ids: "",
            baskilar: "",
            anbarFilter: []
        },

        mounted: async function () {

            anbarlar = await axios.post('/sena/netting/balyalama/action.php', {
                action: 'anbargetir',
            }).then((response) => {
                return response.data
            });
            this.anbarlar = anbarlar.map(x => {
                    return ({
                        ...x,
                        selected: false,
                        netAdet: 0,
                        netKilo: 0,
                        mtGr: 0,
                        paketDetay: ""
                    })
                }
            )

            console.log(this.anbarlar);


        },

        methods: {
            bitir(event) {
                this.ids = "";
                this.anbarlar.forEach(x => {
                    if (x.selected === true) {
                        this.ids = this.ids + x.id + ";";
                        this.baskilar = this.baskilar + x.baskiId + ";";
                    }
                })
                this.ids = this.ids.slice(0, -1);
                this.baskilar = this.baskilar.slice(0, -1);

            },
            clickAnbar(event) {

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
                                    paketDetay: ""
                                })
                            }
                        )
                        this.anbarlar.find(x => x.id === event).selected = true


                    }
                } else {
                    this.anbarlar.find(x => x.id === event).selected = false

                }
            },

            hesapla(event) {
                item = this.anbarlar.find(x => x.id === event);
                debugger;
                if (item.netKilo && item.netKilo > 0 &&
                    item.netAdet && item.netAdet &&
                    item.boy && item.boy)
                    item.mtGr = item.netKilo / item.netAdet / item.boy
            }
        }


    }
);

