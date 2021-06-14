<?php require_once "models/single-product/get-info.php";
end($resultGenres);
$key =  key($resultGenres);
?>
<!-- NOTIFICATION -->
<div class="row">
        <div class="col-10 col-sm-6 col-md-5 col-lg-4  justify-content-center align-items-center mx-auto fixed-bottom rounded" id="popUp">
            <p class=" text-white my-2 text-center"></p>
        </div>
</div>
<!-- END OF NOTIFICATION -->
<div class="row">
<section class="product-sec">
        <div class="container">
            <h1 class="text-center text-sm-left"><?= $result->title ?></h1>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0">
                    <img src="<?= DISPLAY_IMG_PATH .  $result->path ?>" alt="<?= $result->alt ?>" class="img-fluid"/>
                </div>
                <div class="col-md-6 slider-content">
                    <p><?= $result->description ?></p>
                    <ul class="mx-auto">
                        <li>
                            <span class="name">Author</span><span class="clm d-none d-xl-inline-block">:</span>
                            <span class="price pl-sm-3"><?= $result->first_name .  "&nbsp;" . $result->last_name ?></span>
                        </li>
                        <li>
                            <span class="name">Publisher</span><span class="clm d-none d-xl-inline-block">:</span>
                            <span class="price pl-sm-3"><?= $result->publisher_name ?></span>
                        </li>
                        <li>
                            <span class="name">Published</span><span class="clm d-none d-xl-inline-block">:</span>
                            <span class="price pl-sm-3"><?= $result->publication_year ?></span>
                        </li>
                        <li>
                            <span class="name">Number of pages</span><span class="clm d-none d-xl-inline-block">:</span>
                            <span class="price pl-sm-3"><?= $result->pages ?></span>
                        </li>
                        <li>
                            <span class="name">Genres</span><span class="clm d-none d-xl-inline-block">:</span>
                            <span class="price pl-sm-3">
                                <?php foreach($resultGenres as $i => $genre){
                                    echo $genre->genre;
                                    if($i != $key) echo", ";
                                } ?>
                            </span>
                        </li>
                        <li>
                            <span class="name">Price</span><span class="clm d-none d-xl-inline-block">:</span>
                            <span class="price final pl-sm-3"><?= $result->price ?>&euro;</span>
                        </li>
                        
                    </ul>
                    <div class="btn-sec">
                        <button class="btn shoppingCartAction addCart" data-action="add" data-id=<?= $result->id ?>>Add To cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>