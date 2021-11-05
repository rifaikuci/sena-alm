var deneme = ""
var app =new Vue({
        el: "#baski-giris",
        data: {
            satirNo: "",
            musteriAd: "",
            profil: "",
            alasim: "",
            tolerans:" ",
            boy:"",
            kg:"",
            adet:"",
            aciklama: "",
            isSelected: false
        },


        methods: {
            onChangeParca(event) {
            this.deneme = deneme;
                console.log(this.supplier_id)
                debugger;

            },


        }

    }
);


$('#supplier_id').on("change", async function(){

    const selectedRow = await axios.post('/sena/netting/baski/action.php', {
        action: 'baskigetir',
        id:  $(this).val(),
    }).then((response) => {
        return response.data
    });

   if(selectedRow){
       app.isSelected = true;
       app.satirNo = selectedRow.satirNo;
       app.musteriAd = selectedRow.musteriAd;
       app.profil = selectedRow.profil;
       app.alasim = selectedRow.alasim;
       app.tolerans = selectedRow.tolerans;
       app.boy = selectedRow.boy;
       app.kg = selectedRow.kg;
       app.adet = selectedRow.adet;
       app.aciklama = selectedRow.aciklama;
   } else {
       app.isSelected = false;
   }


});

$('#supplier_id').select2({});