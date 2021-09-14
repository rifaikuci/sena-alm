new Vue({
        el: "#takim-goster",
        data: {
            parca :''
        },


        methods: {
            destekgoster(event) {
                $.ajax({
                    url: '/sena/netting/takim/destek.php',
                    type: 'post',
                    data: {
                        parca: event.target.dataset.parca,
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#modalview').modal('show');

                    }
                });
            },

            bolstergoster(event) {
                $.ajax({
                    url: '/sena/netting/takim/bolster.php',
                    type: 'post',
                    data: {
                        parca: event.target.dataset.parca,
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#modalview').modal('show');

                    }
                });

            },
        }

    }
);