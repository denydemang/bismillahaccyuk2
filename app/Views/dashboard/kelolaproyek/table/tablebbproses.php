<div class="table-responsive text-nowrap">
    <table id="tablebb" class="table table-striped table-sm">
        <thead>
            <th>No</th>
            <th>Id Bahan Baku</th>
            <th>Nama Bahan</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Jumlah Dibeli</th>
            <th>Aksi</th>

        </thead>
        <tbody>

        </tbody>

    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablebb').DataTable({
            "columnDefs": [{
                orderable: false,
                targets: [3, 4, 5, 6, 7, 8, 9]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
        });
    })
</script>