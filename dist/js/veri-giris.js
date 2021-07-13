new Vue({
        el: "#stok-giris",
        data: {
            biyetpartino: [],
            biyetfirma: [],
            biyetalasim: [],
            biyetadetbiyet: [],
            biyetcap: [],
            biyetboy: [],
            biyetler: [],
            biyet: {
                partino: '',
                firma: '',
                alasim: '',
                adetbiyet: '',
                cap: '',
                boy: ''
            },
            isFullBiyetData: false
        },
        methods: {
            biyetekle: function (event) {
                event.preventDefault();

                if (this.biyet.partino &&
                    this.biyet.firma &&
                    this.biyet.alasim &&
                    this.biyet.adetbiyet &&
                    this.biyet.cap &&
                    this.biyet.boy) {

                    this.biyetler.push(this.biyet);

                    this.biyetpartino.push(this.biyet.partino);
                    this.biyetfirma.push(this.biyet.firma);
                    this.biyetalasim.push(this.biyet.alasim);
                    this.biyetadetbiyet.push(this.biyet.adetbiyet);
                    this.biyetcap.push(this.biyet.cap);
                    this.biyetboy.push(this.biyet.boy);

                    isFullBiyetData: false
                    this.biyet = {
                        partino: '',
                        firma: '',
                        alasim: '',
                        adetbiyet: '',
                        cap: '',
                        boy: ''
                    }
                }


            },
            checkboy(event) {
                if (event.target.value &&
                    this.biyet.partino &&
                    this.biyet.firma &&
                    this.biyet.alasim &&
                    this.biyet.adetbiyet &&
                    this.biyet.cap) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }

            },
            checkpartino(event) {
                if (event.target.value &&
                    this.biyet.boy &&
                    this.biyet.firma &&
                    this.biyet.alasim &&
                    this.biyet.adetbiyet &&
                    this.biyet.cap) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }

            },
            checkadetbiyet(event) {
                if (event.target.value &&
                    this.biyet.boy &&
                    this.biyet.firma &&
                    this.biyet.alasim &&
                    this.biyet.partino &&
                    this.biyet.cap) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }
            },
            biyetSil: function (index) {
                this.$delete(this.biyetler, index)
            }

        }

    }
);