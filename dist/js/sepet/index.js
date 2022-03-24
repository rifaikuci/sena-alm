var sepetGiris = new Vue({
    el: "#sepet-goster",
    data: {
        termik: true,
        kromat: true,
        araba: true,
        kromatS: true,
        sepetler : [],
        filter : []
    },
    mounted: async function () {

        sepet = await axios.post('/sena/netting/sepet/action.php', {
            action: 'sepetgetir',
        }).then((response) => {
            return response.data
        });
       this.sepetler  = sepet;
       this.filter = sepet
       this.array = ['termik', 'araba', 'kromat', 'kromatS']


    },
    methods: {
        degistir(event, id) {

        if(id == 'termik') {
            if(!this.termik) this.array.push('termik')
            else this.array  = this.array.filter(x=> x != 'termik')
        }

            if(id == 'araba') {
                if(!this.araba) this.array.push('araba')
                else  this.array  = this.array.filter(x=> x != 'araba')
            }

            if(id == 'kromat') {
                if(!this.kromat) this.array.push('kromat')
                else  this.array  = this.array.filter(x=> x != 'kromat')
            }

            if(id == 'kromatS') {
                if(!this.kromatS) this.array.push('kromatS')
                else  this.array  = this.array.filter(x=> x != 'kromatS')
            }

            this.filter = this.sepetler.filter(x => this.array.includes(x.tur))
        },

        detayGoster(event,id) {
            debugger;
            console.log(id);
            if (id) {
                $.ajax({
                    url: '/sena/netting/sepet/sepet.php',
                    type: 'post',
                    data: {
                        id: id,
                    },
                    success: function (response) {
                        $('.modal-body').html(response);
                        $('#detail_sepet').modal('show');

                    }
                });
            }
        }

    }
})