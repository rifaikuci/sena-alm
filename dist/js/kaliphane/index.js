var kalipDetay = new Vue({
    el: "#kaliphane-goster",
    data: {
        takimId: 0,
        P: true,
        R1: true,
        K1: true,
        K2: true,
        K3: true,
        T1: true,
        T2: true,
        T3: true,
        T4: true,
        T5: true,
        T6: true,
        T7: true,
        N1: true,
        N2: true,
        N3: true,
        N4: true,
        N5: true,
        N6: true,
        kaliplar: [],
        filter: []
    },

    mounted: async function () {
        this.takimId = $(this)[0]._vnode.data.attrs.takim;

        kalip = await axios.post('/sena/netting/kaliphane/action.php', {
            action: 'kalipgetir',
            takimId: this.takimId
        }).then((response) => {
            return response.data
        });
        this.kaliplar = kalip;
        this.filter = kalip
        this.array = ['P', 'R1', 'K1', 'K2',
            'K3', 'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'N1', 'N2', 'N3', 'N4', 'N5', 'N6']
        this.konumlar = ['P', 'R1', 'K1', 'K2',
            'K3', 'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'N1', 'N2', 'N3', 'N4', 'N5', 'N6']


    },

    methods: {
        degistir(event) {
            let deger = event.target.defaultValue;
            this.konumlar.forEach(x => {
                if (x == deger) {
                    if (!this[x]) {
                        this.array.push(x)
                        this[x] = !this[x];
                    } else {
                        this[x] = !this[x];
                        this.array = this.array.filter(x => x != deger)
                    }
                }
            })
            this.filter = this.kaliplar.filter(x => this.array.includes(x.newProcess))

        }
    }
})