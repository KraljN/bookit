  <?php
       if(isset($_GET["logout"])){
            unset($_SESSION["korisnik"]);
        } 
    ?>
   <body>
        <?php var_dump($_SESSION)?>
        <input type="hidden" name="page" id="page" value="<?php 
            if(isset($_GET["page"])){
                echo $_GET["page"]=="single-product"?"{$_GET["page"]};id={$_GET["id"]}":$_GET["page"];
            }
            else{
                echo "home";
            }
        ?>"/>
        <input type="hidden" name="isLogged" id="isLogged" value="
        <?php echo isset($_SESSION["korisnik"])?"true":"false" ?>
        ">
        <header>
            <div class="main-menu">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php?page=home"><img src="assets/img/logoOld.png" alt="logo"></a>
                        <button class="navbar-toggler mx-auto mx-sm-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto"> 
                                <li class="navbar-item text-start text-sm-center mx-auto" id="navigation">
                                <a 
                                href=<?php if(isset($_SESSION["korisnik"])){
                                            echo("index.php?page=login&logout=true");
                                        }
                                        else{
                                            echo("index.php?page=login");
                                        } ?> 
                                class="nav-link"
                                >
                                <?php if(isset($_SESSION["korisnik"])){
                                            echo("Logout");
                                        }
                                        else{
                                            echo("Login");
                                        } ?> 
                                </a>
                                </li>
                                </ul>
                            <a href="index.php?page=shopping-cart" id="cart-link">
                                <div class="cart mb-2 mx-auto">
                                    <span>
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                                    <span class="quantity">3</span>
                                </div>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </header>