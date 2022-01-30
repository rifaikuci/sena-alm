var kromatGiris  = new Vue({
        el: "#kromat-giris",
        data: {
            kesimler : [],
            deneme : "sdasdasd",
            sepetler: [],
            kesimlerId: [],
            adetler: [],
            hurdaAdetler: [],
            sebepler: [],
            kesim : {
                sepetId: "",
                kesimId :"",
                adet: "",
                hurdaAdet: "",
                sebep: ""
            }
        },


        methods: {

            kromatekle: async function () {
                for( let i = 0; i <this.kesimler.length; i++  ) {
                    this.sepetler.push(this.kesimler[i].sepetId);
                    this.kesimlerId.push(this.kesimler[i].kesimId);
                    this.adetler.push(this.kesimler[i].adet);
                    this.hurdaAdetler.push(this.kesimler[i].hurdaAdet);
                    this.sebepler.push(this.kesimler[i].sebep);
                }


            }

        }

    }
);

$('#kromat_sepet').on("change", async function () {

    kromatGiris.kesimler = []
     let  data = ($(this).val())

    for (let i = 0; i < data.length; i++) {

      let    array =  data[i].split(";");
        kromatGiris.kesim = {
            sepetId: array[0],
            kesimId: array[1],
            adet: array[2],
            hurdaAdet: "",
            sebep: ""
        }

        kromatGiris.kesimler.push(kromatGiris.kesim);

    }

});
$('#kromat_sepet').select2({});
