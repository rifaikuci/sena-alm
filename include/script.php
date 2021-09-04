<script src=<?php echo base_url() . "plugins/jquery/jquery.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/bootstrap/js/bootstrap.bundle.min.js" ?>></script>
<script src=<?php echo base_url() . "dist/js/adminlte.min.js" ?>></script>
<script src=<?php echo base_url() . "dist/js/demo.js" ?>></script>
<script src=<?php echo base_url() . "plugins/select2/js/select2.full.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/ekko-lightbox/ekko-lightbox.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables/jquery.dataTables.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables-bs4/js/dataTables.bootstrap4.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables-responsive/js/dataTables.responsive.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables-responsive/js/responsive.bootstrap4.min.js" ?>></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src=<?php echo base_url() . "dist/js/goruntule.js" ?>></script>
<script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({gutterPixels: 3});
        $('.btn[data-filter]').on('click', function () {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    })
</script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

    });
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script type="text/javascript" src=<?php echo base_url() . "dist/js/veri-giris.js" ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "dist/js/kalipci.js" ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "dist/js/takim.js" ?>></script>

