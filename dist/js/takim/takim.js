new Vue({
        el: "#takim",
        data: {

            kalipCins: "",
            label1: "",
            label2: "",
            parca1SenaNo: "Parçayı Seç",
            parca1Cap: '',
            parca1FirmaAd: '',
            parca1FirmaId: '',
            parca1ProfilId: '',
            parca1ProfilAd: '',
            parca1FigurSayi: '',

            parca2SenaNo: "Parçayı Seç",
            parca2Cap: '',
            parca2FirmaAd: '',
            parca2FirmaId: '',
            parca2ProfilId: '',
            parca2ProfilAd: '',
            parca2FigurSayi: '',
            firmaAd: '',
            firmaId: '',
            cap: '',
            firma: '',
            profil: '',
            profilId: '',
            figur: '',
            counter: 0,
            counter2: 0,
            timer: null,
            timer2: null,
            takimCheck: false,
            ekle: false,
            destekler: [],
            bolsterler: []
        },


        methods: {
            onChangeKalipCins(event) {
                if (event.target.value) {
                    this.kalipCins = event.target.value;
                    if (this.kalipCins == 0 || this.kalipCins == 1) {
                        this.label1 = "Zıvana";
                        this.label2 = "Kapak"
                    } else if (this.kalipCins == 2) {
                        this.label1 = "Hazne";
                        this.label2 = "Kalıp"
                    } else if (this.kalipCins == 3) {
                        this.label1 = "Hazneli Kalıp"
                        this.label2 = ""
                    }
                } else {
                    this.label1 = "";
                    this.label2 = ""
                    this.cap = "";
                    this.firmaAd = "";
                    this.profil = "";
                    this.figur = ""

                    Vue.set(self, 'parca2SenaNo', "");
                    Vue.set(self, 'parca2FirmaAd', "");
                    Vue.set(self, 'parca2ProfilId', "");
                    Vue.set(self, 'parca2ProfilAd', "");
                    Vue.set(self, 'parca2Cap', "");
                    Vue.set(self, 'parca2FigurSayi', "");
                    Vue.set(self, 'parca2FirmaId', "");

                    Vue.set(self, 'parca1SenaNo', "");
                    Vue.set(self, 'parca1FirmaAd', "");
                    Vue.set(self, 'parca1ProfilId', "");
                    Vue.set(self, 'parca1ProfilAd', "");
                    Vue.set(self, 'parca1Cap', "");
                    Vue.set(self, 'parca1FigurSayi', "");
                    Vue.set(self, 'parca1FirmaId', "");
                }

            },
            parca1ekle(event) {
                if (this.label1) {
                    this.cap = self.parca2Cap ? self.parca2Cap : "";
                    this.firmaAd = self.parca2FirmaAd ? self.parca2FirmaAd : "";
                    this.firmaId = self.parca2FirmaId ? self.parca2FirmaId : "";
                    this.profil = self.parca2ProfilAd ? self.parca2ProfilAd : "";
                    this.profilId = self.parca2ProfilId ? self.parca2ProfilId : "";
                    this.figur = self.parca2FigurSayi ? self.parca2FigurSayi : "";
                    this.parca1SenaNo = self.parca1SenaNo ? self.parca1SenaNo : "Parçayı Seç";
                    this.parca2SenaNo = self.parca2SenaNo ? self.parca2SenaNo : "Parçayı Seç";

                }
                $.ajax({
                    url: BASE_URL+'netting/kalipci/modal-parca1.php',
                    type: 'post',
                    data: {
                        kalipCins: this.kalipCins,
                        cap: this.cap,
                        firmaId: this.firmaId,
                        profilId: this.profilId,
                        figur: this.figur
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#parca1modal').modal('show');
                        $(".parcaselected").click(function (event) {

                            this.counter++;

                            if (this.counter == 1) {
                                this.timer = setTimeout(() => {
                                    this.counter = 0;

                                }, 300);


                                self.parca1SenaNo = $(this).data('senano');
                                self.parca1FirmaAd = $(this).data('firmaad');
                                self.parca1FirmaId = $(this).data('firmaid');
                                self.parca1ProfilId = $(this).data('profilid');
                                self.parca1ProfilAd = $(this).data('profilad');
                                self.parca1Cap = $(this).data('cap');
                                self.parca1FigurSayi = $(this).data('figursayi');
                                $('#parca1modal').modal('hide');

                            }
                            clearTimeout(this.timer);
                            this.counter = 0;
                        })
                    }
                });

            },

            async parca2ekle(event) {
                if (this.label1) {
                    this.cap = self.parca1Cap ? self.parca1Cap : "";
                    this.firmaAd = self.parca1FirmaAd ? self.parca1FirmaAd : "";
                    this.firmaId = self.parca1FirmaId ? self.parca1FirmaId : "";
                    this.profil = self.parca1ProfilAd ? self.parca1ProfilAd : "";
                    this.profilId = self.parca1ProfilId ? self.parca1ProfilId : "";
                    this.figur = self.parca1FigurSayi ? self.parca1FigurSayi : "";
                    this.parca1SenaNo = self.parca1SenaNo ? self.parca1SenaNo : "Parçayı Seç";
                    this.parca2SenaNo = self.parca2SenaNo ? self.parca2SenaNo : "Parçayı Seç";

                }

                $.ajax({
                    url: BASE_URL+'netting/kalipci/modal-parca2.php',
                    type: 'post',
                    data: {
                        kalipCins: this.kalipCins,
                        cap: this.cap,
                        firmaId: this.firmaId,
                        profilId: this.profilId,
                        figur: this.figur
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#parca1modal').modal('show');
                        $(".parcaselected2").click(function (event) {

                            this.counter2++;

                            if (this.counter2 == 1) {
                                this.timer2 = setTimeout(() => {
                                    this.counter2 = 0;

                                }, 300);


                                self.parca2SenaNo = $(this).data('senano');
                                self.parca2FirmaAd = $(this).data('firmaad');
                                self.parca2FirmaId = $(this).data('firmaid');
                                self.parca2ProfilId = $(this).data('profilid');
                                self.parca2ProfilAd = $(this).data('profilad');
                                self.parca2Cap = $(this).data('cap');
                                self.parca2FigurSayi = $(this).data('figursayi');
                                $('#parca1modal').modal('hide');

                            }
                            clearTimeout(this.timer2);
                            this.counter2 = 0;
                        })
                    }
                });

            },
            async takimOnay() {

                this.takimCheck = !this.takimCheck;
                if (this.kalipCins == 0 || this.kalipCins == 1 || this.kalipCins == 2) {
                    this.cap = self.parca1Cap ? self.parca1Cap : self.parca2Cap ? self.parca2Cap : "";
                    this.firmaAd = self.parca1FirmaAd ? self.parca1FirmaAd : self.parca2FirmaAd ? self.parca2FirmaAd : "";
                    this.firmaId = self.parca1FirmaId ? self.parca1FirmaId : self.parca2FirmaId ? self.parca2FirmaId : "";
                    this.profil = self.parca1ProfilAd ? self.parca1ProfilAd : self.parca2ProfilAd ? self.parca2ProfilAd : "";
                    this.profilId = self.parca1ProfilId ? self.parca1ProfilId : self.parca2ProfilId ? self.parca2ProfilId : "";
                    this.figur = self.parca1FigurSayi ? self.parca1FigurSayi : self.parca2FigurSayi ? self.parca2FigurSayi : "";
                    this.parca1SenaNo = self.parca1SenaNo ? self.parca1SenaNo : "Parçayı Seç";
                    this.parca2SenaNo = self.parca2SenaNo ? self.parca2SenaNo : "Parçayı Seç";
                    const destekler = await axios.post(BASE_URL+'netting/action.php', {
                        action: 'destekId',
                        firmaId: this.firmaId,
                        profilId: this.profilId,
                        figur: this.figur,
                        cap: this.cap,
                        kalipCins: this.kalipCins

                    }).then((response) => {
                        return response.data
                    });
                    this.destekler = destekler;

                    const bolsterler = await axios.post(BASE_URL+'netting/action.php', {
                        action: 'bolsterId',
                        figur: this.figur,
                    }).then((response) => {
                        return response.data
                    });


                    this.bolsterler = bolsterler;

                    if (this.parca1SenaNo != "Parçayı Seç" && this.parca2SenaNo != "Parçayı Seç") {
                        this.ekle = true;
                    } else {
                        this.ekle = false;
                    }

                } else {
                    this.cap = self.parca1Cap ? self.parca1Cap : "";
                    this.firmaAd = self.parca1FirmaAd ? self.parca1FirmaAd : "";
                    this.firmaId = self.parca1FirmaId ? self.parca1FirmaId : "";
                    this.profil = self.parca1ProfilAd ? self.parca1ProfilAd : "";
                    this.profilId = self.parca1ProfilId ? self.parca1ProfilId : "";
                    this.figur = self.parca1FigurSayi ? self.parca1FigurSayi : "";
                    this.parca1SenaNo = self.parca1SenaNo ? self.parca1SenaNo : "Parçayı Seç";
                    this.parca2SenaNo = self.parca2SenaNo ? self.parca2SenaNo : "Parçayı Seç";
                    const destekler = await axios.post(BASE_URL+'netting/action.php', {
                        action: 'destekId',
                        firmaId: this.firmaId,
                        profilId: this.profilId,
                        figur: this.figur,
                        cap: this.cap,
                        kalipCins: this.kalipCins

                    }).then((response) => {
                        return response.data
                    });
                    this.destekler = destekler;

                    const bolsterler = await axios.post(BASE_URL+'netting/action.php', {
                        action: 'bolsterId',
                        figur: this.figur
                    }).then((response) => {
                        return response.data
                    });

                    this.bolsterler = bolsterler;

                    if (this.parca1SenaNo != "Parçayı Seç") {
                        this.ekle = true;
                    } else {
                        this.ekle = false;
                    }

                }
                console.log(this.bolsterler)
                if (this.takimCheck == true) {
                    this.ekle = true;
                }

            }

        }

    }
);