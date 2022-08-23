<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Silakan Kirim Pesan Ke Klien</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CHATTING</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <section class="content">
                <div class="col col-lg-6">
                    <div class="card direct-chat direct-chat-primary">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">Direct Chat</h3>
                            <div class="card-tools">
                                <!-- <span title="3 New Messages" class="badge badge-primary">3</span> -->
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                                    <i class="fas fa-comments"></i>
                                    <span id="ijumlahnotif" class="badge badge-warning navbar-badge">
                                    <?php echo $semua_jumlah_notif; ?>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="didpesan" class="direct-chat-messages">
                                <?php foreach ($massage2 as $msg2) :
                                    if ($msg2['id_admin'] != '0') {
                                        echo
                                        '<div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">Admin</span>
                                </div>
                                <div class="direct-chat-text">'
                                            . $msg2['pesan'] . '
                                </div>
                            </div>';
                                    } elseif ($msg2['id_admin'] == '0') {
                                        echo
                                        '<div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">' . $nama_client . '</span>
                                </div>
                                <div class="direct-chat-text">'
                                            . $msg2['pesan'] . '                                
                                </div>
                            </div>';
                                    }
                                endforeach; ?>
                            </div>

                            <!-- //cara baru -->
                            <!-- <div class="direct-chat-contacts">
                                <ul id="ikontak" class="contacts-list">
                                    <li>   
                                        <?//php foreach ($akun as $ak) : ?>
                                            <?//php if ($ak['user_level'] == 2) { ?>
                                                <a href="<?//= base_url('admin/message/' . $ak['user_id']) ?>">
                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            <?//= $ak['user_name']; ?>
                                                            <small id="inotifperklien" class="contacts-list-date float-right">
                                                                <?//php
                                                                // foreach ($semua_id_chat_notif as $sicn) :
                                                                //     if($sicn->id_chat_notif!=NULL&&
                                                                //             $sicn->id_chat_notif==$ak['user_id']){
                                                                //         if($sicn->jumlah_notif==0){
                                                                //             echo '0';
                                                                //         }
                                                                //         else{
                                                                //             echo $sicn->jumlah_notif;
                                                                //         }   
                                                                //     } 
                                                                // endforeach; ?>
                                                            </small>
                                                        </span>
                                                    </div>
                                                </a>
                                            <?//php } ?>
                                        <?//php endforeach; ?>
                                    </li>
                                </ul>
                            </div> -->

                            <!-- //cara lama -->
                            <div class="direct-chat-contacts">
                                <ul id="ikontak" class="contacts-list">
                                    <li>
                                        <?php foreach ($semua_id_chat_notif as $sicn) : ?>
                                        <?php 
                                        if($sicn->jumlah_notif==0){
                                            '';
                                        }
                                        else{ ?>   
                                        <?//php foreach ($akun as $ak) : ?>
                                            <?//php if ($ak['user_level'] == 2) { ?>
                                                <!-- <a href="<?//= base_url('admin/message/' . $ak['user_id']) ?>" data-uid="<?//= $ak['user_id']; ?>" class="klikklien"> -->
                                                <!-- <a href="<?//= base_url('admin/message/' . $sicn->id_chat_notif) ?>" data-uid="<?//= $sicn->id_chat_notif; ?>" class="klikklien"> -->
                                                <a href="<?= base_url('admin/message/' . $sicn->id_chat_notif) ?>">
                                                
                                                    <!-- <a href="<? //= base_url('admin/message/'.$ak['user_id']) 
                                                                    ?>"> -->
                                                    <!-- <a href="" data-uid="<? //= $ak['user_id'];
                                                                                ?>" class="klikklien"> -->
                                                    <!-- <img class="contacts-list-img" src="<? //= base_url('assetslte') 
                                                                                                ?>/dist/img/user1-128x128.jpg" alt="User Avatar"> -->
                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            <?//= $ak['user_name']; ?>
                                                            <?= $sicn->nama_user; ?>
                                                            <small id="inotifperklien" class="contacts-list-date float-right">
                                                                <?php
                                                                if($sicn->jumlah_notif==0){
                                                                    echo '';
                                                                }
                                                                else{
                                                                    echo $sicn->jumlah_notif;
                                                                } 
                                                                ?>
                                                            </small>
                                                            <!-- <span class="contacts-list-msg">3</span> -->
                                                        <!-- </span> -->
                                                        <!-- <span class="badge badge-warning navbar-badge">3</span> -->
                                                        <!-- <span class="contacts-list-msg">3</span> -->
                                                    </div>
                                                <?//php } ?>
                                                </a>
                                            <?php } ?>
                                            <?php endforeach; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="input-group">
                                <input type="hidden" id="id_admin" name="id_admin" value="<?= $id_admin; ?>" class="form-control">
                                <input type="hidden" id="nama_user" name="nama_user" value="<?= $username; ?>" class="form-control">
                                <input type="hidden" id="id_client" name="id_client" value="<?= $id_client; ?>" class="form-control">
                                <input type="hidden" id="nama_client" name="nama_client" value="<?= $nama_client; ?>" class="form-control">
                                <input type="hidden" id="status" name="status" value="<?php echo "belum"; ?>" class="form-control">
                                <input type="text" id="pesan" name="pesan" placeholder="Type Message ..." class="form-control">
                                <span class="input-group-append">
                                    <button type="submit" class="store btn btn-primary">Send</button>
                                    <!-- <button type="submit" class="btn btn-primary">Send</button> -->

                                </span>
                            </div>
                            </form>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama Client</th>
                                    <th>Aksi</th>
                                </tr>    
                            </thead>
                            <tbody>
                                <?php 
                                $i=0;
                                foreach($akun as $ak) :
                                if ($ak['user_level'] == 2) { ?>
                                <tr>
                                    <td><?= $i++;?></td>
                                    <td><?= $ak['user_name'];?></td>
                                    <td>
                                        <a href="<?= base_url('admin/message/' . $ak['user_id']) ?>" class="btn btn-primary">CHAT</button>
                                    </td>
                                </tr>
                                <?php } 
                                endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                

            </section>
        </div>
    </div>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <!-- <script src="/assetslte/plugins/jquery/jquery.min.js"></script> -->
    <script>
        $('.store').click(function() {
            // console.log('storeklik');

            var value = {
                id_admin: $('#id_admin').val(),
                id_client: $('#id_client').val(),
                nama_user: $('#nama_user').val(),
                nama_client: $('#nama_client').val(),
                pesan: $('#pesan').val(),
                status: $('#status').val(),
            }
            $.ajax({
                url: '<?= base_url('/DashboardAdmin/store'); ?>',
                // url: 'http://localhost:8080/DashboardAdmin/message/'+id_client,
                // url: 'http://localhost:8080/DashboardAdmin/store',
                type: 'POST',
                data: value,
                // dataType: 'json',
            })

        })
        // $('.klikklien').click(function() {
        //     console.log('klikklien');
        //     var id=$(this).attr('data-uid');
        //     // console.log(id);
        //     var data = {
        //         // id_admin: $('#id_admin').val(),
        //         id_client: id,
        //         // nama_user: $('#nama_user').val(),
        //         // nama_client: $('#nama_client').val(),
        //         // pesan: $('#pesan').val(),
        //         // status: $('#status').val(),
        //     }
        //     // console.log(id_client);
        //     $.ajax({
        //         url: '<?//= base_url('/DashboardAdmin/klikklien'); ?>',
        //         type: 'POST',
        //         data: data,
        //         // dataType: 'json',
        //     })
        // })
        
        $(document).ready(function() {
            
            Pusher.logToConsole = true;

            var pusher = new Pusher('e0bd82d32cf9d6ef3c0f', {
            // var pusher = new Pusher('40ffd99f64d712cc1ceb', {
                cluster: 'ap1'
            });

            // var idus=$(this).data('id_client');
            var idus = $('#id_client').val()
            console.log(idus);
            var channel = pusher.subscribe(idus);

            channel.bind('my-event', function(data) {
                // alert(JSON.stringify(data));
                // console.log('ber');
                addData(data);
                hapuschat();
            });

            function addData(data) {
                // console.log('adddata' + data[0].id_admin);
                var str = '';
                for (var z in data) {
                    str +=
                        (data[z].id_admin != '0') ?
                        // '<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">Admin</span><span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span></div><img class="direct-chat-img" src="<?php base_url('assetslte/dist/img/user1-128x128.jpg') ?>" alt="message user image"><div class="direct-chat-text">'+data[z].pesan+'</div></div>' :
                        // '<div class="direct-chat-msg right"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">Klien</span><span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span></div><img class="direct-chat-img" src="<?php base_url('assetslte/dist/img/user3-128x128.jpg') ?>" alt="message user image"><div id="pesan" name="pesan" class="direct-chat-text">'+data[z].pesan+'</div></div>';
                        '<div class="direct-chat-msg">' +
                        '<div class="direct-chat-infos clearfix">' +
                        '<span class="direct-chat-name float-left">Admin</span>' +
                        '</div>' +
                        // '<img class="direct-chat-img" src='+windows.location('assetslte/dist/img/user1-128x128.jpg')+' alt="message user image">'+
                        '<div class="direct-chat-text">' +
                        data[z].pesan +
                        '</div>' +
                        '</div>' :
                        '<div class="direct-chat-msg right">' +
                        '<div class="direct-chat-infos clearfix">' +
                        '<span class="direct-chat-name float-right">' + data[z].nama_client + '</span>' +
                        '</div>' +
                        // '<img class="direct-chat-img" src='+windows.location('assetslte/dist/img/user3-128x128.jpg')+' alt="message user image">'+
                        '<div class="direct-chat-text">' +
                        data[z].pesan +
                        '</div>' +
                        '</div>';
                }
                $('#didpesan').html(str);
            }

            function hapuschat() {
                document.getElementById('pesan').value = '';
            }

            var channel2 = pusher.subscribe('jumlah_notif_admin');
            channel2.bind('my-event', function(data) {
                var str = '';
                var vjumlahnotif=0;
                // for (var z in data) {
                //     vjumlahnotif++;
                //     data[z].jumlah
                // }
                $('#ijumlahnotif').html(data.jumlah_notif);
                $('#inotiftemplate').html(data.jumlah_notif);
                // $('#ikontak').html(vjumlahnotif);
            });

            var channel3 = pusher.subscribe('notif_admin_perklien');
            channel3.bind('my-event', function(data) {
                var str = '';
                // var vjumlahnotif=0;
                for (var z in data) {
                    str +=
                        (data[z].jumlah_notif==0)?
                        '':
                        '<li>'+
                            // '<a href=<?//= base_url('admin/message')?>'+'/'+data[z].id_chat_notif+ 'data-uid='+data[z].id_chat_notif+'class=klikklien>'+
                            '<a href=<?= base_url('admin/message')?>'+'/'+data[z].id_chat_notif+'>'+
                                '<div class="contacts-list-info">'+
                                    '<span class="contacts-list-name">'+
                                        data[z].nama_user+
                                        '<small id="inotifperklien" class="contacts-list-date float-right">'+
                                            // (data[z].jumlah_notif==0)?
                                            //     '':
                                            data[z].jumlah_notif+         
                                        '</small>'+
                                    '</span>'+
                                '</div>'+
                            '</a>'+
                        '</li>';
                    // vjumlahnotif++;
                }
                // var vjum = $('#ijumlahnotif').val();

                
                // $('#inotiftemplate').html(vjumlahnotif);
                $('#ikontak').html(str);
                // $('#ijumlahnotif').html(vjum-vjumlahnotif);
            });
        })
    </script>

    <?= $this->endSection(); ?>