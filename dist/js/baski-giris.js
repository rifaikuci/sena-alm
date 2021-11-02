var deneme = ""
var app =new Vue({
        el: "#baski-giris",
        data: {
            satirNo: "",
            profilNo: "ds",
            profilAd: "sdssd",
            isSelected:true,
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


$('#supplier_id').on("change",function(){
    debugger;
    app.deneme = $(this).val();
    deneme =$(this).val();
    console.log('Name : '+$(this).val());
});

$('#supplier_id').select2({});