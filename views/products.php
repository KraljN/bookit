<!-- NOTIFICATION -->
<div class="row">
        <div class="col-10 col-sm-6 col-md-5 col-lg-4  justify-content-center align-items-center mx-auto fixed-bottom rounded" id="popUp">
            <p class=" text-white my-2 text-center"></p>
        </div>
</div>
<!-- END OF NOTIFICATION -->
<input type="hidden" id="pageNumber" value="<?= isset($_GET["pageNumber"]) ? $_GET["pageNumber"] : 1 ?>"/>
<section class="static about-sec mb-0">
        <div class="container">
            <h1 class="mb-5">Book it shop offer</h1>
            <div class="recent-book-sec mb-0">
                <div class="row justify-content-around m-0">
                    <div class="col-md-4 px-5">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="font-weight-bold text-left">Order By</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Price Descending</option>
                                <option>Price Ascending</option>
                                <option>A-Z</option>
                                <option>Z-A</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Authors</label>
                            <div class="d-flex flex-column align-items-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Johny Moris
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                    Bob Marley
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                    Steven Segal
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Categories</label>
                            <div class="d-flex flex-column align-items-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Documentation
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Horor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Drama
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Prices</label>
                            <div class="d-flex flex-column align-items-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        0-5 &euro;
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        5-7.5 &euro;
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        7.5-10 &euro;
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        10+ &euro;
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Publishers</label>
                            <div class="d-flex flex-column align-items-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Cambridge University Press
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        McClelland and Stewart
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Olympia Press
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                    <div class="row mb-2 mx-0"> 
                    <div class="input-group mb-2 mr-sm-2 d-flex justify-content-center align-items-center w-100">
                        <form action="#" class="form-inline d-flex justify-content-center align-items-center">
                            <div class="input-group mr-1">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></div>
                                </div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Search By Title">
                            </div>
                            <button type="submit" class="btn default-padding">Search</button>
                        </form>
                    </div>
                    </div>
                        <div class="row m-0" id="books"> </div>  
                    </div>
                </div>
            </div>
        </div>
    </section>