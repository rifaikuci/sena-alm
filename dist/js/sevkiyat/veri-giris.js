var biyetFirmaId = "";
var boyaFirmaId = "";
var boyaTur = "";
var malzemeFirmaId = "";
var sevkiyatProfilId = "";
var sevkiyatGeldigiFirma = "";
var sevkiyatMusteriId = "";
var alasimlar = [];


var veri = new Vue({
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
                cins: '',
                toplamkilo: ''
            },
            isFullBoyaData: false,


            //biyetler
            biyetpartino: [],
            biyetfirmaId: [],
            biyetfirmaAd: [],
            biyetalasimId: [],
            biyetalasimAd: [],
            biyetOrtalamaBoy: [],
            biyetToplamKg: [],
            biyetcap: [],
            biyetler: [],
            alasimlar:alasimlar,
            biyet: {
                partino: '',
                firmaId: '',
                firmaAd: '',
                alasimId: '',
                alasimAd: '',
                cap: '',
                toplamKg: '',
                ortalamaBoy: '',
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
                malzemeAd: '',
                toplam: ''
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
            profiltoplamadet: [],
            profiltoplamkilo: [],
            profilIstenilenTermin: [],
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
                toplamadet: '',
                toplamkilo: '',
                mGr: '',
                tolerans: '',
                istenilenTermin: ''
            },
            isFullProfilData: false,
        },


        methods: {
            //biyetler method
            biyetekle: async function (event) {
                event.preventDefault();
                this.biyet.firmaId = biyetFirmaId;
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
                    this.biyet.cap &&
                    this.biyet.toplamKg) {

                    this.biyet.ortalamaBoy = (this.biyet.toplamKg / alasimbul.biyetBirimGramaj).toFixed(3).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    this.biyetler.push(this.biyet);

                    this.biyetpartino.push(this.biyet.partino);
                    this.biyetfirmaId.push(this.biyet.firmaId);
                    this.biyetfirmaAd.push(this.biyet.firmaAd);
                    this.biyetalasimId.push(this.biyet.alasimId);
                    this.biyetalasimAd.push(this.biyet.alasimAd);
                    this.biyetcap.push(this.biyet.cap);
                    this.biyetToplamKg.push(this.biyet.toplamKg);
                    this.biyetOrtalamaBoy.push(this.biyet.ortalamaBoy);
                    this.isFullBiyetData = false;
                    this.biyet = {
                        partino: '',
                        firmaId: '',
                        firmaAd: '',
                        alasimId: '',
                        alasimAd: '',
                        adetbiyet: '',
                        cap: '',
                        toplamKg: '',
                        ortalamaBoy: ''
                    }

                }


            },
            checkToplamKg(event) {
                this.biyet.firmaId = biyetFirmaId;
                this.alasimlar = alasimlar;
                if (event.target.value &&
                    this.biyet.partino &&
                    this.biyet.firmaId &&
                    this.biyet.alasimId &&
                    this.biyet.cap) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }

            },
            checkpartino(event) {
                this.biyet.firmaId = biyetFirmaId;
                this.alasimlar = alasimlar;
                if (event.target.value &&
                    this.biyet.firmaId &&
                    this.biyet.alasimId &&
                    this.biyet.toplamKg &&
                    this.biyet.partino) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }

            },
            onChangeCap(event) {
                this.biyet.firmaId = biyetFirmaId;
                this.alasimlar = alasimlar;
                if (event.target.value &&
                    this.biyet.firmaId &&
                    this.biyet.alasimId &&
                    this.biyet.toplamKg &&
                    this.biyet.partino) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }

            },
            onChangeAlasim(event) {
                this.biyet.firmaId = biyetFirmaId;
                this.alasimlar = alasimlar;
                if (event.target.value &&
                    this.biyet.firmaId &&
                    this.biyet.partino &&
                    this.biyet.toplamKg &&
                    this.biyet.cap) {
                    this.isFullBiyetData = true;
                } else {
                    this.isFullBiyetData = false;
                }

            },

            biyetSil: function (index) {
                this.$delete(this.biyetler, index);
                this.$delete(this.biyetpartino, index);
                this.$delete(this.biyetfirmaId, index);
                this.$delete(this.biyetfirmaAd, index);
                this.$delete(this.biyetalasimId, index);
                this.$delete(this.biyetalasimAd, index);
                this.$delete(this.biyetcap, index);
                this.$delete(this.biyetToplamKg, index);
                this.$delete(this.biyetOrtalamaBoy, index);
                this.isFullBiyetData = false;
            },


            //boyalar method
            boyaekle: async function (event) {
                event.preventDefault();
                    this.boya.firmaId = boyaFirmaId;
                    this.boya.boyaId = boyaTur;
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
                    this.boya.toplamkilo = this.boya.kilo * this.boya.adet;

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
                this.boya.firmaId = boyaFirmaId;
                this.boya.boyaId = boyaTur;
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
                this.boya.firmaId = boyaFirmaId;
                this.boya.boyaId = boyaTur;
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
                this.boya.firmaId = boyaFirmaId;
                this.boya.boyaId = boyaTur;
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
                this.$delete(this.boyapartino, index);
                this.$delete(this.boyafirmaId, index);
                this.$delete(this.boyafirmaAd, index);
                this.$delete(this.boyaboyaId, index);
                this.$delete(this.boyaboyaAd, index);
                this.$delete(this.boyaadet, index);
                this.$delete(this.boyakilo, index);
                this.$delete(this.boyasicaklik, index);
                this.$delete(this.boyacins, index);

                this.isFullBoyaData = false;
            },


            //malzemeler method
            malzemeekle: async function (event) {
                event.preventDefault();
                this.malzeme.firmaId = malzemeFirmaId;

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
                    this.malzeme.toplam = malzemebul.miktar ? malzemebul.miktar * this.malzeme.adet : 0;
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
                        adet: '',
                        toplam: ''
                    }
                }


            },
            checkmalzemepartino(event) {
                this.malzeme.firmaId = malzemeFirmaId;
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
                this.malzeme.firmaId = malzemeFirmaId;
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
                this.$delete(this.malzemepartino, index);
                this.$delete(this.malzemefirmaId, index);
                this.$delete(this.malzemefirmaAd, index);
                this.$delete(this.malzememalzemeId, index);
                this.$delete(this.malzememalzemeAd, index);
                this.$delete(this.malzemeadet, index);

                this.isFullMalzemeData = false;
            },


            //profiller method
            profilekle: async function (event) {
                event.preventDefault();
                this.profil.profilId = sevkiyatProfilId;
                this.profil.firmaId = sevkiyatGeldigiFirma;
                this.profil.musteriId = sevkiyatMusteriId;

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
                    this.profil.istenilenTermin &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis) {

                    this.profiller.push(this.profil);

                    this.profilfirmaId.push(this.profil.firmaId);
                    this.profilfirmaAd.push(this.profil.firmaAd);
                    this.profilmusteriId.push(this.profil.musteriId);
                    this.profilmusteriAd.push(this.profil.musteriAd);
                    this.profilprofilId.push(this.profil.profilId);
                    this.profiladet.push(this.profil.adet);
                    this.profilboy.push(this.profil.boy);
                    this.profilpaketAdet.push(this.profil.paketAdet);
                    this.profiltur.push(this.profil.tur);
                    this.profilgelis.push(this.profil.gelis);
                    this.profiltoplamadet.push(this.profil.toplamadet);
                    this.profiltoplamkilo.push(this.profil.toplamkilo);
                    this.profilIstenilenTermin.push(this.profil.istenilenTermin);
                    this.profil.boy = (this.profil.boy / 1000).toFixed(3);
                    this.profil.mGr = (((this.profil.toplamkilo / this.profil.toplamadet) / this.profil.boy) * 1000).toFixed(3);
                    this.profil.tolerans = (((this.profil.mGr - data.agirlik) / this.profil.mGr) * 100).toFixed(2);
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
                        resim: '',
                        toplamadet: '',
                        toplamkilo: '',
                        mGr: '',
                        tolerans: '',
                        istenilenTermin: '',
                    }
                }


            },
            checkprofilboy(event) {
                this.profil.profilId = sevkiyatProfilId;
                this.profil.firmaId = sevkiyatGeldigiFirma;
                this.profil.musteriId = sevkiyatMusteriId;
                if (event.target.value &&
                    this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.istenilenTermin &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis) {
                    this.isFullProfilData = true;
                } else {
                    this.isFullProfilData = false;
                }
            },
            checkprofiladet(event) {
                this.profil.profilId = sevkiyatProfilId;
                this.profil.firmaId = sevkiyatGeldigiFirma;
                this.profil.musteriId = sevkiyatMusteriId;
                if (this.profil.adet && this.profil.paketAdet) {
                    this.profil.toplamadet = this.profil.adet * this.profil.paketAdet;
                }

                if (event.target.value &&
                    this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.istenilenTermin &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis) {
                    this.isFullProfilData = true;
                } else {
                    this.isFullProfilData = false;
                }
            },
            checkprofilpaketAdet(event) {
                this.profil.profilId = sevkiyatProfilId;
                this.profil.firmaId = sevkiyatGeldigiFirma;
                this.profil.musteriId = sevkiyatMusteriId;
                if (this.profil.adet && this.profil.paketAdet) {
                    this.profil.toplamadet = this.profil.adet * this.profil.paketAdet;
                }

                if (event.target.value &&
                    this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.istenilenTermin &&
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
                this.$delete(this.profilfirmaId, index);
                this.$delete(this.profilfirmaAd, index);
                this.$delete(this.profilmusteriId, index);
                this.$delete(this.profilmusteriAd, index);
                this.$delete(this.profilprofilId, index);
                this.$delete(this.profiladet, index);
                this.$delete(this.profilboy, index);
                this.$delete(this.profilpaketAdet, index);
                this.$delete(this.profiltur, index);
                this.$delete(this.profilgelis, index);
                this.$delete(this.profiltoplamadet, index);
                this.$delete(this.profiltoplamkilo, index);
                this.$delete(this.profiltur, index);
                this.$delete(this.profilIstenilenTermin, index);
                this.isFullProfilData = false;
            },
            onChangeIstenilenTermin(event) {
                this.profil.profilId = sevkiyatProfilId;
                this.profil.firmaId = sevkiyatGeldigiFirma;
                this.profil.musteriId = sevkiyatMusteriId;
                if (this.profil.adet && this.profil.paketAdet) {
                    this.profil.toplamadet = this.profil.adet * this.profil.paketAdet;
                }

                if (event.target.value &&
                    this.profil.firmaId &&
                    this.profil.musteriId &&
                    this.profil.profilId &&
                    this.profil.adet &&
                    this.profil.boy &&
                    this.profil.istenilenTermin &&
                    this.profil.paketAdet &&
                    this.profil.tur &&
                    this.profil.gelis) {
                    this.isFullProfilData = true;
                } else {
                    this.isFullProfilData = false;
                }
            },
        }

    }
);

$('#sevkiyatBiyetFirmaId').on("change", async  function(value){
    biyetFirmaId = value.target.value

    alasimlar = await axios.post('/sena/netting/action.php', {
        action: 'alasimlar',
        firmaid: biyetFirmaId
    }).then((response) => {
        return response.data
    });

    veri.alasimlar = alasimlar;

});

$('#sevkiyatBiyetFirmaId').select2({});

$('#sevkiyatBoyaFirmaId').on("change",function(value){
    boyaFirmaId = value.target.value
});

$('#sevkiyatBoyaTur').on("change",function(value){
    boyaTur = value.target.value
});


$('#sevkiyatMalzemeFirmaId').on("change",function(value){
    malzemeFirmaId = value.target.value
});

$('#sevkiyatProfilId').on("change",function(value){
    sevkiyatProfilId = value.target.value
});

$('#sevkiyatGeldigiFirma').on("change",function(value){
    sevkiyatGeldigiFirma = value.target.value
});

$('#sevkiyatMusteriId').on("change",function(value){
    sevkiyatMusteriId = value.target.value
});


