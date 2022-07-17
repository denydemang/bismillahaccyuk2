<?= $this->extend('layouts/template'); ?>


<?= $this->section('content') ?>
<!-- Start Navbar -->
<?= $this->include('layouts/navbar'); ?>
<!-- end navbar -->

<!-- Start Carousel -->
<section id="home" class="pt-lg-5 mt-lg-3">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/img/iloveimg-resized/hero.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-block d-md-block">
                    <h5>PT ADIKA JAYA ENGINEERING</h5>
                    <p>Kami bergerak di bidang General Contractor & Supplier</p>
                    <div class="slider-btn">
                        <!-- <button class="btn btn-1">Layanan Kami</button> -->
                        <a href="#about" class="btn btn-2 text-decoration-none">ABOUT US</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/img/iloveimg-resized/hero2.jpg" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-block d-md-block">
                    <h5 class="h5">MULAI BERGERAK BERSAMA KAMI</h5>
                    <p>Because We Work With Masterpice Quality</p>
                    <div class="slider-btn">
                        <!-- <button class="btn btn-1">Layanan Kami</button> -->
                        <button class="btn btn-2">AJUKAN TAWARAN</button>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/img/iloveimg-resized/hero3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-block d-md-block">
                    <h5 class="h5">MULAILAH BERGERAK BERSAMA KAMI</h5>
                    <p>Because We Work With Masterpice Quality</p>
                    <div class="slider-btn">
                        <!-- <button class="btn btn-1">Layanan Kami</button> -->
                        <button class="btn btn-2">AJUKAN TAWARAN</button>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<!-- end carousel -->

<!-- main -->
<section id="produk" class="pt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-lg-5 text-center">
                <h1>Galeri Produk</h1>
            </div>
        </div>
        <div class="row pt-lg-5">
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero2.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero3.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
        </div>
    </div>

</section>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#A2D9FF" fill-opacity="1" d="M0,128L34.3,133.3C68.6,139,137,149,206,133.3C274.3,117,343,75,411,53.3C480,32,549,32,617,37.3C685.7,43,754,53,823,80C891.4,107,960,149,1029,170.7C1097.1,192,1166,192,1234,186.7C1302.9,181,1371,171,1406,165.3L1440,160L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
</svg>
<section id="pekerjaan" class="pt-lg-5" style="background-color:#A2D9FF">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-lg-5 text-center">
                <h1>Galeri Pekerjaan</h1>
            </div>
        </div>
        <div class="row pt-lg-5">
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero2.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero3.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/iloveimg-resized/hero.jpg" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffff" fill-opacity="1" d="M0,128L34.3,133.3C68.6,139,137,149,206,133.3C274.3,117,343,75,411,53.3C480,32,549,32,617,37.3C685.7,43,754,53,823,80C891.4,107,960,149,1029,170.7C1097.1,192,1166,192,1234,186.7C1302.9,181,1371,171,1406,165.3L1440,160L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
    </svg>
</section>

<section id="customer" class="pt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-lg-5 text-center">
                <h1>Kustomer Kami</h1>
            </div>
        </div>
        <div class="row pt-lg-5">
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/polines.png" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/pln.png" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/cnbm.png" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
            <div class="col-lg-3">
                <figure class="figure">
                    <img src="<?= base_url(); ?>/img/schneider.png" class="figure-img img-fluid rounded" alt="...">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            </div>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#A2D9FF" fill-opacity="1" d="M0,128L34.3,133.3C68.6,139,137,149,206,133.3C274.3,117,343,75,411,53.3C480,32,549,32,617,37.3C685.7,43,754,53,823,80C891.4,107,960,149,1029,170.7C1097.1,192,1166,192,1234,186.7C1302.9,181,1371,171,1406,165.3L1440,160L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
    </svg>
</section>

<section id="jargon" class="text-center py-lg-5" style="background-color:#A2D9FF">
    <h1>"Mulailah bergerak bersama kami,
        Because
        we work with masterpice quality"</h1>
</section>
<section id="about" class="pt-lg-5" style="background-color: #A2D9FF">
    <div class="container pb-lg-5">
        <div class="col-lg-12 pt-lg text-center">
            <h1>About Us</h1>
        </div>
        <div class="row pt-lg-3">
            <div class="col-lg-6">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos, facilis! Recusandae tempore laborum inventore rem iusto architecto aliquam officiis repellat. Error ipsum at sit sapiente assumenda architecto debitis doloremque ullam.
                Odio rem sapiente nihil vel ut dolorum cum laudantium, reiciendis repudiandae, dicta quas in quia, accusantium est neque necessitatibus corrupti exercitationem nostrum! Eligendi ea repellat labore quaerat nobis. Minus, eaque.
            </div>
            <div class="col-lg-6">
                Lorem ipsumsss, dolor sit amet consectetur adipisicing elit. Harum quam excepturi nam maiores porro voluptas rem minus pariatur consequuntur ratione, rerum natus, doloremque dolorem numquam eveniet voluptate fuga nobis ex.
                Provident, veritatis! Cumque reprehenderit consectetur error cupiditate nam eum, voluptatibus exercitationem voluptatem officiis! Dolorum blanditiis nam veniam dolorem, corrupti repellendus nemo neque temporibus omnis odit, mollitia vel veritatis illum laborum?
            </div>
        </div>
    </div>
</section>


<!-- end main -->

<!-- Start Footer -->
<?= $this->include('layouts/footer'); ?>
<!-- end footer -->
<?= $this->endSection(); ?>