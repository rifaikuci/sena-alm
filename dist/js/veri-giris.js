new Vue({
        el: "#stok-giris",
        data: {
            biyetler: [],
            biyet: {
                partino: '',
                firmaId: '',
                alasimId: '',
                adetbiyet: '',
                cap: '',
                boy: ''
            },
            isFullBiyetData: false

        },
        methods: {
            biyetekle: function (event) {
                event.preventDefault();

                if(this.biyet.partino &&
                   this.biyet.firmaId &&
                   this.biyet.alasimId &&
                   this.biyet.adetbiyet &&
                   this.biyet.cap &&
                   this.biyet.boy ) {
                    this.biyetler.push(this.biyet);
                    console.log(this.biyetler)
                }


            },
            checkboy(event) {
                if (event.target.value &&
                    this.biyet.partino &&
                    this.biyet.firmaId &&
                    this.biyet.alasimId &&
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
                    this.biyet.firmaId &&
                    this.biyet.alasimId &&
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
                    this.biyet.firmaId &&
                    this.biyet.alasimId &&
                    this.biyet.partino &&
                    this.biyet.cap) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }
            }
        }

    }
);