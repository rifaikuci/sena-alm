new Vue({
    el: "#siparis-detay-goster",
    data: {
        siparisNo: ''
    },


    methods: {
        detayGoster(event) {
            if (event.target.dataset.siparisno) {
                $.ajax({
                    url: BASE_URL+'netting/siparis/siparis.php',
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