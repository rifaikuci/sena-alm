var termikGiris = new Vue({
        el: "#termik-giris",
        data: {
            isDisabled: true,
            sepetler: []
        },

    }
);

$('#termik_sepet_select2').on("change", async function () {

    termikGiris.sepetler = $(this).val();

    if ($(this).val() && $(this).val().length > 0)
        termikGiris.isDisabled = false
    else
        termikGiris.isDisabled = true

});


$('#termik_sepet_select2').select2({});