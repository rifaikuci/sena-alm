var date = new Date();
date.setMonth(date.getMonth() + 1);
date.setDate(date.getDate() + 26);

gun = date.getDate().toString().length == 1 ? "0" + date.getDate() : date.getDate();
ay = date.getMonth().toString().length == 1 ? "0" + date.getMonth() : date.getMonth();
if (ay == "00")
    ay = "01"
var date = date.getFullYear() + "-" + ay + "-" + gun;

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
            korumaBandi: '',
            naylonAd: '',
            baskiAciklama: '',
            boyaAciklama: '',
            paketAciklama: '',
            id: '',
            kiloAdet: '',
            istenilenTermik: '',
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
                this.siparis.korumaBandi &&
                this.siparis.maxTolerans &&
                this.siparis.istenilenTermik &&
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
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.korumaBandi &&
                this.siparis.maxTolerans &&
                this.siparis.istenilenTermik &&
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
                this.siparis.istenilenTermik &&
                this.siparis.korumaBandi &&
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
                    this.siparis.korumaBandi &&
                    this.siparis.istenilenTermik &&
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
                    korumaBandi: allItems[id].korumaBandi,
                    baskiAciklama: allItems[id].baskiAciklama,
                    paketAciklama: allItems[id].paketAciklama,
                    boyaAciklama: allItems[id].boyaAciklama,
                    profilId: allItems[id].profilId,
                    satirNo: allItems[id].satirNo,
                    alasimId: allItems[id].alasimId,
                    id: allItems[id].id,
                    kiloAdet: allItems[id].kiloAdet,
                    istenilenTermik: allItems[id].istenilenTermik,

                },
                    this.arraySiparisler = allItems;
                this.selectedRow = id;

                this.isBoya = this.siparis.siparisTur == "Boyalı" ? true : false;
                this.isEloksal = this.siparis.siparisTur == "Eloksal" ? true : false;
                clearTimeout(this.timer);
                this.counter = 0;
            }


        },

        checkAciklama(event) {
            if (
                this.siparis.profilId &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.maxTolerans &&
                this.siparis.istenilenTermik &&
                this.siparis.korumaBandi &&
                this.errorShow == false &&
                this.siparis.naylonId) {
                this.isFullSiparisData = true

            } else {
                this.isFullSiparisData = false
            }

        },

        async guncelle(event) {
            event.preventDefault();
            if (this.siparis.boy &&
                this.siparis.profilId &&
                this.siparis.siparisTur &&
                this.siparis.alasimId &&
                this.siparis.termimTarih &&
                this.siparis.maxTolerans &&
                this.siparis.korumaBandi &&
                this.siparis.istenilenTermik &&
                this.errorShow == false &&
                this.siparis.naylonId) {

                this.siparis.boyaAciklama = this.siparis.siparisTur == "Boyalı" ? this.siparis.boyaAciklama : ""

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
                        korumaBandi: this.siparis.korumaBandi,
                        boyaAciklama: this.siparis.boyaAciklama,
                        paketAciklama: this.siparis.paketAciklama,
                        baskiAciklama: this.siparis.baskiAciklama,
                        id: this.siparis.id,
                        siparisTur: this.siparis.siparisTur,
                        kiloAdet: this.siparis.kiloAdet,
                        istenilenTermik: this.siparis.istenilenTermik,
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
                    korumaBandi: '',
                    naylonAd: '',
                    paketAciklama: '',
                    boyaAciklama: '',
                    baskiAciklama: '',
                    id: '',
                    kiloAdet: '',
                    istenilenTermik: '',
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