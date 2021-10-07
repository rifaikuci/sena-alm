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
        arrayAlasimId: [],
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
            araKagitAd: '',
            krepeKagitAd: '',
            naylonId: '',
            naylonAd: '',
            aciklama: ''
        }
    },


    methods: {
        checkAciklama(event) {
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
                this.siparis.adet = '';
                this.siparis.kilo = '';
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
            if (this.siparis.boy &&
                this.siparis.profilId &&
                this.siparis.aciklama &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.maxTolerans &&
                this.errorShow == false &&
                this.siparis.naylonId) {

                this.siparis.naylonAd = this.siparis.naylonId == "1" ? "Baskılı" :
                    this.siparis.naylonId == "2" ? "Baskısız" : "Yok";
                this.siparis.araKagitAd = this.siparis.araKagit == true ? "Var" : "Yok"
                this.siparis.krepeKagitAd = this.siparis.krepeKagit == true ? "Var" : "Yok"

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
                this.arrayBoyaId.push(this.siparis.boyaId);
                this.arrayEloksalId.push(this.siparis.eloksalId);
                this.arrayAciklama.push(this.siparis.aciklama);


                this.siparis = {
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
                    aciklama: ''
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
            this.$delete(this.arrayBoyaId, index);
            this.$delete(this.arrayEloksalId, index);
            this.$delete(this.arrayAciklama, index);
            this.isFullSiparisData = false

        },
    }

});

new Vue({
    el: "#siparis-detay-goster",
    data: {
        siparisNo: ''
    },


    methods: {
        detayGoster(event) {
            if (event.target.dataset.siparisno) {
                $.ajax({
                    url: '/sena/netting/siparis/siparis.php',
                    type: 'post',
                    data: {
                        siparisNo: event.target.dataset.siparisno,
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#modalviewdetay').modal('show');

                    }
                });
            }
        }
    }

});
var allItems;
new Vue({
    el: "#siparis-guncelleme",
    data: {
        isFullSiparisData: false,
        isBoya: false,
        isEloksal: false,
        adetDisabled: false,
        kiloDisabled: false,
        errorShow: false,
        arraySiparisler: '',
        counter: '',
        timer: null,
        selectedRow: null,
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
            naylonAd: '',
            aciklama: '',
            id: ''
        },

    },

    mounted: async function () {

        allItems = await axios.post('/sena/netting/siparis/action.php', {
            action: 'siparislerlistesi',
            siparisNo: new URL(location.href).searchParams.get('siparisno'),
        }).then((response) => {
            return response.data
        });

        this.arraySiparisler = allItems;
    }

    ,
    methods: {
        checkAciklama(event) {
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
                this.siparis.adet = '';
                this.siparis.kilo = '';
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

        trashrow() {
            this.selectedRow = null;
        },

        rowSelected(id) {


            this.counter++;
            if (this.counter == 2) {
                this.timer = setTimeout(() => {
                    this.counter = 0;

                }, 300);


                this.siparis = {
                    profil: allItems[id].profil,
                    boy: allItems[id].boy,
                    adet: allItems[id].adet,
                    kilo: allItems[id].kilo,
                    siparisTur: allItems[id].siparisTur,
                    boyaId: allItems[id].boyaId,
                    eloksalId: allItems[id].eloksalId,
                    alasim: allItems[id].alasim,
                    termimTarih: allItems[id].termimTarih,
                    maxTolerans: allItems[id].maxTolerans,
                    araKagit: allItems[id].araKagit == 1 ? true : false,
                    krepeKagit: allItems[id].krepeKagit == 1 ? true : false,
                    naylonId: allItems[id].naylonId,
                    aciklama: allItems[id].aciklama,
                    profilId: allItems[id].profilId,
                    satirNo: allItems[id].satirNo,
                    alasimId: allItems[id].alasimId,
                    id: allItems[id].id

                },
                    this.arraySiparisler = allItems;
                this.selectedRow = id;


                this.isBoya = this.siparis.siparisTur == "Boyalı" ? true : false;
                this.isEloksal = this.siparis.siparisTur == "Eloksal" ? true : false;
                clearTimeout(this.timer);
                this.counter = 0;
            }


        },

        async guncelle(event) {
            event.preventDefault();
            if (this.siparis.boy &&
                this.siparis.profilId &&
                this.siparis.aciklama &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.maxTolerans &&
                this.errorShow == false &&
                this.siparis.naylonId) {


                $.ajax({
                    url: '/sena/netting/siparis/index.php',
                    type: 'post',
                    data: {
                        guncellesatir: true,
                        satirNo: this.siparis.satirNo,
                        profilId: this.siparis.profilId,
                        boy: this.siparis.boy,
                        adet: this.siparis.adet,
                        kilo: this.siparis.kilo,
                        boyaId: this.siparis.boyaId,
                        eloksalId: this.siparis.eloksalId,
                        alasimId: this.siparis.alasimId,
                        termimTarih: this.siparis.termimTarih,
                        maxTolerans: this.siparis.maxTolerans,
                        araKagit: this.siparis.araKagit == true ? 1 : 0,
                        krepeKagit: this.siparis.krepeKagit == true ? 1 : 0,
                        naylonDurum: this.siparis.naylonId,
                        aciklama: this.siparis.aciklama,
                        id: this.siparis.id,
                        siparisTur: this.siparis.siparisTur
                    },
                    success: function (response) {


                    }
                });

                this.siparis = {
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
                    aciklama: '',
                    id: ''
                }

                this.isFullSiparisData = false;
                this.isBoya = false;
                this.isEloksal = false;
                this.adetDisabled = false;
                this.kiloDisabled = false;
                this.errorShow = false;
                this.selectedRow = null;

                allItems = await axios.post('/sena/netting/siparis/action.php', {
                    action: 'siparislerlistesi',
                    siparisNo: new URL(location.href).searchParams.get('siparisno'),
                }).then((response) => {
                    return response.data
                });

                this.arraySiparisler = allItems;


            } else {
                this.isFullSiparisData = false

            }


        },

    }

});

