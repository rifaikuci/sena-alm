new Vue({
        el: "#kalip-giris",
        data: {
            prefix:"",
            parcalar: [
                {id: 0, name: "Zıvana", type: "koprulu", prefix: "KZ"},
                {id: 1, name: "Kapak", type: "koprulu", prefix: "KK"},
                {id: 2, name: "Destek", type: "koprulu", prefix: "KD"},
                {id: 3, name: "Zıvana", type: "bindirmeli", prefix: "BZ"},
                {id: 4, name: "Kapak", type: "bindirmeli", prefix: "BK"},
                {id: 5, name: "Destek", type: "bindirmeli", prefix: "BD"},
                {id: 6, name: "Hazne", type: "solid", prefix: "SH"},
                {id: 7, name: "Kalıp", type: "solid", prefix: "SK"},
                {id: 8, name: "Destek", type: "solid", prefix:  "SD"},
                {id: 9, name: "Hazneli Kalıp", type: "hazneli-solid",prefix: "HK"},
                {id: 10, name: "Destek", type: "hazneli-solid", prefix: "HD"},
            ],
            caplar: [
                {id: 160},
                {id: 170},
                {id: 180},
                {id: 220}],
            filterParca: []
        },


        methods: {
            onChangeKalipCins(event) {
                if (event.target.value) {
                    this.caplar = [
                        {id: 160},
                        {id: 170},
                        {id: 180},
                        {id: 220}]
                    if (event.target.value == 0) {
                        this.filterParca = this.parcalar.filter(e => e.type == "koprulu" || !e.type)
                    } else if (event.target.value == 1) {
                        this.filterParca = this.parcalar.filter(e => e.type == "bindirmeli" || !e.type)
                    } else if (event.target.value == 2) {
                        this.filterParca = this.parcalar.filter(e => e.type == "solid" || !e.type)
                    } else if (event.target.value == 3) {
                        this.filterParca = this.parcalar.filter(e => e.type == "hazneli-solid" || !e.type)
                    }  else if (event.target.value == 4) {
                        this.filterParca = [];
                        this.caplar = this.caplar.filter(e=> e.id >= 220);
                    }
                } else {
                    this.filterParca = [];
                }
            },

            onChangeParca(event) {
                if (event.target.value) {
                    this.prefix = this.parcalar.find(e => e.id == event.target.value).prefix;
                } else {
                    this.prefix = "";
                }

            }
        }

    }
);