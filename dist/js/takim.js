new Vue({
        el: "#takim",
        data: {
            kalipCins : "",
            label1: "",
            label2: ""
        },


        methods: {
            onChangeKalipCins(event) {
                if (event.target.value) {
                    this.kalipCins = event.target.value;
                    if(this.kalipCins == 0 ||this.kalipCins == 1) {
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
                }

            },
            parca1ekle(event){
                console.log("swdedee");
                $.ajax({
                    url: '/sena/netting/kalipci/modal-parca1.php',
                    type: 'post',

                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#parca1modal').modal('show');
                    }
                });
            },
            deneme(event) {
                debugger;
                console.log("inşAllah olacak");
            }

        }

    }
);