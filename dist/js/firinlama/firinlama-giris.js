var firinlamaGiris = new Vue({
        el: "#firinlama-giris",
        data: {
            boyalar: [],
            ids: "",
            baskilar: "",
        },

        mounted: async function () {

            boyalar = await axios.post('/sena/netting/firinlama/action.php', {
                action: 'boyagetir',
            }).then((response) => {
                return response.data
            });
            this.boyalar = boyalar.map(x => {
                    return ({
                        ...x,
                        selected: false
                    })
                }
            )

        },

        methods: {
            bitir(event) {
                this.ids = "";
                this.boyalar.forEach(x => {
                    if (x.selected === true) {
                        this.ids = this.ids + x.id + ";";
                        this.baskilar = this.baskilar + x.baskiId + ";";
                    }
                })
                this.ids = this.ids.slice(0, -1);
                this.baskilar = this.baskilar.slice(0, -1);

            }
        }


    }
);

