new Vue({
        el: "#firma-durum",
        data: {
            firmaRol: false
        },


        methods: {
            onChangeFirmaRol(event) {
                this.firmaRol = event.target.value ? event.target.value == 24 ? true : false : false;

            },
        }

    }
);