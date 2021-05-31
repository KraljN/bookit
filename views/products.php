<!-- NOTIFICATION -->
<div class="row">
        <div class="col-10 col-sm-6 col-md-5 col-lg-4  justify-content-center align-items-center mx-auto fixed-bottom rounded" id="popUp">
            <p class=" text-white my-2 text-center"></p>
        </div>
</div>
<!-- END OF NOTIFICATION -->
<input type="hidden" id="pageNumber" value="<?= isset($_GET["pageNumber"]) ? $_GET["pageNumber"] : 1 ?>"/>
<section class="static about-sec">
        <div class="container">
            <h1 class="mb-5">Book it shop offer</h1>
            <div class="recent-book-sec">
                <div class="row">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-8">
                        <div class="row" id="books"> </div>  
                        <div class="row">
                            <ul class="pagination mx-auto">
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>