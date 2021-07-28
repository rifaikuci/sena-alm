new Vue({
        el: "#stok-giris",
        data: {
            //boyalar
            boyapartino: [],
            boyafirmaId: [],
            boyafirmaAd: [],
            boyaboyaId: [],
            boyaboyaAd: [],
            boyaadet: [],
            boyakilo: [],
            boyasicaklik: [],
            boyacins: [],
            boyalar: [],
            boya: {
                partino: '',
                firmaId: '',
                firmaAd: '',
                boyaId: '',
                boyaAd: '',
                adet: '',
                kilo: '',
                sicaklik: '',
                cins: ''
            },
            isFullBoyaData: false,


            //biyetler
            biyetpartino: [],
            biyetfirmaId: [],
            biyetfirmaAd: [],
            biyetalasimId: [],
            biyetalasimAd: [],
            biyetadetbiyet: [],
            biyetcap: [],
            biyetboy: [],
            biyetler: [],
            biyet: {
                partino: '',
                firmaId: '',
                firmaAd: '',
                alasimId: '',
                alasimAd: '',
                adetbiyet: '',
                cap: '',
                boy: ''
            },
            isFullBiyetData: false,


            //malzemeler
            malzemepartino: [],
            malzemefirmaId: [],
            malzemefirmaAd: [],
            malzemeadet: [],
            malzememalzemeId: [],
            malzememalzemeAd: [],
            malzemeler: [],
            malzeme: {
                partino: '',
                firmaId: '',
                firmaAd: '',
                malzemeadet: '',
                malzemeId: '',
                malzemeAd: ''
            },
            isFullMalzemeData: false,

            //profiller
            profilfirmaId: [],
            profilfirmaAd: [],
            profilmusteriId: [],
            profilmusteriAd: [],
            profilprofilId: [],
            profilprofilAd: [],
            profiladet: [],
            profilboy: [],
            profilpaketAdet: [],
            profiltur: [],
            profilgelis: [],
            profiller: [],
            profil: {
                firmaId: '',
                firmaAd: '',
                musteriId: '',
                musteriAd: '',
                profilId: '',
                profilAd: '',
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
            //biyetler method
            biyetekle: async function (event) {
                event.preventDefault();

                const firmabul = await axios.post('/sena/netting/action.php', {
                    action: 'firmaId',
                    id: this.biyet.firmaId
                }).then((response) => {
                    return response.data
                });


                const alasimbul = await axios.post('/sena/netting/action.php', {
                    action: 'alasimId',
                    id: this.biyet.alasimId
                }).then((response) => {
                    return response.data
                });
                this.biyet.firmaAd = firmabul.firmaAd;
                this.biyet.alasimAd = alasimbul.ad;


                if (this.biyet.partino &&
                    this.biyet.firmaId &&
                    this.biyet.alasimId &&
                    this.biyet.adetbiyet &&
                    this.biyet.cap &&
                    this.biyet.boy) {

                    this.biyetler.push(this.biyet);

                    this.biyetpartino.push(this.biyet.partino);
                    this.biyetfirmaId.push(this.biyet.firmaId);
                    this.biyetfirmaAd.push(this.biyet.firmaAd);
                    this.biyetalasimId.push(this.biyet.alasimId);
                    this.biyetalasimAd.push(this.biyet.alasimAd);
                    this.biyetadetbiyet.push(this.biyet.adetbiyet);
                    this.biyetcap.push(this.biyet.cap);
                    this.biyetboy.push(this.biyet.boy);
                    this.isFullBiyetData = false;
                    this.biyet = {
                        partino: '',
                        firmaId: '',
                        firmaAd: '',
                        alasimId: '',
                        alasimAd: '',
                        adetbiyet: '',
                        cap: '',
                        boy: ''
                    }
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

            },
            biyetSil: function (index) {
                this.$delete(this.biyetler, index);
                this.isFullBiyetData = false;
            },


            //boyalar method
            boyaekle: async function (event) {
                event.preventDefault();

                const firmabul = await axios.post('/sena/netting/action.php', {
                    action: 'firmaId',
                    id: this.boya.firmaId
                }).then((response) => {
                    return response.data
                });

                const boyabul = await axios.post('/sena/netting/action.php', {
                    action: 'boyaId',
                    id: this.boya.boyaId
                }).then((response) => {
                    return response.data
                });
                this.boya.firmaAd = firmabul.firmaAd;
                this.boya.boyaAd = boyabul.ad;


                if (this.boya.partino &&
                    this.boya.firmaId &&
                    this.boya.boyaId &&
                    this.boya.adet &&
                    this.boya.kilo &&
                    this.boya.sicaklik &&
                    this.boya.cins) {

                    this.boyalar.push(this.boya);

                    this.boyapartino.push(this.boya.partino);
                    this.boyafirmaId.push(this.boya.firmaId);
                    this.boyafirmaAd.push(this.boya.firmaAd);
                    this.boyaboyaId.push(this.boya.boyaId);
                    this.boyaboyaAd.push(this.boya.boyaAd);
                    this.boyaadet.push(this.boya.adet);
                    this.boyakilo.push(this.boya.kilo);
                    this.boyasicaklik.push(this.boya.sicaklik);
                    this.boyacins.push(this.boya.cins);

                    this.isFullBoyaData = false
                    this.boya = {
                        partino: '',
                        firmaId: '',
                        firmaAd: '',
                        boyaId: '',
                        boyaAd: '',
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
                    this.boya.firmaId &&
                    this.boya.boyaId &&
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
                    this.boya.firmaId &&
                    this.boya.boyaId &&
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
                    this.boya.firmaId &&
                    this.boya.boyaId &&
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


            //malzemeler method
            malzemeekle: async function (event) {
                event.preventDefault();

                const firmabul = await axios.post('/sena/netting/action.php', {
                    action: 'firmaId',
                    id: this.malzeme.firmaId
                }).then((response) => {
                    return response.data
                });

                const malzemebul = await axios.post('/sena/netting/action.php', {
                    action: 'malzemeId',
                    id: this.malzeme.malzemeId
                }).then((response) => {
                    return response.data
                });
                this.malzeme.firmaAd = firmabul.firmaAd;
                this.malzeme.malzemeAd = malzemebul.ad;

                if (this.malzeme.partino &&
                    this.malzeme.firmaId &&
                    this.malzeme.malzemeId &&
                    this.malzeme.adet) {

                    this.malzemeler.push(this.malzeme);

                    this.malzemepartino.push(this.malzeme.partino);
                    this.malzemefirmaId.push(this.malzeme.firmaId);
                    this.malzemefirmaAd.push(this.malzeme.firmaAd);
                    this.malzememalzemeId.push(this.malzeme.malzemeId);
                    this.malzememalzemeAd.push(this.malzeme.malzemeAd);
                    this.malzemeadet.push(this.malzeme.adet);

                    this.isFullMalzemeData = false
                    this.malzeme = {
                        partino: '',
                        firmaId: '',
                        firmaIAd: '',
                        malzemeId: '',
                        malzemeAd: '',
                        adet: ''
                    }
                }


            },
            checkmalzemepartino(event) {
                if (event.target.value &&
                    this.malzeme.partino &&
                    this.malzeme.firmaId &&
                    this.malzeme.malzemeAd &&
                    this.malzeme.adet) {
                    this.isFullMalzemeData = true;
                } else {
                    this.isFullMalzemeData = false;
                }
            },
            checkmalzemeadet(event) {
                if (event.target.value &&
                    this.malzeme.partino &&
                    this.malzeme.firmaId &&
                    this.malzeme.malzemeId &&
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


            //profiller method
            profilekle: async function (event) {
                event.preventDefault();

                const data = await axios.post('/sena/netting/action.php', {
                    action: 'profilId',
                    id: this.profil.profilId
                }).then((response) => {
                    return response.data
                });
                this.profil.resim = data.resim;
                this.profil.profilAd = data.ad;


                const firmabul = await axios.post('/sena/netting/action.php', {
                    action: 'firmaId',
                    id: this.profil.firmaId
                }).then((response) => {
                    return response.data
                });

                this.profil.firmaAd = firmabul.firmaAd;

                const musteribul = await axios.post('/sena/netting/action.php', {
                    action: 'firmaId',
                    id: this.profil.musteriId
                }).then((response) => {
                    return response.data
                });

                this.profil.musteriAd = musteribul.firmaAd;

                if (this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis &&
                    this.profil.adet) {

                    this.profiller.push(this.profil);

                    this.profilfirmaId.push(this.profil.firmaId);
                    this.profilfirmaAd.push(this.profil.firmaAd);
                    this.profilmusteriId.push(this.profil.musteriId);
                    this.profilmusteriAd.push(this.profil.musteriAd);
                    this.profilprofilId.push(this.profil.profil);
                    this.profiladet.push(this.profil.adet);
                    this.profilboy.push(this.profil.boy);
                    this.profilpaketAdet.push(this.profil.paketAdet);
                    this.profiltur.push(this.profil.tur);
                    this.profilgelis.push(this.profil.gelis);
                    this.isFullProfilData = false
                    this.profil = {
                        firmaId: '',
                        firmaAd: '',
                        musteriId: '',
                        musteriAd: '',
                        profilId: '',
                        profilAd: '',
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
                    this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
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
                    this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
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
                    this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
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


        }

    }
);