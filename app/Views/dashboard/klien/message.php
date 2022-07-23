<?= $this->extend('dashboard/klien/template'); ?>
<?= $this->section('dashboardklien'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Silakan Kirim Pesan Ke Admin</h1>
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
                            <span title="3 New Messages" class="badge badge-primary">3</span>
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
                        <div class="direct-chat-messages">

                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">Admin</span>
                                    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                                </div>
                                <img class="direct-chat-img" src="<?= base_url('assetslte') ?>/dist/img/user1-128x128.jpg" alt="message user image">
                                <div class="direct-chat-text">
                                    Tawaran Sedang Kami Tinjau
                                </div>
                            </div>
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Klien</span>
                                    <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                                </div>
                                <img class="direct-chat-img" src="<?= base_url('assetslte') ?>/dist/img/user3-128x128.jpg" alt="message user image">
                                <div class="direct-chat-text">
                                    Oke Kak Saya Tunggu
                                </div>
                            </div>
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">Admin</span>
                                    <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                                </div>
                                <img class="direct-chat-img" src="<?= base_url('assetslte') ?>/dist/img/user1-128x128.jpg" alt="message user image">
                                <div class="direct-chat-text">
                                    Mohon Ditunggu Ya
                                </div>
                            </div>
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Klien</span>
                                    <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                                </div>
                                <img class="direct-chat-img" src="<?= base_url('assetslte') ?>/dist/img/user3-128x128.jpg" alt="message user image">
                                <div class="direct-chat-text">
                                    Siap Kak
                                </div>
                            </div>
                        </div>
                        <div class="direct-chat-contacts">
                            <ul class="contacts-list">
                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="<?= base_url('assetslte') ?>/dist/img/user1-128x128.jpg" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                Count Dracula
                                                <small class="contacts-list-date float-right">2/28/2015</small>
                                            </span>
                                            <span class="contacts-list-msg">How have you been? I was...</span>
                                        </div>

                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="<?= base_url('assetslte') ?>/dist/img/user7-128x128.jpg" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                Sarah Doe
                                                <small class="contacts-list-date float-right">2/23/2015</small>
                                            </span>
                                            <span class="contacts-list-msg">I will be waiting for...</span>
                                        </div>

                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="<?= base_url('assetslte') ?>/dist/img/user3-128x128.jpg" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                Nadia Jolie
                                                <small class="contacts-list-date float-right">2/20/2015</small>
                                            </span>
                                            <span class="contacts-list-msg">I'll call you back at...</span>
                                        </div>

                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="<?= base_url('assetslte') ?>/dist/img/user5-128x128.jpg" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                Nora S. Vans
                                                <small class="contacts-list-date float-right">2/10/2015</small>
                                            </span>
                                            <span class="contacts-list-msg">Where is your new...</span>
                                        </div>

                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="<?= base_url('assetslte') ?>/dist/img/user6-128x128.jpg" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                John K.
                                                <small class="contacts-list-date float-right">1/27/2015</small>
                                            </span>
                                            <span class="contacts-list-msg">Can I take a look at...</span>
                                        </div>

                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="<?= base_url('assetslte') ?>/dist/img/user8-128x128.jpg" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                Kenneth M.
                                                <small class="contacts-list-date float-right">1/4/2015</small>
                                            </span>
                                            <span class="contacts-list-msg">Never mind I found...</span>
                                        </div>

                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="card-footer">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary">Send</button>
                                </span>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </section>
    </div>


</div>
<?= $this->endSection(); ?>