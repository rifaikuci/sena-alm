var date = new Date();
date.setMonth(date.getMonth() + 1);
date.setDate(date.getDate() + 26);

gun = date.getDate().toString().length == 1 ? "0" + date.getDate() : date.getDate();
ay = date.getMonth().toString().length == 1 ? "0" + date.getMonth() : date.getMonth();
var date = date.getFullYear() + "-" + ay + "-" + gun
new Vue({
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
            arrayalasimId: [],
            arrayalasimAd: [],
            arrayTermimTarih: [],
            arrayMaxTolerans: [],
            arrayAraKagit: [],
            arrayKrepeKagit: [],
            arrayNaylonId: [],
            arrayBoyaId: [],
            arrayBoyaAd: [],
            arrayEloksalId: [],
            arrayEloksalAd: [],
            arrayAciklama: [],
            arraySiparisler: [],
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
                naylonId: '',
                naylonAd: '',
                aciklama: ''
            }
        },


        methods: {
            checkAciklama(event) {
                debugger;
                if (event.target.value &&
                    this.siparis.profilId &&
                    this.siparis.boy &&
                    this.siparis.siparisTur &&
                    this.siparis.alasimId &&
                    this.siparis.termimTarih &&
                    this.siparis.maxTolerans &&
                    this.errorShow == false &&
                    this.siparis.naylonId) {
                    this.isFullSiparisData = true

                } else {
                    this.isFullSiparisData = false
                }

            },
            checkBoy(event) {
                if (event.target.value &&
                    this.siparis.profilId &&
                    this.siparis.aciklama &&
                    this.siparis.siparisTur &&
                    this.siparis.alasimId &&
                    this.siparis.termimTarih &&
                    this.siparis.maxTolerans &&
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
                    this.siparis.aciklama &&
                    this.siparis.siparisTur &&
                    this.siparis.alasimId &&
                    this.siparis.termimTarih &&
                    this.siparis.maxTolerans &&
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
                    this.siparis.aciklama &&
                    this.siparis.siparisTur &&
                    this.siparis.alasimId &&
                    this.siparis.termimTarih &&
                    this.siparis.maxTolerans &&
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


            profilOnChange(event) {
                if (event.target.value) {
                    this.siparis.profil = event.target.value
                    let arr = event.target.value.split(";")
                    this.siparis.profilId = arr[0];
                    this.siparis.profilAd = arr[1];
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
                            this.siparis.adet = Math.ceil(((
                                parseInt(kiloBul.ortalama) *
                                parseInt(this.siparis.boy)) / event.target.value).toFixed(3))
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
                            this.siparis.kilo = (parseInt(event.target.value) *
                                parseInt(kiloBul.ortalama) *
                                parseInt(this.siparis.boy))
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
                        this.siparis.aciklama &&
                        this.siparis.siparisTur &&
                        this.siparis.alasimId &&
                        this.siparis.termimTarih &&
                        this.siparis.maxTolerans &&
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

            ekle: async function (event) {
                event.preventDefault();
                debugger;
            },

            siparisSil: function (index) {
                if (index) {
                    this.$delete(this.arraySiparisler, index);
                    this.isFullSiparisData = false;
                }
            },
        }

    }
);
