<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>

<div class="content-wrapper">
    <div class="card card-primary card-outline col-lg-8 m-5">
        <div class="card-header">
            <h3 class="card-title">Kirim Email Ke Klien</h3>
            <div class="pesanemail" data-pesanemail="<?= session()->getFlashdata('pesanemail'); ?>"></div>
        </div>
        <div class="card-body">
            <form id="formkirimemail" method="post" action="<?= base_url(); ?>/DashboardAdmin/kirimfileemail" enctype="multipart/form-data">
                <div class="form-group">
                    <input class="form-control penerimaemail" readonly name="penerimaemail" placeholder="To*:" value="<?= $emailkirim; ?>">
                    <input type="hidden" value="<?= $ajuan; ?>" name="idajuan">
                </div>
                <div class="form-group">
                    <input class="form-control" name="subjectemail" placeholder="Subject*:">
                </div>
                <div class="form-group">
                    <textarea class="form-control pesanemail" name="pesanemail" rows="10" cols="50"></textarea>

                </div>
                <div class="form-group ">
                    <div class="custom-file col-8">
                        <label for="exampleFormControlFile1">Pilih File lampiran *</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="uploadfileemail">
                    </div>
                </div>
                <div class="float-right">
                    <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                </div>

            </form>

        </div>
    </div>
</div>


<script>
    $('.daftarklien').DataTable({
        // "lengthChange": false,
        "columnDefs": [{
            orderable: false,
            targets: [0, 1, 2]
        }],
        "info": true,
        "paging": false,
        "scrollY": '130px',
        // "scrollX": true,
        // "scrollCollapse": true,
    })
    $('.btndataklien').click(function() {
        let data = $(this).data('id')

        $.ajax({
            url: "http://localhost:8080/DashboardAdmin/getemailklien",
            type: "post",
            data: {
                id: data
            },
            dataType: "json",
            success: function(response) {

                $('.penerimaemail').val(response['email'])
                // $('.idajuanbb').val(response[0]['idajuan']);
                // $('.user_idbb').val(response[0]['user_id']);
                // $('.namaproyekbb').val(response[0]['namaproyek']);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })
    let pesanemail = $('.pesanemail').data('pesanemail');


    if (pesanemail) {
        if (pesanemail == 1) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Email berhasil Dikirim',
                showConfirmButton: true,
            })
        } else {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Email Gagal Dikirim',
                text: pesanemail,
                showConfirmButton: true,
            })
        }
    }
</script>


<?= $this->endSection(); ?>