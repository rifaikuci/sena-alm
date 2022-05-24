new Vue({
        el: "#takim-history",
        data: {
            takimno :''
        },


        methods: {
            historygoster(event) {
                $.ajax({
                    url: '/sena/netting/kaliphane/history.php',
                    type: 'post',
                    data: {
                        takimno : event.target.dataset.takimno,
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#modalHistory').modal('show');

                    }
                });
            }
        }

    }
);


