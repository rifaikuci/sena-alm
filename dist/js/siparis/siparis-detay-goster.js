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
                        console.log(response);
                        $('.modal-body').html(response);
                        $('#modalviewdetay').modal('show');

                    }
                });
            }
        }
    }

});