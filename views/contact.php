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
                                    <button class="btn black" id="submitForm">Submit Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>