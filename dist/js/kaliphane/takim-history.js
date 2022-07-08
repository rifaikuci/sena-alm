new Vue({
        el: "#takim-history",
        data: {
            takimno :''
        },


        methods: {
            historygoster(event) {
                $.ajax({
                    url: BASE_URL+'netting/kaliphane/history.php',
                    type: 'post',
                    data: {
                        takimno : event.target.dataset.takimno,
                        brutkilo : event.target.dataset.brutkilo,
                        netkilo : event.target.dataset.netkilo,
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


