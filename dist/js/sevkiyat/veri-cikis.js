var cikis = new Vue({
        el: "#stok-cikis",
        data: {
            balyalama: [],
            balyaNo: "balyaNo",
            balyaBoy :"0",
            balyaKilo :"0",
            tarih :"0",
            id : 0,
            selectedItem: null,

            balya: {
                id: 0,
                baskiId : 0,
                netAdet : 0,
                netKilo : 0,
                mtGr : 0,
                paketDetay : "",
                realTolerans : 0,
                teorikTolerans: 0,
                satirNo: "",
                siparisNo: ""
            }
        },
        mounted: async function () {

            let balyalama = await axios.post('/sena/netting/sevkiyat/action.php', {
                action: 'balyalamagetir',
            }).then((response) => {
                return response.data
            });


            console.log(balyalama);


        },


    }
);