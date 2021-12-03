new Vue({
        el: "#takim-degistir",
        data: {
            selectedParca : "",
            parca: [],
            parcaTuru:'',
            parcaNo: '',
            eskiSenaNo:'',
            parcagoster:false,
            cap: 0,
            profilId: 0,
            firmaId:0,
            figurSayi :0,
            commentText: "",
            parcaSenaNoYeni: "Parçayı Seç",
            ekle: false,
            counter: 0,
            timer: null

        },


        methods: {
            parcasec(data){
                if(this.selectedParca) {

                    this.parca = this.selectedParca.split(";");
                    this.parcaNo= this.parca[2];
                    this.parcaTuru= this.parca[1];
                    this.eskiSenaNo= this.parca[0];
                    this.parcagoster= true;
                    this.cap = data.cap;
                    this.profilId = data.profilid;
                    this.firmaId = data.firmaid;
                    this.figurSayi = data.figursayi;
                    this.commentText = "";
                    this.ekle = false;

                } else {
                    this.parcagoster = false;
                }


            },

            async parcamodal() {
                if(this.parcaNo && this.parcaTuru && this.eskiSenaNo) {

                    $.ajax({
                        url: '/sena/netting/takim/degistir.php',
                        type: 'post',
                        data: {
                            cap: this.cap,
                            firmaId: this.firmaId,
                            profilId: this.profilId,
                            figurSayi: this.figurSayi,
                            parca: this.parcaTuru
                        },
                        success: function (response) {
                            $('.modal-body').html(response);
                            $('#parcaselectview').modal('show');
                            $(".newselectparca").click(function (event) {

                                this.counter++;

                                if (this.counter == 1) {
                                    this.timer = setTimeout(() => {
                                        this.counter = 0;

                                    }, 300);


                                    self.parcaSenaNoYeni = $(this).data('senano');
                                    $('#parcaselectview').modal('hide');

                                }
                                clearTimeout(this.timer);
                                this.counter = 0;
                            })

                        }
                    });
                }
            },
            comment(event) {
                this.parcaSenaNoYeni  = self.parcaSenaNoYeni ? self.parcaSenaNoYeni : "Parçayı Seç";
                if(this.commentText && this.eskiSenaNo && this.parcaSenaNoYeni!="Parçayı Seç") {
                    this.ekle = true;
                }


            }

        }

    }
);