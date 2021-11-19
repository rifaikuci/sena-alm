var siparissatirguncelle = new Vue({
    el: "#siparisguncelleneceksatir",
    data: {
        isFullSiparisData: false,
        isBoya: false,
        isEloksal: false,
        adetDisabled: false,
        kiloDisabled: false,
        errorShow: false,
        satirno: "",
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
        naylonAd: '',
        baskiAciklama: '',
        boyaAciklama: '',
        paketAciklama: '',
        kiloAdet: '',
        istenilenTermin: '',
        konum: ''
    },

    mounted: async function () {
        this.satirno = $(this)[0]._vnode.data.attrs.satirno;
        const response = await axios.post('/sena/netting/siparis-satir/action.php', {
            action: 'siparisgetir',
            satirno: this.satirno
        }).then((response) => {
            return response.data
        });

        this.profil = response.profil,
            this.boy = response.boy,
            this.adet = response.adet,
            this.kilo = response.kilo,
            this.siparisTur = response.siparisTur,
            this.boyaId = response.boyaId,
            this.eloksalId = response.eloksalId,
            this.alasim = response.alasim,
            this.termimTarih = response.termimTarih,
            this.maxTolerans = response.maxTolerans,
            this.araKagit = response.araKagit == 1 ? true : false,
            this.krepeKagit = response.krepeKagit == 1 ? true : false,
            this.naylonId = response.naylonId,
            this.baskiAciklama = response.baskiAciklama,
            this.paketAciklama = response.paketAciklama,
            this.boyaAciklama = response.boyaAciklama,
            this.profilId = response.profilId,
            this.satirNo = response.satirNo,
            this.alasimId = response.alasimId,
            this.id = response.id,
            this.kiloAdet = response.kiloAdet,
            this.istenilenTermin = response.istenilenTermin
        this.konum = response.konum
        this.isFullSiparisData = true;
        this.isBoya = this.siparisTur == "Boyalı" ? true : false;
        this.isEloksal = this.siparisTur == "Eloksal" ? true : false;
    },

    methods: {
        checkBoy(event) {
            if (event.target.value &&
                this.profilId &&
                this.siparisTur &&
                this.alasimId &&
                this.termimTarih &&
                this.maxTolerans &&
                this.istenilenTermin &&
                this.errorShow == false &&
                this.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },
        checkKagit() {
            if (this.boy &&
                this.profilId &&
                this.siparisTur &&
                this.alasimId &&
                this.termimTarih &&
                this.maxTolerans &&
                this.istenilenTermin &&
                this.errorShow == false &&
                this.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },
        profilOnChange(event) {
            if (event.target.value) {
                this.profil = event.target.value
                let arr = event.target.value.split(";")
                this.profilId = arr[0];
                this.profilAd = arr[1];
                this.adet = '';
                this.kilo = '';
                this.isFullSiparisData = false;
            }
        },

        onChangeSiparis(event) {
            this.boyaId = "";
            this.eloksalId = "";
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
                this.alasim = event.target.value
                let arr = event.target.value.split(";")
                this.alasimId = arr[0];
                this.alasimAd = arr[1];
            }
        },

        async checkKilo(event) {
            if (event.target.value && event.target.value > 0) {
                this.adetDisabled = true;
                if (this.profilId && this.boy) {
                    const kiloBul = await axios.post('/sena/netting/siparis/action.php', {
                        action: 'kilo',
                        profilId: this.profilId,
                    }).then((response) => {
                        return response.data
                    });

                    this.kiloAdet = 'K';
                    this.adet =
                        Math.round(event.target.value / (
                            parseInt(kiloBul.ortalama) *
                            parseInt(this.boy)) * 1000000);
                }
            } else {
                this.adet = '';
                this.adetDisabled = false;
                this.kiloDisabled = false;
            }

            if (event.target.value && event.target.value > 0 &&
                this.boy &&
                this.profilId &&
                this.siparisTur &&
                this.alasimId &&
                this.termimTarih &&
                this.maxTolerans &&
                this.istenilenTermin &&
                this.errorShow == false &&
                this.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },

        async checkAdet(event) {
            if (event.target.value && event.target.value > 0) {
                this.kiloDisabled = true;
                if (this.profilId && this.boy) {
                    const kiloBul = await axios.post('/sena/netting/siparis/action.php', {
                        action: 'kilo',
                        profilId: this.profilId,
                    }).then((response) => {
                        return response.data
                    });

                    this.kiloAdet = 'A';
                    this.kilo = Math.round((parseInt(event.target.value) *
                        parseInt(kiloBul.ortalama) *
                        parseInt(this.boy)) / 1000000);
                }
            } else {
                this.kilo = '';
                this.adetDisabled = false;
                this.kiloDisabled = false;
            }

            if (event.target.value && event.target.value > 0 &&
                this.boy &&
                this.profilId &&
                this.siparisTur &&
                this.alasimId &&
                this.termimTarih &&
                this.maxTolerans &&
                this.istenilenTermin &&
                this.errorShow == false &&
                this.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },


        async checkTolerans(event) {
            if (event.target.value && event.target.value > 0) {
                if (this.profilId) {
                    const tolerans = await axios.post('/sena/netting/siparis/action.php', {
                        action: 'tolerans',
                        deger: event.target.value,
                        profilId: this.profilId,
                    }).then((response) => {
                        return response.data
                    });
                    this.errorShow = tolerans.deger;
                }
                if (event.target.value && event.target.value > 0 &&
                    this.boy &&
                    this.profilId &&
                    this.siparisTur &&
                    this.alasimId &&
                    this.termimTarih &&
                    this.maxTolerans &&
                    this.istenilenTermin &&
                    this.errorShow == false &&
                    this.naylonId) {
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
                this.profilId &&
                this.siparisTur &&
                this.alasimId &&
                this.termimTarih &&
                this.maxTolerans &&
                this.istenilenTermin &&
                this.errorShow == false &&
                this.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },

    }

});


