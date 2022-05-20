new Vue({
    el: "#balya-detay-goster",
    data: {
        siparisNo: ''
    },


    methods: {
        detayGoster(event,) {
            if (event.target.dataset.balyano) {
                $.ajax({
                    url: '/sena/netting/balyalama/balyalama.php',
                    type: 'post',
                    data: {
                        balyano: event.target.dataset.balyano,
                    },
                    success: function (response) {
                        console.log(response);
                        $('.modal-body').html(response);
                        $('#balyalar').modal('show');

                    }
                });
            }
        }
    }

});