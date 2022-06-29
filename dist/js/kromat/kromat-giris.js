var kromatGiris  = new Vue({
        el: "#kromat-giris",
        data: {
            baskilar : [],
            sepetler: [],
            baskilarId: [],
            adetler: [],
            hurdaAdetler: [],
            sebepler: [],
            isBitir : false,
            baski : {
                sepetAdet : "",
                sepetId: "",
                baskiId :"",
                adet: "",
                hurdaAdet: "",
                sebep: "",
                isEkle : false
            },

        },


        methods: {

            calculate($event, baski,index) {

                if(Number(baski.adet ? baski.adet : 0) + Number(baski.hurdaAdet ? baski.hurdaAdet : 0) ==Number(baski.sepetAdet)) {
                    this.baskilar[index].isEkle   = false;
                }  else {
                    this.baskilar[index].isEkle = true;
                }

                this.isFinishe();

            },

            kromatekle: async function () {
                for( let i = 0; i <this.baskilar.length; i++  ) {
                    this.sepetler.push(this.baskilar[i].sepetId);
                    this.baskilarId.push(this.baskilar[i].baskiId);
                    this.adetler.push(this.baskilar[i].adet);
                    this.hurdaAdetler.push(this.baskilar[i].hurdaAdet ? this.baskilar[i].hurdaAdet : 0 );
                    this.sebepler.push(this.baskilar[i].sebep);
                }


            },

            isFinishe() {
                let isWrong = this.baskilar.filter(x=> x.isEkle == true)

                if(isWrong.length > 0 ) {
                    this.isBitir = false;
                } else {
                    this.isBitir = true;
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
            hurdaAdet: "",
            sebep: "",
            sepetAdet : array[2],
            isEkle: false
        }

        kromatGiris.baskilar.push(kromatGiris.baski);

    }


});
$('#kromat_sepet').select2({});
