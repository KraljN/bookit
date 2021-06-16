<?php 
    if(isset($_GET["id"])){
        require_once("config/connection.php");
        $query = "SELECT p.first_name AS name, p.last_name AS surname, u.phone_number, u.username, u.addres, c.city_name, co.country_name, u.active, u.user_id AS id, u.email, r.role_id AS role 
                    FROM persons p INNER JOIN users u ON p.person_id = u.person_id
                    LEFT JOIN roles r ON u.role_id = r.role_id 
                    INNER JOIN cities c ON u.city_id = c.city_id 
                    INNER JOIN countries co ON c.country_id = co.country_id
                    WHERE u.user_id = ?";
        $paymentQuery = "SELECT p.card_number, p.card_verification_value 
                            FROM payments p INNER JOIN users_payments up ON p.payment_id = up.payment_id
                            WHERE up.user_id = ?";
    
        $userPrepare = $db -> prepare($query);
        $userPrepare -> execute([$_GET["id"]]);
        $user = $userPrepare -> fetch();
        $paymentPrepare = $db -> prepare($paymentQuery);
        $paymentPrepare -> execute([$user -> id]);
        $payments = $paymentPrepare -> fetchAll();
        $user -> payments = $payments;
    }
?>

<div id="admin">
  <input type="hidden" id="id" value="<?php if(isset($_GET["id"])) echo($_GET["id"]) ?>" />
  <div class="wraper">
    <?php include "views/fixed/admin-sidebar.php" ?>
    <div class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="f7afacc4-17e4-875c-6b50-56b077e542ea">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
          <div class="container-fluid">
            <div class="navbar-wrapper">
              <a class="navbar-brand"></a>
            </div>
            <button class="navbar-toggler mr-4" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
              <span class="sr-only">Toggle navigation</span>
              <span class="navbar-toggler-icon icon-bar"></span>
              <span class="navbar-toggler-icon icon-bar"></span>
              <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
            </div>
          </div>
        </nav>
        <div class="content px-0">
            <div class="col-12 col-xl-10 col-xxl-8 mx-auto">
              <div class="card" id="menu-item-add-form">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"><?php if(!isset($_GET["id"])) echo("Add"); else echo("Edit") ?> User</h4>
                  <p class="card-category"><?php if(!isset($_GET["id"])) echo("Add user to your site"); else echo("Edit user of your site") ?></p>
                </div>
                <div class="card-body">
                <form class="row" action="obrada.php" method="post">
            <div class="row m-0">
                <div class="col-md-6  form-group">
                    <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> name) ?>" class="form-control input-height mb-2" id="regName" name="regName" placeholder="First Name"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong name format (Exp. John)</span>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> surname) ?>" class="form-control input-height mb-2" id="regLastName" name="regLastName" placeholder="Last Name"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong last name format (Exp. Miles (Johnes))</span>
                </div>
                </div>
                <div class="col-md-12 form-group ">
                    <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> email) ?>" class="form-control input-height mb-2" id="email" name="email" placeholder="Email"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong mail format (john@gmail.com)</span>
                </div>
                <div class="row m-0">
                    <div class="<?php if(isset($_GET["id"])) echo("col-12"); else echo("col-md-6") ?> form-group ">
                        <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> username) ?>" class="form-control input-height mb-2" id="regUser" name="regUser" placeholder="Username"/>
                        <span class="required-star">*</span>
                        <span class="text-danger ml-2 wrong d-none">Minimum 5 maximum 15 ([A-z][0-9].-_ allowed)</span>
                    </div>
                    <?php if(!isset($_GET["id"])): ?>
                    <div class="col-md-6 form-group">
                        <input type="password" class="form-control input-height mb-2" id="regPassword" name="regPassword" placeholder="Password"/>
                        <span class="required-star">*</span>
                        <span class="text-danger ml-2 wrong d-none">Minimum 5 maximum 15 ([A-z][0-9].-_ allowed)</span>
                    </div>
                    <?php endif; ?>
                 </div>
            <div class="row m-0">
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control input-height mb-2" value="<?php if(isset($_GET["id"])) {
                                                                                                                        $singleDigits = str_split($user -> payments[0] -> card_number);
                                                                                                                        $output = "";
                                                                                                                        $index = 1;
                                                                                                                        foreach($singleDigits as  $digit){
                                                                                                                            $output .= $digit;
                                                                                                                            if($index % 4 == 0 && $index % 16 != 0) $output .="-";
                                                                                                                            $index++;
                                                                                                                        }
                                                                                                                        echo($output);
                                                                                                                    } ?>" id="card" name="card" placeholder="Credit card number"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong credit card format(Exact 12 digits)</span>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control input-height mb-2" value="<?php if(isset($_GET["id"])) echo($user -> payments[0] -> card_verification_value) ?>" id="cvv" name="cvv" placeholder="Card verification value (CVV)"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong CVV format(Last 3 numbers on back of your card)</span>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> country_name) ?>" class="form-control input-height mb-2" id="country" name="country" placeholder="Country"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong country format (Exp. Serbia)</span>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> city_name) ?>" class="form-control input-height mb-2" id="city" name="city" placeholder="Town/City"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong city format (Exp. Belgrade)</span>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> addres) ?>" class="form-control input-height mb-2" id="address" name="address" placeholder="Address"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong address format (Exp. Takovska 17)</span>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> phone_number) ?>" class="form-control input-height mb-2" id="number" name="number" placeholder="Phone number"/>
                <span class="required-star">*</span>
                <span class="text-danger ml-2 wrong d-none">Wrong mobile number format (Ex. +381621235234)</span>
            </div>
            <?php if(isset($_GET["id"])): ?>
            <div class="row m-0">
                <div class="container">
                    <div class="form-check d-flex align-items-center">
                    <input class="form-check-input mt-0" type="radio" name="role" id="roleUser" <?php if(isset($_GET["id"]) && $user->role == KORISNIK) echo(" checked='checked' ") ?> value="<?= KORISNIK ?>">
                    <label class="form-check-label text-dark" for="roleUser">
                        User
                    </label>
                    </div>
                </div>
            </div>
            <div class="row m-0">
                <div class="container">
                    <div class="form-check d-flex align-items-center">
                    <input class="form-check-input mt-0" type="radio" name="role" id="roleAdmin" <?php if(isset($_GET["id"]) && $user->role == ADMIN) echo(" checked='checked' ") ?> value="<?= ADMIN ?>">
                    <label class="form-check-label text-dark" for="roleAdmin">
                        Admin
                    </label>
                    </div>
                </div>
            </div>
            <?php endif ?>
            <div class="row m-0">
            <span class="text-success text-center font-weight-bold successInfo mx-auto"><?php if(!isset($_GET["id"])) echo("Successful made user"); else echo("User successfully updated. Reload page to see changes") ?></span>
            <span class="text-danger text-center font-weight-bold mb-3 errorInfo mx-auto">User with that username already exist</span>
            </div>
            <div class="row m-0">
            <input type="submit" value="<?php if(isset($_GET["id"])) echo("Edit"); else echo("Add") ?>" class="btn btn-primary ml-auto mt-3" name="register" id="<?php if(isset($_GET["id"])) echo("edit-user-submit"); else echo ("add-user-submit") ?>" value="Register"/>
                <div class="clearfix"></div>
            </div>
            <div class="row m-0">
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
            </div>
        </form>
                </div>
                </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>