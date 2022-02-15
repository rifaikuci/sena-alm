var date = new Date();
date.setMonth(date.getMonth() + 1);
date.setDate(date.getDate() + 26);

gun = date.getDate().toString().length == 1 ? "0" + date.getDate() : date.getDate();
ay = date.getMonth().toString().length == 1 ? "0" + date.getMonth() : date.getMonth();
if (ay == "00")
    ay = "01"
var date = date.getFullYear() + "-" + ay + "-" + gun;

var siparisGiris = new Vue({
    el: "#siparis-giris",
    data: {
        isFullSiparisData: false,
        isBoya: false,
        isEloksal: false,
        adetDisabled: false,
        kiloDisabled: false,
        errorShow: false,
        arrayProfilId: [],
        arrayBoy: [],
        arrayAdet: [],
        arrayKilo: [],
        arraySiparisTur: [],
        arrayAlasimId: [],
        arrayalasimAd: [],
        arrayTermimTarih: [],
        arrayMaxTolerans: [],
        arrayAraKagit: [],
        arrayKrepeKagit: [],
        arrayNaylonId: [],
        arrayKorumaBandi: [],
        arrayBoyaId: [],
        arrayBoyaAd: [],
        arrayEloksalId: [],
        arrayEloksalAd: [],
        arrayBaskiAciklama: [],
        arrayBoyaAciklama: [],
        arrayPaketAciklama: [],
        arraySiparisler: [],
        arrayKiloAdet: [],
        arrayIstenilenTermin: [],
        siparis: {
            profil: '',
            profilId: '',
            profilAd: '',
            boy: '',
            adet: '',
            kilo: '',
            siparisTur: '',
            boyaId: '',
            eloksalId: '',
            alasim: '',
            alasimId: '',
            alasimAd: '',
            termimTarih: date,
            maxTolerans: '',
            araKagit: false,
            krepeKagit: false,
            araKagitAd: '',
            krepeKagitAd: '',
            naylonId: '',
            korumaBandi: '',
            naylonAd: '',
            baskiAciklama: '',
            boyaAciklama: '',
            paketAciklama: '',
            kiloAdet: '',
            istenilenTermin: '',
        }
    },


    methods: {
        checkBoy(event) {
            if (event.target.value &&
                this.siparis.profilId &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.maxTolerans &&
                this.siparis.istenilenTermin &&
                this.siparis.korumaBandi &&
                this.errorShow == false &&
                this.siparis.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },
        checkKagit() {
            if (this.siparis.boy &&
                this.siparis.profilId &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.maxTolerans &&
                this.siparis.istenilenTermin &&
                this.siparis.korumaBandi &&
                this.errorShow == false &&
                this.siparis.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },

        onChangeSiparis(event) {
            if (event.target.value === "Boyalı") {
                this.isBoya = true;
                this.isEloksal = false;
            } else if (event.target.value === "Eloksal") {
                this.isBoya = false;
                this.isEloksal = true;
            } else {
                this.isBoya = false;
                this.isEloksal = false;

            }
        },

        alasimOnChange(event) {
            if (event.target.value) {
                this.siparis.alasim = event.target.value
                let arr = event.target.value.split(";")
                this.siparis.alasimId = arr[0];
                this.siparis.alasimAd = arr[1];
            }
        },

        async checkKilo(event) {
            if (event.target.value && event.target.value > 0) {
                this.adetDisabled = true;
                if (this.siparis.profilId && this.siparis.boy) {
                    const kiloBul = await axios.post('/sena/netting/siparis/action.php', {
                        action: 'kilo',
                        profilId: this.siparis.profilId,
                    }).then((response) => {
                        return response.data
                    });

                    if (kiloBul.ortalama) {
                        this.siparis.kiloAdet = 'K';
                        this.siparis.adet =
                            Math.round(event.target.value / (
                                parseInt(kiloBul.ortalama) *
                                parseInt(this.siparis.boy)) * 1000000);
                    }
                }
            } else {
                this.siparis.adet = '';
                this.adetDisabled = false;
                this.kiloDisabled = false;
            }
        },

        async checkAdet(event) {
            if (event.target.value && event.target.value > 0) {
                this.kiloDisabled = true;
                if (this.siparis.profilId && this.siparis.boy) {
                    const kiloBul = await axios.post('/sena/netting/siparis/action.php', {
                        action: 'kilo',
                        profilId: this.siparis.profilId,
                    }).then((response) => {
                        return response.data
                    });

                    if (kiloBul.ortalama) {
                        this.siparis.kiloAdet = 'A';
                        this.siparis.kilo = Math.round((parseInt(event.target.value) *
                            parseInt(kiloBul.ortalama) *
                            parseInt(this.siparis.boy)) / 1000000);
                    }
                }
            } else {
                this.siparis.kilo = '';
                this.adetDisabled = false;
                this.kiloDisabled = false;
            }

        },


        async checkTolerans(event) {
            if (event.target.value && event.target.value > 0) {
                if (this.siparis.profilId) {
                    const tolerans = await axios.post('/sena/netting/siparis/action.php', {
                        action: 'tolerans',
                        deger: event.target.value,
                        profilId: this.siparis.profilId,
                    }).then((response) => {
                        return response.data
                    });
                    this.errorShow = tolerans.deger;
                }
                if (event.target.value && event.target.value > 0 &&
                    this.siparis.boy &&
                    this.siparis.profilId &&
                    this.siparis.siparisTur &&
                    this.siparis.alasimId &&
                    this.siparis.termimTarih &&
                    this.siparis.maxTolerans &&
                    this.siparis.istenilenTermin &&
                    this.siparis.korumaBandi &&
                    this.errorShow == false &&
                    this.siparis.naylonId) {
                    this.isFullSiparisData = true

                } else {
                    this.isFullSiparisData = false
                }

            } else {
                this.errorShow = false;
            }

        },
        checkAciklama(event) {
            if (
                this.siparis.profilId &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.maxTolerans &&
                this.siparis.istenilenTermin &&
                this.siparis.korumaBandi &&
                this.errorShow == false &&
                this.siparis.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },

        ekle: async function (event) {
            event.preventDefault();
            if (this.siparis.boy &&
                this.siparis.profilId &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.istenilenTermin &&
                this.siparis.maxTolerans &&
                this.siparis.korumaBandi &&
                this.errorShow == false &&
                this.siparis.naylonId) {

                this.siparis.naylonAd = this.siparis.naylonId == "1" ? "Baskılı" :
                    this.siparis.naylonId == "2" ? "Baskısız" : "Yok";
                this.siparis.araKagitAd = this.siparis.araKagit == true ? "Var" : "Yok"
                this.siparis.krepeKagitAd = this.siparis.krepeKagit == true ? "Var" : "Yok"
                this.siparis.boyaAciklama = this.siparis.siparisTur == "Boyalı" ? this.siparis.boyaAciklama : ""

                this.arraySiparisler.push(this.siparis);
                this.arrayProfilId.push(this.siparis.profilId);
                this.arrayBoy.push(this.siparis.boy);
                this.arrayAdet.push(this.siparis.adet);
                this.arrayKilo.push(this.siparis.kilo);
                this.arraySiparisTur.push(this.siparis.siparisTur);
                this.arrayAlasimId.push(this.siparis.alasimId);
                this.arrayTermimTarih.push(this.siparis.termimTarih);
                this.arrayMaxTolerans.push(this.siparis.maxTolerans);
                this.arrayAraKagit.push(this.siparis.araKagit);
                this.arrayKrepeKagit.push(this.siparis.krepeKagit);
                this.arrayNaylonId.push(this.siparis.naylonId);
                this.arrayKorumaBandi.push(this.siparis.korumaBandi);
                this.arrayBoyaId.push(this.siparis.boyaId);
                this.arrayEloksalId.push(this.siparis.eloksalId);
                this.arrayKiloAdet.push(this.siparis.kiloAdet);
                this.arrayBaskiAciklama.push(this.siparis.baskiAciklama);
                this.arrayPaketAciklama.push(this.siparis.paketAciklama);
                this.arrayBoyaAciklama.push(this.siparis.boyaAciklama);
                this.arrayIstenilenTermin.push(this.siparis.istenilenTermin);


                this.siparis = {
                    profil: '',
                    boy: '',
                    adet: '',
                    kilo: '',
                    siparisTur: '',
                    boyaId: '',
                    eloksalId: '',
                    alasim: '',
                    alasimId: '',
                    alasimAd: '',
                    termimTarih: date,
                    maxTolerans: '',
                    araKagit: false,
                    krepeKagit: false,
                    araKagitAd: '',
                    krepeKagitAd: '',
                    naylonId: '',
                    korumaBandi: '',
                    naylonAd: '',
                    baskiAciklama: '',
                    paketAciklama: '',
                    boyaAciklama: '',
                    kiloAdet: '',
                    istenilenTermin: '',
                }

                this.isFullSiparisData = false;
                this.isBoya = false;
                this.isEloksal = false;
                this.adetDisabled = false;
                this.kiloDisabled = false;
                this.errorShow = false;


            } else {
                this.isFullSiparisData = false

            }
        },

        siparisSil: function (index) {

            this.$delete(this.arraySiparisler, index);
            this.$delete(this.arrayProfilId, index);
            this.$delete(this.arrayBoy, index);
            this.$delete(this.arrayAdet, index);
            this.$delete(this.arrayKilo, index);
            this.$delete(this.arraySiparisTur, index);
            this.$delete(this.arrayAlasimId, index);
            this.$delete(this.arrayTermimTarih, index);
            this.$delete(this.arrayMaxTolerans, index);
            this.$delete(this.arrayAraKagit, index);
            this.$delete(this.arrayKrepeKagit, index);
            this.$delete(this.arrayNaylonId, index);
            this.$delete(this.arrayKorumaBandi, index);
            this.$delete(this.arrayBoyaId, index);
            this.$delete(this.arrayEloksalId, index);
            this.$delete(this.arrayPaketAciklama, index);
            this.$delete(this.arrayBoyaAciklama, index);
            this.$delete(this.arrayBaskiAciklama, index);
            this.$delete(this.arrayKiloAdet, index);
            this.$delete(this.arrayIstenilenTermin, index);
            this.isFullSiparisData = false

        },
    }

});


$('#siparisProfilId').on("change", function (value) {

    siparisGiris.siparis.profil = value.target.value
    let arr = value.target.value.split(";")
    siparisGiris.siparis.profilId = arr[0];
    siparisGiris.siparis.profilAd = arr[1];
    siparisGiris.siparis.adet = '';
    siparisGiris.siparis.kilo = '';

});

