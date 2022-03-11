var kromatGiris  = new Vue({
        el: "#kromat-giris",
        data: {
            baskilar : [],
            sepetler: [],
            baskilarId: [],
            adetler: [],
            hurdaAdetler: [],
            sebepler: [],
            baski : {
                sepetId: "",
                baskiId :"",
                adet: "",
                hurdaAdet: 0,
                sebep: ""
            }
        },


        methods: {

            kromatekle: async function () {
                for( let i = 0; i <this.baskilar.length; i++  ) {
                    this.sepetler.push(this.baskilar[i].sepetId);
                    this.baskilarId.push(this.baskilar[i].baskiId);
                    this.adetler.push(this.baskilar[i].adet);
                    this.hurdaAdetler.push(this.baskilar[i].hurdaAdet);
                    this.sebepler.push(this.baskilar[i].sebep);
                }


            }

        }

    }
);

$('#kromat_sepet').on("change", async function () {

    kromatGiris.baskilar = []
     let  data = ($(this).val())

    for (let i = 0; i < data.length; i++) {

      let    array =  data[i].split(";");
        kromatGiris.baski = {
            sepetId: array[0],
            baskiId: array[1],
            adet: array[2],
            hurdaAdet: 0,
            sebep: ""
        }

        kromatGiris.baskilar.push(kromatGiris.baski);

    }

});
$('#kromat_sepet').select2({});
