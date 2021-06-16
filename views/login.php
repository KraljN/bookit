<?php 
include "models/capchas/generateCapchaText.php"
// $opseg = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789";
// $_SESSION["capchaText"] = rand(10000, 999999)
?>
<section class="static about-sec">
    <div class="container">
        <h1>Login</h1>
        <p>Login into our site so you can make purchases</p>
        <div class="form">
            <form action="obrada.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <input  class="form-control" placeholder="Enter Username" required="required" id="logUser"/>
                        <span class="required-star">*</span>
                        <span class="text-danger ml-2 wrong d-none">Minimum 5 maximum 15 ([A-z][0-9].-_)</span>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="password" placeholder="Enter Password" id="logPass" required="required"/>
                        <span class="required-star">*</span>
                        <span class="text-danger ml-2 wrong d-none">Minimum 5 maximum 15 ([A-z][0-9].-_)</span>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mx-auto mt-3 d-flex justify-content-center align-items-center">
                            <img src="models/capchas/getCapchaPicture.php" class="m-0" alt="capcha picture"/>
                        </div>
                        <div class="col-md-6 mx-auto mt-3 d-flex">
                            <input  class="form-control" placeholder="Enter Capcha" required="required" id="tbCapcha"/>
                            <span class="required-star">*</span>
                        </div>
                    </div>
                    <div class="row">
                        <span class="text-danger ml-4 mt-1  d-none wrong">Minimum 5 maximum 6 letters or numbers</span>
                    </div>
                    <div class="col-md-12 col-lg-8 form-group d-flex flex-column">
                        <button class="btn black button-width" id="login">Login</button>
                        <span class="text-danger font-weight-bold ml-1 mt-3 loginInfo"></span>
                    </div>

                </div>
                <?php if(isset($_SESSION["greske"])): ?>
                    <ul class="text-center">
                        <?php foreach($_SESSION["greske"] as $greska): ?>
                            <li class="text-danger"><?= $greska ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                    endif;
                    unset($_SESSION["greske"]);
                ?>
            </form>
        </div>
        <h2 class="mt-5 mt-sm-0">Register</h1>
        <p>If you already don't have account, you are free to open it in just a moment.</p>
        <form class="row" action="obrada.php" method="post">
            <div class="row">
                <div class="col-md-6  form-group">
                    <input type="text" class="form-control input-height mb-2" id="regName" name="regName" placeholder="First Name"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong name format (Exp. John)</span>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control input-height mb-2" id="regLastName" name="regLastName" placeholder="Last Name"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong last name format (Exp. Miles (Johnes))</span>
                </div>
                </div>
                <div class="col-md-12 form-group ">
                    <input type="text" class="form-control input-height mb-2" id="email" name="email" placeholder="Email"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong mail format (john@gmail.com)</span>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group ">
                        <input type="text" class="form-control input-height mb-2" id="regUser" name="regUser" placeholder="Username"/>
                        <span class="required-star">*</span>
                        <span class="text-danger ml-2 wrong d-none">Minimum 5 maximum 15 ([A-z][0-9].-_ allowed)</span>
                    </div>
                    <div class="col-md-6 form-group">
                        <input type="password" class="form-control input-height mb-2" id="regPassword" name="regPassword" placeholder="Password"/>
                        <span class="required-star">*</span>
                        <span class="text-danger ml-2 wrong d-none">Minimum 5 maximum 15 ([A-z][0-9].-_ allowed)</span>
                    </div>
                 </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control input-height mb-2" id="card" name="card" placeholder="Credit card number"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong credit card format(Exact 16 digits)</span>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control input-height mb-2" id="cvv" name="cvv" placeholder="Card verification value (CVV)"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong CVV format(Last 3 numbers on back of your card)</span>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" class="form-control input-height mb-2" id="country" name="country" placeholder="Country"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong country format (Exp. Serbia)</span>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" class="form-control input-height mb-2" id="city" name="city" placeholder="Town/City"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong city format (Exp. Belgrade)</span>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" class="form-control input-height mb-2" id="address" name="address" placeholder="Address"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong address format (Exp. Takovska 17)</span>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" class="form-control input-height mb-2" id="number" name="number" placeholder="Phone number"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong mobile number format (Ex. +381621235234)</span>
            </div>
            <div class="col-md-12 form-group d-flex flex-column">
            <span class="text-success text-center font-weight-bold successInfo">Succefuly made account</span>
            <span class="text-danger text-center font-weight-bold mb-3 errorInfo">User with that username already exist</span>
                <button type="submit" value="submit" class="btn button-width" name="register" id="register">
                    Register
                </button>
                <?php if(isset($_SESSION["greskeRegister"])): ?>
                    <ul class="text-center">
                        <?php foreach($_SESSION["greskeRegister"] as $greska): ?>
                            <li class="text-danger"><?= $greska ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php
                 endif;
                 unset($_SESSION["greskeRegister"]);
                 ?>
            </div>
        </form>
    </div>
</section>