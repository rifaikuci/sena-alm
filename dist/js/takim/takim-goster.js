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
            modaltrash(event) {
                $.ajax({
                    url: '/sena/netting/takim/trash.php',
                    type: 'post',
                    data: {
                        parca1: event.target.dataset.parca1,
                        parca2: event.target.dataset.parca2,
                        takimno: event.target.dataset.takimno
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#modalview').modal('show');

                    }
                });
            }
        }

    }
);


