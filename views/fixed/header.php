    <body>
        <input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]=="single-product"?"{$_GET["page"]};id={$_GET["id"]}":$_GET["page"];?>"/>
        <header>
            <div class="main-menu">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php?page=home"><img src="assets/img/logoOld.png" alt="logo"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                            <div id="navigation">
                            </div>
                            <a href="index.php?page=cart" id="cart-link">
                                <div class="cart mb-2 mx-auto">
                                    <span>
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                                    <span class="quntity">3</span>
                                </div>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </header>