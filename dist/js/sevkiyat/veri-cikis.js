var cikis = new Vue({
        el: "#stok-cikis",
        data: {
            balyalar: [],
            balyalaArray : "",
            balyaNoArray : "",
            balya: {
                id: 0,
                operatorId: 0,
                tarih: "",
                baskiId: [],
                netAdet: [],
                netKilo: [],
                mtGr: [],
                paketDetay: [],
                realTolerans: [],
                teorikTolerans: [],
                satirNo: [],
                siparisNo: [],
                balyaNo: "",
                balyaBoy: "",
                balyaKilo: "",
                musteriId: 0,
                musteri: "",
                selected: false,
                tonaj: 0
            }
        },
        mounted: async function () {

            let balyalama = await axios.post(BASE_URL+'netting/sevkiyat/action.php', {
                action: 'balyalamagetir',
            }).then((response) => {
                return response.data
            });


            balyalama = balyalama.map(x => {
                this.balya.id = x.id;
                this.balya.operatorId = x.operatorId;
                this.balya.tarih = x.tarih;
                this.balya.baskiId = x.baskiId.split(";");
                this.balya.netAdet = x.netAdet.split(";");
                this.balya.netKilo = x.netKilo.split(";");
                this.balya.mtGr = x.mtGr.split(";");
                this.balya.paketDetay = x.paketDetay.split(";");
                this.balya.realTolerans = x.realTolerans.split(";");
                this.balya.teorikTolerans = x.teorikTolerans.split(";");
                this.balya.satirNo = x.satirNo.split(";");
                this.balya.siparisNo = x.siparisNo.split(";");
                this.balya.balyaNo = x.balyaNo;
                this.balya.balyaBoy = x.balyaBoy;
                this.balya.balyaKilo = x.balyaKilo;
                this.balya.musteriId = x.musteriId;
                this.balya.musteri = x.musteri;
                this.balya.selected = false;
                this.balyalar.push(this.balya);
                this.balya = {
                    id: 0,
                    operatorId: 0,
                    tarih: "",
                    baskiId: [],
                    netAdet: [],
                    netKilo: [],
                    mtGr: [],
                    paketDetay: [],
                    realTolerans: [],
                    teorikTolerans: [],
                    satirNo: [],
                    siparisNo: [],
                    balyaNo: "",
                    balyaBoy: "",
                    balyaKilo: "",
                    musteriId: 0,
                    musteri: "",
                    selected: false
                }


            })
        },

        methods: {
            async ekle(event, id) {
                event.preventDefault();
                this.balyaFilter = this.balyalar.filter(x => x.selected === true)
                if (this.balyaFilter.filter(x => x.id === id).length === 0) {
                    musteriId = this.balyalar.find(x => x.id === id).musteriId;

                    if (this.balyaFilter.filter(x => x.musteriId != musteriId).length === 0) {
                        this.balyalar.find(x => x.id === id).selected = true
                    } else {
                        this.balyalar = this.balyalar.map(x => {
                            return ({
                                ...x,
                                selected: false
                            })
                        })
                        this.balyalar.find(x => x.id === id).selected = true


                    }
                } else {
                    this.balyalar.find(x => x.id === id).selected = false

                }

                musteriId = this.balyalar.find(x => x.id === id).musteriId;

                this.balyalar.find(x => x.id === id).selected = true
            },

            async cikar(event, id) {
                event.preventDefault();
                this.balyalar.find(x => x.id === id).selected = false
            },

            bitir(event) {

                let   filterArray = this.balyalar.filter(x => x.selected === true)
                filterArray.forEach(x => {
                    this.balyalaArray = this.balyalaArray + x.id + ";";
                    this.balyaNoArray = this.balyaNoArray + x.balyaNo + ";";
                })
                this.balyalaArray = this.balyalaArray.slice(0, -1);
                this.balyaNoArray = this.balyaNoArray.slice(0, -1);

            },

            detayGoster(event,item) {
                if (item.balyaNo) {
                    $.ajax({
                        url: BASE_URL+'netting/balyalama/balyalama.php',
                        type: 'post',
                        data: {
                            balyano: item.balyaNo,
                        },
                        success: function (response) {
                            $('.modal-body').html(response);
                            $('#balyalar').modal('show');

                        }
                    });
                }
            }
        }


    }
);