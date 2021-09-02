$(document).ready(function () {
    $('.profilim').click(function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/sena/netting/goruntule/profil.php',
            type: 'post',
            data: {id: id},
            success: function (response) {
                $('.modal-body').html(response);
                $('#profil').modal('show');
            }
        });
    });
});


$(document).ready(function () {
    $('.malzemem').click(function () {
        var partino = $(this).data('partino');
        var firmaId = $(this).data('firma');
        var malzemeId = $(this).data('malzeme');
        var adet = $(this).data('adet');

        $.ajax({
            url: '/sena/netting/goruntule/malzeme.php',
            type: 'post',
            data: {partino: partino, firmaId: firmaId, malzemeId: malzemeId, adet: adet},
            success: function (response) {
                $('.modal-body').html(response);
                $('#malzeme').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $('.boyam').click(function () {
        var partino = $(this).data('partino');
        var firmaId = $(this).data('firma');
        var boyaTuru = $(this).data('boya');
        var sicaklik = $(this).data('sicaklik');
        var cins = $(this).data('cins');
        var kilo = $(this).data('kilo');
        var adet = $(this).data('adet');
        $.ajax({
            url: '/sena/netting/goruntule/boya.php',
            type: 'post',
            data: {
                partino: partino,
                firmaId: firmaId,
                boyaTuru: boyaTuru,
                sicaklik: sicaklik,
                cins: cins,
                kilo: kilo,
                adet: adet
            },
            success: function (response) {
                $('.modal-body').html(response);
                $('#boya').modal('show');
            }
        });
    });
});


$(document).ready(function () {
    $('.biyetim').click(function () {
        var partino = $(this).data('partino');
        var firmaId = $(this).data('firma');
        var alasimId = $(this).data('alasim');
        var adet = $(this).data('adet');
        var boy = $(this).data('boy');
        var cap = $(this).data('cap');
        $.ajax({
            url: '/sena/netting/goruntule/biyet.php',
            type: 'post',
            data: {partino: partino, firmaId: firmaId, alasimId: alasimId, adet: adet, boy: boy, cap: cap},
            success: function (response) {
                $('.modal-body').html(response);
                $('#biyet').modal('show');
            }
        });
    });
});