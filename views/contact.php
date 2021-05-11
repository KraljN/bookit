<div class="container text-center" id="contactTitle">
    <h1>Contact Us & Informations</h1>
</div>
<div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="address">
                        <h2 class="mb-3">Our Informations</h2>
                        <h6 class="my-3">The Book-It Shop, Zdravka Celara 16 Belgrade, Serbia</h6>
                        <h6 class="my-3">Call : +381 11 12345</h6>
                        <h6 class="my-3">Email : info@book-it.com</h6>
                    </div>
                    <div class="timing">
                        <h3 class="mb-3">Timing</h3>
                        <h6 class="my-3">Mon - Fri: 7am - 10pm</h6>
                        <h6 class="my-3">​​Saturday: 8am - 2pm</h6>
                        <h6 class="my-3">​Sunday: Closed</h6>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form">
                        <h2 class="mb-3">Contact Us</h2>
                        <h6 class="mt-3 mb-5">If you have any questions don't hesitate to sent us a mail.</h6>
                        <form action="log.php" method="POST" name="contactForm" id="contactForm">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input placeholder="Name" id="name" class="form-control" required/>
                                    <span class="required-star">*</span>
                                    <span class="text-danger  wrong d-none">Wrong name format (Exp. Miles (Johnes))</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="email" id="email" class="form-control" placeholder="Email" required/>
                                    <span class="required-star">*</span>
                                    <span class="text-danger  wrong d-none">Wrong mail format (john@gmail.com)</span>
                                </div>
                                <div class="col-md-6 mb-1 mb-sm-4 text-center" id="subject"></div>
                                <div class="col-md-6 mb-4">
                                    <input id="otherTb" class="form-control d-none" placeholder="Other Subject..." required/>
                                    <span class="text-danger  wrong d-none">Wrong subject format (Exp. Other Problematic Subject)</span>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Message" cols="15" rows="5" id="message"></textarea>
                                    <span class="required-star">*</span>
                                    <span class="text-danger  wrong d-none">Message cannot be empty</span>
                                </div>
                                <div class="col-md-12 pt-4">
                                    <span class="text-success text-center font-weight-bold successInfo">Message succefuly sent</span></br>
                                    <span class="text-danger text-center font-weight-bold mb-3 errorInfo">Error while trying to sent message</span>
                                    <?php if(isset($_SESSION["greske"])): ?>
                                        <ul class="text-center list-unstyled">
                                            <?php foreach($_SESSION["greske"] as $greska): ?>
                                                <li class="text-danger"><?= $greska ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php
                                    endif;
                                    unset($_SESSION["greske"]);
                                    ?>
                                    <?php if(isset($_SESSION["greskeOther"])): ?>
                                        <li class="text-danger"><?= $_SESSION["greskeOther"] ?></li>
                                    <?php 
                                    endif;
                                    unset($_SESSION["greskeOther"]);
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn orangeSubmit" id="submitForm">Submit Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed shadow d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#modalAbout" id="autor"><i class="fas fa-address-card plava"></i></div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalAbout" pr-0 aria-hidden="true">
            <div class="modal-dialog modalSirina" role="document">
                <div class="modal-content h-100">
                    <div class="row">
                        <div class="model-body px-5 pt-1 pb-5 position-relative">
                            <button type="button" class="close position-absolute izlaz" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div id="about" class="col-12">
                                <div class="row text-center d-block mt-3">
                                    <h3>About me</h3>
                                    <hr class="w-25 mt-2 mb-3"/>
                                </div>
                                <div class="row">
                                <div class="col-10 col-sm-5 mx-auto">
                                    <img src="assets/img/autor.jpg" alt="autor" class="img-fluid rounded"/>
                                </div>
                                <div class="col-10 col-sm-7 d-flex mx-auto flex-column align-items-center justify-content-center">
                                    <ul id='info' class="p-0 m-0 list-unstyled">
                                        <li class="mb-3 mt-3 mt-sm-0">Name: Nikola Kralj</li>
                                        <li class="my-3">Email: nikolakralj9@gmail.com</li>
                                        <li class="my-3">Index number: 76/18</li>
                                        <li class="my-3">Year of study: Second</li>
                                        <li class="mt-3">Site made for purpose of Workshop for PHP </li>
                                    </ul>
                                    <a href="models/contact-us/authorWord.php" class="btn purpleSubmit mt-4 text-uppercase text-white" id="authorDownload"><i class="fas fa-file-download mr-2 te"></i>Download</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>