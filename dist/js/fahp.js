new Vue({
        el: "#fahp",
        data: {
            veriKriter: '',
            kriter: [],
            veriKrier_is_hata: false
        },

        methods: {
            kriterEkle: function (event) {
                event.preventDefault();

                if (this.veriKriter != "") {
                    this.kriter.push(this.veriKriter);
                    this.veriKriter_is_hata = false;
                    this.veriKriter = "";
                } else {
                    this.veriKriter_is_hata = true;
                }
            },

            kriterSil: function (index) {
                this.$delete(this.kriter, index)
            },
        }
    }
);