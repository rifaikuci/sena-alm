new Vue({
        el: "#stok-giris",
        data: {

            boyapartino: [],
            boyafirma: [],
            boyaboya: [],
            boyaadet: [],
            boyakilo: [],
            boyasicaklik: [],
            boyacins: [],
            boyalar: [],
            boya: {
                partino: '',
                firma: '',
                boya: '',
                adet: '',
                kilo: '',
                sicaklik: '',
                cins: ''
            },
            isFullBoyaData: false,


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

                    this.isFullBiyetData = false;
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
                this.$delete(this.biyetler, index);
                this.isFullBiyetData = false;
            },


            boyaekle: function (event) {
                event.preventDefault();

                if (this.boya.partino &&
                    this.boya.firma &&
                    this.boya.boya &&
                    this.boya.adet &&
                    this.boya.kilo &&
                    this.boya.sicaklik &&
                    this.boya.cins) {

                    this.boyalar.push(this.boya);

                    this.boyapartino.push(this.boya.partino);
                    this.boyafirma.push(this.boya.firma);
                    this.boyaboya.push(this.boya.boya);
                    this.boyaadet.push(this.boya.adet);
                    this.boyakilo.push(this.boya.kilo);
                    this.boyasicaklik.push(this.boya.sicaklik);
                    this.boyacins.push(this.boya.cins);

                    this.isFullBoyaData = false
                    this.boya = {
                        partino: '',
                        firma: '',
                        boya: '',
                        adet: '',
                        kilo: '',
                        sicaklik: '',
                        cins: ''
                    }
                }


            },

            checkboyapartino(event) {
                if (event.target.value &&
                    this.boya.partino &&
                    this.boya.firma &&
                    this.boya.boya &&
                    this.boya.adet &&
                    this.boya.kilo &&
                    this.boya.sicaklik &&
                    this.boya.cins) {
                    this.isFullBoyaData = true;
                } else {
                    this.isFullBoyaData = false;
                }
            },

            checkboyaadet(event) {
                if (event.target.value &&
                    this.boya.partino &&
                    this.boya.firma &&
                    this.boya.boya &&
                    this.boya.adet &&
                    this.boya.kilo &&
                    this.boya.sicaklik &&
                    this.boya.cins) {
                    this.isFullBoyaData = true;
                } else {
                    this.isFullBoyaData = false;
                }
            },

            checkboyakilo(event) {
                if (event.target.value &&
                    this.boya.partino &&
                    this.boya.firma &&
                    this.boya.boya &&
                    this.boya.adet &&
                    this.boya.kilo &&
                    this.boya.sicaklik &&
                    this.boya.cins) {
                    this.isFullBoyaData = true;
                } else {
                    this.isFullBoyaData = false;
                }
            },

            boyaSil: function (index) {
                this.$delete(this.boyalar, index);
                this.isFullBoyaData = false;
            }

        }

    }
);