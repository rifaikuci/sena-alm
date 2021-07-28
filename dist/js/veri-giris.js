new Vue({
        el: "#stok-giris",
        data: {
            responseprofil: [],
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
            isFullBiyetData: false,


            malzemepartino: [],
            malzemefirma: [],
            malzemeadet: [],
            malzememalzeme: [],
            malzemeler: [],
            malzeme: {
                partino: '',
                firma: '',
                malzemeadet: '',
                malzeme: ''
            },
            isFullMalzemeData: false,

            profilfirma: [],
            profilmusteri: [],
            profilprofil: [],
            profiladet: [],
            profilboy: [],
            profilpaketAdet: [],
            profiltur: [],
            profilgelis: [],
            profiller: [],
            profil: {
                firma: '',
                musteri: '',
                profil: '',
                adet: '',
                boy: '',
                paketAdet: '',
                tur: '',
                gelis: '',
                resim: '',
            },
            isFullProfilData: false,
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
            },


            malzemeekle: function (event) {
                event.preventDefault();

                if (this.malzeme.partino &&
                    this.malzeme.firma &&
                    this.malzeme.malzeme &&
                    this.malzeme.adet) {

                    this.malzemeler.push(this.malzeme);

                    this.malzemepartino.push(this.malzeme.partino);
                    this.malzemefirma.push(this.malzeme.firma);
                    this.malzememalzeme.push(this.malzeme.malzeme);
                    this.malzemeadet.push(this.malzeme.adet);

                    this.isFullMalzemeData = false
                    this.malzeme = {
                        partino: '',
                        firma: '',
                        malzeme: '',
                        adet: ''
                    }
                }


            },

            checkmalzemepartino(event) {
                if (event.target.value &&
                    this.malzeme.partino &&
                    this.malzeme.firma &&
                    this.malzeme.malzeme &&
                    this.malzeme.adet) {
                    this.isFullMalzemeData = true;
                } else {
                    this.isFullMalzemeData = false;
                }
            },

            checkmalzemeadet(event) {
                if (event.target.value &&
                    this.malzeme.partino &&
                    this.malzeme.firma &&
                    this.malzeme.malzeme &&
                    this.malzeme.adet) {
                    this.isFullMalzemeData = true;
                } else {
                    this.isFullMalzemeData = false;
                }
            },

            malzemeSil: function (index) {
                this.$delete(this.malzemeler, index);
                this.isFullMalzemeData = false;
            },

            profilekle: async function (event) {
                event.preventDefault();

                const data = await axios.post('/sena/netting/action.php', {
                    action: 'profilId',
                    id: this.profil.profil
                }).then((response) => {
                    return response.data
                });
                this.profil.resim = data.resim;

                if (this.profil.firma &&
                    this.profil.musteri &&
                    this.profil.profil &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis &&
                    this.profil.adet) {

                    this.profiller.push(this.profil);

                    this.profilfirma.push(this.profil.firmafirma);
                    this.profilmusteri.push(this.profil.musteri);
                    this.profilprofil.push(this.profil.profil);
                    this.profiladet.push(this.profil.adet);
                    this.profilboy.push(this.profil.boy);
                    this.profilpaketAdet.push(this.profil.paketAdet);
                    this.profiltur.push(this.profil.tur);
                    this.profilgelis.push(this.profil.gelis);
                    this.isFullProfilData = false
                    this.profil = {
                        firma: '',
                        musteri: '',
                        profil: '',
                        adet: '',
                        boy: '',
                        paketAdet: '',
                        tur: '',
                        gelis: '',
                        resim: ''
                    }
                }


            },

            checkprofilboy(event) {
                if (event.target.value &&
                    this.profil.firma &&
                    this.profil.musteri &&
                    this.profil.profil &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis) {
                    this.isFullProfilData = true;
                } else {
                    this.isFullProfilData = false;
                }
            },

            checkprofiladet(event) {
                if (event.target.value &&
                    this.profil.firma &&
                    this.profil.musteri &&
                    this.profil.profil &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis) {
                    this.isFullProfilData = true;
                } else {
                    this.isFullProfilData = false;
                }
            },

            checkprofilpaketAdet(event) {
                if (event.target.value &&
                    this.profil.firma &&
                    this.profil.musteri &&
                    this.profil.profil &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis) {
                    this.isFullProfilData = true;
                } else {
                    this.isFullProfilData = false;
                }
            },

            profilSil: function (index) {
                this.$delete(this.profiller, index);
                this.isFullProfilData = false;
            },

            fetchData: function (id) {

            }

        }

    }
);