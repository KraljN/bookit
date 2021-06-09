<?php require_once "config/connection.php"?>
<!-- NOTIFICATION -->
<div class="row">
        <div class="col-10 col-sm-6 col-md-5 col-lg-4  justify-content-center align-items-center mx-auto fixed-bottom rounded" id="popUp">
            <p class=" text-white my-2 text-center"></p>
        </div>
</div>
<!-- END OF NOTIFICATION -->
<div class="container">
<div class="card shopping-cart">
         <div class="card-header bg-dark text-light">
             <i class="fa fa-shopping-cart" aria-hidden="true"></i>
             Shopping cart
             <div class="clearfix"></div>
         </div>
         <div class="card-body cartHeight">
                 <!-- PRODUCT -->
                 <?php 


                if(isset($_SESSION["shoppingCart"]) && !empty($_SESSION["shoppingCart"])):
                    $cartProductsIds = array_keys($_SESSION["shoppingCart"]);
                    $ids = join(",", $cartProductsIds);
                    $query = "SELECT b.book_id AS id, bi.path, bi.alt, (SELECT p.value
                                                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                                        WHERE bp.book_id = b.book_id
                                                                        ORDER BY date_become_effective DESC
                                                                        LIMIT 1) AS price, b.title
                    FROM book_images bi  
                    INNER JOIN books b ON bi.book_id = b.book_id 
                    WHERE b.book_id IN ($ids)";
                    $results  = doSelect($query);
                    
                        $total = 0;
                        foreach($results as $bookInCart):
                            $total += $bookInCart->price * $_SESSION["shoppingCart"][$bookInCart->id]["productQuantity"];
                 ?>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-2 text-center mb-2 mb-sm-0">
                                <img class="img-responsive" src="<?= IMG_PATH  . "thumb-" . $bookInCart->path  ?>" alt="<?= $bookInCart->alt ?>"/>
                        </div>
                        <div class="col-12 text-sm-center col-sm-12 text-center text-md-left col-md-4 d-flex flex-column justify-content-center">
                            <h4 class="product-name"><strong><?= $bookInCart->title ?></strong></h4>
                        </div>
                        <div class="col-12 col-sm-12 text-sm-center col-md-6 text-md-right d-flex align-items-center justify-content-center flex-column flex-sm-row row">
                            <div class="col-6 text-center mb-2 mb-sm-0 col-sm-3 col-md-4 text-md-right pt-2">
                                <h6><strong><?= $bookInCart->price ?> &euro;</strong></h6>
                            </div>
                            <div class="col-6 col-sm-4 mb-2 mb-sm-0 d-flex justify-content-center">
                                <div class="quantity">
                                    <input type="button" value="&plus;" data-action="add" data-id="<?= $bookInCart->id ?>" class="plus shoppingCartAction" />
                                    <input type="number" data-action="changeQuantity" data-id="<?= $bookInCart->id ?>" step="1" max="99" min="1" value="<?= $_SESSION["shoppingCart"][$bookInCart->id]["productQuantity"] ?>" title="Qty" class="qty"
                                            size="4"/>
                                    <input type="button" data-action="removeOne" data-id="<?= $bookInCart->id ?>" value="&minus;" class="minus shoppingCartAction"/>
                                </div>
                            </div>
                            <div  data-action="remove" data-id="<?= $bookInCart->id ?>" class="col-5 col-sm-3 text-center text-sm-left shoppingCartAction">
                                <button type="button" class="btn red-button btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                 </div>
                 <hr>

                 <?php
                    endforeach;
                    else: 
                 ?>
                    <div class="d-flex justify-content-center align-items-center cartHeight">
                        <h2>Your shopping cart is currently empty.</h2>
                    </div>
                 <?php endif ?>
         </div>
         <div class="card-footer">
            <?php if(isset($_SESSION["shoppingCart"]) && !empty($_SESSION["shoppingCart"])): ?>
             <div class="float-right m-3 d-flex flex-column align-items-center">
                 <input type="button" value="Purchase" class="btn" <?php  if(!isset($_SESSION["korisnik"])) echo 'disabled="disabled"' ?>  id="purchase"/>
                 <div class="pull-right mt-2 mb-1">
                     Total price: <b><?= $total ?>&euro;</b>
             </div>
             <div class="text-danger font-weight-bold" id="errorMessage">
            </div>
            <?php endif; if(isset($_SESSION["shoppingCart"]) && !empty($_SESSION["shoppingCart"]) && !isset($_SESSION["korisnik"])): ?>

                <div class="text-danger font-weight-bold">
                    You can't make an order if you are not logged in!
                </div>
                <?php endif; ?>
                <?php if(!isset($_SESSION["shoppingCart"]) || empty($_SESSION["shoppingCart"])): ?>
                    <div class="m-3">
                        <a href="index.php?page=products" class="btn float-right">See Offer</a>
                    </div>
                <?php endif ?>
             </div>
 
         </div>
     </div>
</div>