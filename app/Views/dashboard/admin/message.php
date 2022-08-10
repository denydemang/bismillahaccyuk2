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
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="didpesan" class="direct-chat-messages">
                        <?php foreach ($massage2 as $msg2) : 
                            if($msg2['id_admin']!='0') { 
                             echo
                            '<div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">Admin</span>
                                </div>
                                <div class="direct-chat-text">'
                                    .$msg2['pesan'].'
                                </div>
                            </div>';
                             }

                            elseif($msg2['id_admin']=='0') {
                             echo
                            '<div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">'.$nama_client.'</span>
                                </div>
                                <div class="direct-chat-text">'
                                    .$msg2['pesan'].'                                
                                </div>
                            </div>';
                            }
                            endforeach; ?>                       
                        </div>

                        <div class="direct-chat-contacts">
                            <ul class="contacts-list">
                                <li>
                                    <?php foreach ($akun as $ak) : ?>
                                        <?php if($ak['user_level']==2) { ?>
                                        <a href="<?= base_url('admin/message/'.$ak['user_id']) ?>" data-uid="<?= $ak['user_id'];?>" class="klikklien">
                                        <!-- <a href="<?//= base_url('admin/message/'.$ak['user_id']) ?>"> -->
                                        <!-- <a href="" data-uid="<?//= $ak['user_id'];?>" class="klikklien"> -->
                                        <!-- <img class="contacts-list-img" src="<?//= base_url('assetslte') ?>/dist/img/user1-128x128.jpg" alt="User Avatar"> -->
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                            <?= $ak['user_name']; ?>
                                                <!-- <small class="contacts-list-date float-right">2/28/2015</small> -->
                                            </span>
                                            <!-- <span class="contacts-list-msg">How have you been? I was...</span> -->
                                        </div>
                                        <?php } ?>
                                    </a>
                                    <?php endforeach; ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-footer">  
                            <div class="input-group">
                                <input type="hidden" id="id_admin" name="id_admin" value="<?= $id_admin;?>" class="form-control">
                                <input type="hidden" id="nama_user" name="nama_user" value="<?= $username;?>" class="form-control">
                                <input type="hidden" id="id_client" name="id_client" value="<?= $id_client;?>" class="form-control">
                                <input type="hidden" id="nama_client" name="nama_client" value="<?= $nama_client;?>" class="form-control">
                                <input type="text" id="pesan" name="pesan" placeholder="Type Message ..." class="form-control">
                                <span class="input-group-append">
                                    <button type="submit" class="store btn btn-primary">Send</button>
                                    <!-- <button type="submit" class="btn btn-primary">Send</button> -->
                                
                                </span>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <script src="/assetslte/plugins/jquery/jquery.min.js"></script> -->
<script>
$('.store').click(function(){
        console.log('storeklik');
            
        var value = {
            id_admin: $('#id_admin').val(),
            id_client: $('#id_client').val(),
            nama_user: $('#nama_user').val(),
            nama_client: $('#nama_client').val(),
            pesan: $('#pesan').val(),	
        }
        $.ajax({
            url: '<?= base_url('/DashboardAdmin/store');?>',
            // url: 'http://localhost:8080/DashboardAdmin/message/'+id_client,
            // url: 'http://localhost:8080/DashboardAdmin/store',
            type: 'POST',
            data: value,
            // dataType: 'json',
        })
        
    })
$(document).ready(function(){
    Pusher.logToConsole = true;

        // var pusher = new Pusher('e0bd82d32cf9d6ef3c0f', {
            var pusher = new Pusher('40ffd99f64d712cc1ceb', {
            cluster: 'ap1'
            });

        // var idus=$(this).data('id_client');
        var idus=$('#id_client').val()
        console.log(idus);
        var channel = pusher.subscribe(idus);

        channel.bind('my-event', function(data) {
            // alert(JSON.stringify(data));
            // console.log('ber');
            addData(data);
            hapuschat();
        });
            function addData(data){
                console.log('adddata'+data[0].id_admin);
                var str='';
                for(var z in data){
                    str +=
                    (data[z].id_admin != '0') ?
                    // '<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">Admin</span><span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span></div><img class="direct-chat-img" src="<?php base_url('assetslte/dist/img/user1-128x128.jpg')?>" alt="message user image"><div class="direct-chat-text">'+data[z].pesan+'</div></div>' :
                    // '<div class="direct-chat-msg right"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">Klien</span><span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span></div><img class="direct-chat-img" src="<?php base_url('assetslte/dist/img/user3-128x128.jpg')?>" alt="message user image"><div id="pesan" name="pesan" class="direct-chat-text">'+data[z].pesan+'</div></div>';
                    '<div class="direct-chat-msg">'+
                        '<div class="direct-chat-infos clearfix">'+
                            '<span class="direct-chat-name float-left">Admin</span>'+
                        '</div>'+
                        // '<img class="direct-chat-img" src='+windows.location('assetslte/dist/img/user1-128x128.jpg')+' alt="message user image">'+
                        '<div class="direct-chat-text">'
                        +data[z].pesan+
                        '</div>'+
                    '</div>' :
                    '<div class="direct-chat-msg right">'+
                        '<div class="direct-chat-infos clearfix">'+
                            '<span class="direct-chat-name float-right">'+data[z].nama_client+'</span>'+
                        '</div>'+
                        // '<img class="direct-chat-img" src='+windows.location('assetslte/dist/img/user3-128x128.jpg')+' alt="message user image">'+
                        '<div class="direct-chat-text">'
                            +data[z].pesan+                                
                        '</div>'+
                    '</div>';
                }
                $('#didpesan').html(str);
                }
            function hapuschat(){
                document.getElementById('pesan').value='';
                }
})
</script>

<?= $this->endSection(); ?>