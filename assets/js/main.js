$(document).ready(function () {
    menu();
    insertAccess();
    newlyAdded();
    $("#card").keyup(prilagodiFormat);
    if(window.location.href.includes("login")){
        $("#login").click(proveriLogin);
        $("#register").click(function(event){validateUser(event, "/authorization/register-user.php", "insertUser")});
    }
    if(window.location.href.includes("products")){
        if(localStorage.getItem("focusPoint") != null) $(document).scrollTop(localStorage.getItem("focusPoint"));
        setFilters();
        displayProducts();
        $(".filterBooks").on('change', function(){
            displayProducts();
            saveFilters();
        });
        $("#searchSubmit").on('click', function(){
            displayProducts();
            saveFilters();
        });
        $("#showAllBooks").click(resetFilters);
    }
    if(window.location.href.includes("contact")){
        dohvatiSubjects();
        $("#authorDownload").on("click", preuzmiWord)
    }
    if(window.location.href.includes("contact")){
        dohvatiSubjects();
        $("#authorDownload").on("click", preuzmiWord)
    }
    if(window.location.href.includes("shopping-cart")){
        $("input[type=number]").on("blur", function(){
            manipulateShoppingCart(this);
        })
        $("#purchase").on("click", makeOrder);
    }
    if(window.location.href.includes("admin-dashboard")){
        getDashboardInfo();
        getPagesStatistic();

    }
    if(window.location.href.includes("admin-reports")){
        displayReports();
    }
    $(".shoppingCartAction").click(function(e){manipulateShoppingCart(this, e)});
    $(".addCart").on("click", increaseCartQuantity);
    if(window.location.href.includes("content-manipulation")){
        displayMenuItems();
        displayGenres();
        displayPublishers();
        displayAuthors();
        displayUsers();
        $("#add-genre").on("click", function(event){
            validateGenre(event, "insertGenre", "add-genres.php");
        });
        $("#add-publisher").on("click", function(event){
            validatePublisher(event, "insertPublisher", "add-publishers.php");
        });
    }
    if(window.location.href.includes("menu-item-form")){
        setDefaultMenuItemValues();
        let previousErrorText = $(".errorInfo").text();
        $("#add-menu-submit").on("click", function(event){
            validateMenuItem(event, "insertMenu", "insert-menu-item.php");
        });
        $("#edit-menu-submit").on("click", function(event){
            validateMenuItem(event, "editMenu", "edit-menu-item.php", previousErrorText);
        });
    }
    if(window.location.href.includes("author-form")){
        setDefaultAuthorValues();
        let previousErrorText = $(".errorInfo").text();
        $("#add-author-submit").on("click", function(event){
            validateAuthor(event, "insertAuthor", "add-author.php");
        });
        $("#edit-author-submit").on("click", function(event){
            validateAuthor(event, "editAuthor", "edit-author.php", previousErrorText);
        });
    }
    if(window.location.href.includes("user-form")){
        setDefaultUserVaules();
        let previousErrorText = $(".errorInfo").text();
        $("#add-user-submit").on("click", function(event){
            validateUser(event, "/authorization/register-user.php", "insertUser" , true);
        });
        $("#edit-user-submit").on("click", function(event){
            validateUser(event, "/admin/content-manipulation/users/edit-user.php", "editUser", true,  previousErrorText);
        });
    }
});
function menu(){
    $.ajax({
        type: "GET",
        url: "models/menu/create-menu.php",
        data: {
            action:"menu"
        },
        success: function (response) {
            createMenu(response);
        },
        error: function(error){

        }
    });
}
function createMenu(data){
    var output = "";
    data.forEach(el => {
        output+=`
        <li class="navbar-item text-start text-sm-center mx-auto"><a href="${el.href}" class="nav-link">${el.text}</a></li>
        `;
    });
    $(output).insertBefore("#navigation");
}
function newlyAdded(){
    $.ajax({
        type: "GET",
        url: "models/home/select4newest.php",
        data: {
            action:"getNewlyAdded"
        },
        dataType: "json",
        success: function (response) {
            fillNewlyAdded(response);
        },
        error: function(error){
        }
    });
}
function fillNewlyAdded(data){
    var output = "";
    let imgPath = $("#imgPath").val();
    data.forEach(el=>{
        output+=`
        <div class="col-lg-3 col-md-6">
            <div class="item">
                <img src="${imgPath + el.path}" alt="${el.alt}" class="img-fluid"/>
                <h3>${el.title}</h3>
                <h6><span class="price">${el.price}&euro;</span></h6>
                <div class="hover">
                    <a href="index.php?page=single-product&id=${el.id}">
                    <span><i class="fas fa-long-arrow-alt-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
        `;
    });
    $("#new").html(output);
}
function prilagodiFormat(){
    let vrednost = $(this).val();
    if(vrednost.length == 4 || vrednost.length == 9 || vrednost.length == 14){
        vrednost += "-";
        $(this).val(vrednost);
    }
}
function validateUser(event, targetPage, actionString,  forAdminManipulation = false, previousErrorText = $(".errorInfo").text()){
    event.preventDefault();
    let ime = $("#regName");
    let prezime = $("#regLastName");
    let email = $("#email");
    let username = $("#regUser");
    let password = $("#regPassword");
    let creditCard = $("#card");
    let country = $("#country");
    let city = $("#city");
    let address = $("#address");
    let number = $("#number");
    let cvv = $("#cvv");
    let regExpCVV = /^[0-9]{3}$/;
    let regExpNumber = /^\+?[0-9]{9,19}$/;
    let regExpName =/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/;
    let regExpEmail = /^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})*$/;
    let regExpUsername = /[\d\w\.-_]{4,15}/;
    let regExpCreditCard = /^\d{4}(\-\d{4}){3}$/;
    let regExpCountry = /^[A-Z]\w{2,10}$/;
    let regExpAddress = /^[A-Z][\w]{4,20}(\s[\w]{1,20}){0,3}(\s[0-9]{1,4})$/;
    let roleId = $('input[name="role"]:checked').val();
    let validnoIme, validnoNumber,  validnoPrezime, validnoMail, validnoUsername, validnoPass, validnoCredit, validnoCountry, validnoCity, validnoAddress, validnoCVV, id;
    console.log(cvv);
    let distinctData = true;
    let defaultValues = null;
    let wrongClassOffset = 0;
    let redBorder = true;
    if(forAdminManipulation){
        wrongClassOffset = 3
        redBorder = false;
    }

    validnoIme = proveraTb(ime, regExpName, 3 - wrongClassOffset, redBorder);
    validnoPrezime = proveraTb(prezime, regExpName, 4 - wrongClassOffset, redBorder);
    validnoMail = proveraTb(email, regExpEmail, 5 - wrongClassOffset, redBorder);
    validnoUsername = proveraTb(username, regExpUsername, 6 - wrongClassOffset, redBorder);
    validnoPass = proveraTb(password, regExpUsername, 7 - wrongClassOffset, redBorder);
    validnoCredit = proveraTb(creditCard, regExpCreditCard, 8 - wrongClassOffset, redBorder);
    validnoCVV = proveraTb(cvv, regExpCVV, 9 - wrongClassOffset, redBorder);
    validnoCountry = proveraTb(country, regExpCountry, 10 - wrongClassOffset, redBorder);
    validnoCity = proveraTb(city, regExpCountry, 11 - wrongClassOffset, redBorder);
    validnoAddress = proveraTb(address, regExpAddress, 12 - wrongClassOffset, redBorder);
    validnoNumber = proveraTb(number, regExpNumber, 13 - wrongClassOffset, redBorder);

    if(localStorage.getItem("defaultMenuItemData") != null){
        defaultValues = localStorage.getItem("defaultUserData").split(",");
    }
    if(validnoIme && validnoPrezime && validnoMail && validnoUsername && validnoCredit && validnoPass && validnoCountry && validnoCity && validnoAddress && validnoNumber && validnoCVV && defaultValues != null){
        if($("#regName").val() == defaultValues[0] &&
           $("#regLastName").val() == defaultValues[1] &&
           $("#email").val() == defaultValues[2] &&
           $("#regUser").val() == defaultValues[3] &&
           $("#card").val() == defaultValues[4] &&
           $("#country").val() == defaultValues[5] &&
           $("#city").val() == defaultValues[6] &&
           $("#address").val() == defaultValues[7] &&
           $("#number").val() == defaultValues[8] &&
           $("#cvv").val() == defaultValues[9] &&
           $('input[name="role"]:checked').val() == defaultValues[10]){
                distinctData = false;
                $(".successInfo").hide();
                $(".errorInfo").hide();
                $(".errorInfo").text("You must enter at least 1 distinct data");
                $(".errorInfo").slideDown();
        }
        else{
                $(".errorInfo").hide();
                $(".errorInfo").text(previousErrorText);
        }
    }


    if(validnoIme && validnoPrezime && validnoMail && validnoUsername && validnoCredit && validnoPass && validnoCountry && validnoCity && validnoAddress && validnoNumber && validnoCVV && distinctData){
        $.ajax({
            type: "POST",
            url: "models/" + targetPage,
            data: {
                name:ime.val(),
                lastName:prezime.val(),
                email:email.val(),
                username:username.val(),
                password:password.val(),
                creditCard:creditCard.val(),
                country:country.val(),
                city:city.val(),
                address:address.val(),
                actionString,
                number:number.val(),
                cvv:cvv.val(),
                role: $('input[name="role"]:checked').val(),
                id: $("#id").val()
            },
            dataType: "json",
            success: function (data) {
                    $(".successInfo").hide();
                    $(".errorInfo").hide();
                    $(".successInfo").slideDown();
            },
            error: function(error){
                if(error.status == 409){
                    $(".errorInfo").hide();
                    $(".successInfo").hide();
                    $(".errorInfo").slideDown();
                }
                if(error.status == 422){
                    window.location.reload();
                }
            }
        });
    }

}
function proveraTb(field, regExp, index, makeBorderRed = true){
    if(!regExp.test(field.val())){
        $(".wrong:eq(" + index + ")").removeClass("d-none");
        if(makeBorderRed)$(field).css("border", "1px solid red");
        return false
        
    }
    else{
        if($(".wrong:eq(" + index + ")").hasClass("d-none")){
            return true

        }
        else{
            $(".wrong:eq(" + index + ")").addClass("d-none");
            if(makeBorderRed) $(field).css("border", "1px solid #ced4da");
            return true
        }
    }
}
function insertAccess(){
    $.ajax({
        type: "POST",
        url: "models/insertAccess.php",
        data: {
            action:"pristup",
            stranica:$("#page").val()
        },
        dataType: "json",
        success: function (response) {
            
        }
    });
}
function proveriLogin(e){
    e.preventDefault();
    let regExpUsername = /[\d\w\.-_]{4,15}/;
    let regExpCapcha = /[\d\w]{5,6}/;
    let username = $("#logUser");
    let password = $("#logPass");
    let capcha = $("#tbCapcha");
    let validnoUsername, validnoPass, validnocapcha;
    validnoPass = proveraTb(username, regExpUsername, 0);
    validnoUsername = proveraTb(password, regExpUsername, 1);
    validnocapcha = proveraTb(capcha, regExpCapcha, 2)
    if(validnoPass && validnoUsername && validnocapcha){
        $.ajax({
            type: "POST",
            url: "models/authorization/logIn.php",
            data: {
                username:username.val(),
                password:password.val(),
                capcha:capcha.val(),
                action:"uloguj"
            },
            dataType: "json",
            success: function (data) {
                if(data.redirect){
                    window.location.href = "index.php?page=login";
                }
                if(data.logged){
                    console.log(data.admin);
                    if(data.admin)window.location.href = "index.php?page=admin-dashboard";
                    else{
                        window.location.href = "index.php?page=home";
                    }
                }
            },
            error: function(error, status, message){
                if(error.responseText){
                    $(".loginInfo").hide();
                    $(".loginInfo").slideDown();
                }
            }
        });
    }
}
function dohvatiSubjects(){
    $.ajax({
        type: "GET",
        url: "models/contact-us/getSubjects.php",
        data: {
            action: "subjects"
        },
        dataType: "json",
        success: function (data) {
            ispisiSubjects(data);
            $("#submitForm").click(proveraContact);
            $("#subjectDdl").change(function(){
                if($(this).val() == "other" && $("#otherTb").hasClass("d-none")){
                    $("#otherTb").removeClass("d-none");
                }
                else{
                    if(!($("#otherTb").next().hasClass("d-none"))){
                        $("#otherTb").next().addClass("d-none");
                    }
                    if(!$("#otherTb").hasClass("d-none")){
                        $("#otherTb").addClass("d-none");
                    }
                }
            });
        }
    });
}
function ispisiSubjects(data){
    var ispis = `<select class="form-control" name="subjectDdl" id="subjectDdl">
                    <option value="0">Choose Subject...</option>`;
    data.forEach(el=>{
        ispis +=`<option value="${el.id}">${el.name}</option>`;
    });
    ispis += `<option value="other">Other</option>
                </select>
              <span class="text-danger wrong d-none">You must select subject</span>`;
    $("#subject").html(ispis);
}
function proveraContact(e){
    e.preventDefault();
    let name = $("#name");
    let email = $("#email");
    let subjects = $("#subjectDdl");
    let other = $("#otherTb");
    let message = $("#message");

    let nameRegexp = /^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})+(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/;
    let emailRegexp = /^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})*$/;
    let nameIspravno, emailIspravno, subjectsIspravno, otherIspravno, messageIspravno;
    messageIspravno =  message.val().length > 0 ? true : false;
    nameIspravno = proveraTb(name, nameRegexp, 0);
    emailIspravno = proveraTb(email, emailRegexp, 1);
    if(subjects.val() == "0"){
        subjectsIspravno = false;
        subjects.next().removeClass("d-none");
    }
    else{
        if(subjects.val() == "other"){
            otherIspravno = proveraTb(other, nameRegexp, 3);
            if(!otherIspravno){
                subjectsIspravno = false;
                subjects.next().removeClass("d-none");
            }
            else{
                subjectsIspravno = true;
                if(!subjects.next().hasClass("d-none")){
                    subjects.next().addClass("d-none");
                }
            }
        }
        else{
            subjectsIspravno = true;
        }
        if(!subjects.next().hasClass("d-none")){
            subjects.next().addClass("d-none");
        }
    }
    if(!messageIspravno){
        message.next().next().removeClass("d-none");
    }
    else{
        if(!message.next().next().hasClass("d-none")){
            message.next().next().addClass("d-none");
        }
    }
    if(nameIspravno && emailIspravno && subjectsIspravno && messageIspravno){
        $.ajax({
            type: "POST",
            url: "models/contact-us/submitContactForm.php",
            data: {
                name : name.val(),
                email : email.val(),
                subject : subjects.val(),
                other : other.val(),
                message : message.val(),
                action : "contact"
            },
            dataType: "json",
            success: function (data) {
                if(data.redirect){
                    window.location.href = "index.php?page=contact";
                }
                if(data.message == "success"){
                    $(".errorInfo").hide();
                    $(".successInfo").hide();
                    $(".successInfo").slideDown();
                }
            },
            error: function(error){
                if(error.responseJSON.message == "error"){
                    $(".errorInfo").hide();
                    $(".successInfo").hide();
                    $(".errorInfo").slideDown();
                }
            }
        });
    }
}
function preuzmiWord(){
    $.ajax({
        type: "GET",
        url: "models/contact-us/authorWord.php",
        data: "data",
        dataType: "dataType",
        success: function (response) {
        }
    });
}
function manipulateShoppingCart(obj, event){
    event.preventDefault();
    var action = obj.dataset.action;
    var id = obj.dataset.id;
    var quantity = null;
    if(action == "changeQuantity") quantity = obj.value;
    $.ajax({
        type: "POST",
        url: "models/shopping-cart/shopping-cart-manipulation.php",
        data: {
            id,
            action,
            quantity
        },
        success: function (response) {
            notificate("Succefuly added to cart!");
            if(window.location.href.includes("shopping-cart")){
                location.reload();
            }

        },
        error(error){
        }
    });
}
function makeOrder(){
    var action="purchase";
    $.ajax({
        type: "POST",
        url: "models/shopping-cart/make-order.php",
        data: {action:action},
        dataType: "json",
        success: function (response) {
            notificate("Order succefuly made!");
            $("#errorMessage").html("");
            setTimeout(function(){location.reload()}, 1300);
        },
        error: function (error){
            if(error.status >= 400){
                $("#errorMessage").html("There is problem with proceding your order, please try again later.");
            }
        }
    });
}
function notificate(message){
    $("#popUp p").html(message);
    $("#popUp").finish().delay(200).fadeIn();
    $("#popUp").delay(1800).fadeOut();

}
function increaseCartQuantity(){
    let quantity = parseInt($("#cartQuantity").html());
    if(Number.isNaN(quantity))quantity = 0;
    quantity ++;
    if($("#cartQuantity").html() == undefined && quantity > 0){
        $("#cart-link").children().children().after(`<span class="quantity" id="cartQuantity">1</span>`);
    }
    else{
        $("#cartQuantity").html(quantity);
    }
}
function displayProducts(){
    let action = "show";
    let order = $("#sort").val();
    let authors = [];
    let genres = [];
    let prices = [];
    let publishers = [];
    let search = $("#search").val();

    $(":checkbox").each(function(index, element){
        if(element.checked){
            switch(element.getAttribute("name")){
                case("authors"):
                    authors.push(element.value);
                    break;
                case("genres"):
                    genres.push(element.value);
                    break;
                case("prices"):
                    prices.push(element.value);
                    break;
                case("publishers"):
                    publishers.push(element.value);
                    break;
            }
        }
    });
    let pageNumber = $("#pageNumber").val();
    $.ajax({
        type: "GET",
        url: "models/shop/get-products.php",
        data: {
                action, 
                pageNumber,
                order,
                authors,
                genres,
                prices,
                publishers,
                search
              },
        dataType: "json",
        success: function (response) {
            let perPage = 4;
            if(response.data.length == 0 && response.total > 0){
                // let rootPath = $("#roothPath").val();
                let lastAvailablePageNumber = Math.ceil(response.total / perPage);
                location.href ="index.php?page=products&pageNumber=" + lastAvailablePageNumber;
            }
            else{
                showProducts(response.data);
                if(response.total > perPage){
                    showPagination(response.total, "products", "books", 4 );
                }
                $(".shoppingCartAction").click(function(e){manipulateShoppingCart(this, e)});
                $(".addCart").on("click", increaseCartQuantity);
            }
        }
    });
}
function showProducts(data){
    let output = "";
    let imgPath = $("#imgPath").val();
    data.forEach(el=>{
        output += `
        <div class="col-sm-6">
            <div class="item">
                <a href="index.php?page=single-product&id=${el.id}" class="text-secondary">
                <img src="${imgPath + el.path}" alt="${el.alt}}"/>
                <div class="title-container"><h3>${el.title}</h3></div>
                </a>
                <h6><span class="price">&euro;${el.price}</span> / <a href="#" class="shoppingCartAction addCart" data-action="add" data-id="${el.id}">Add to cart</a></h6>
            </div>
        </div>
        `
    });
    if(data.length == 0){
        output += "<h4 class='font-weight-bold mt-5'>There is no products matching your selection</h4>"
    }
    $("#books").html(output);
}
function saveFilters(){
    localStorage.setItem('order', $("#sort").val());
    localStorage.setItem('search', $("#search").val());
    let checkboxesObj = {
        "authors" : [],
        "genres" : [],
        "prices" : [],
        "publishers" : []
    }
    $(":checkbox").each(function(index, element){
        if(element.checked){
            switch(element.getAttribute("name")){
                case("authors"):
                    checkboxesObj.authors.push(element.dataset.index);
                    break;
                case("genres"):
                    checkboxesObj.genres.push(element.dataset.index);
                    break;
                case("prices"):
                    checkboxesObj.prices.push(element.dataset.index);
                    break;
                case("publishers"):
                    checkboxesObj.publishers.push(element.dataset.index);
                    break;
            }
        }
    });

    let checkboxes =  JSON.stringify(checkboxesObj);
    localStorage.setItem("checkboxes", checkboxes);
}
function setFilters(){
    if(localStorage.getItem("order") != null){
        $("#sort").val(localStorage.getItem("order"));
    }
    if(localStorage.getItem("search") != null){
        $("#search").val(localStorage.getItem("search"));
    }
    if(localStorage.getItem("checkboxes") != null){
        let checkboxesObj = JSON.parse(localStorage.getItem("checkboxes"));
        $(":checkbox").each(function(index, element){
            for(let name in checkboxesObj){
                if(element.getAttribute("name") == name && checkboxesObj[name].includes(element.dataset.index)){
                    element.setAttribute("checked", "checked");
                }
            }
        });
    }

}
function resetFilters(){
    $("#sort").val("price-desc");
    $("#search").val("");
    $(":checkbox").each(function(index, element){
        if(element.checked){
            element.checked = false;
        }
    });
    saveFilters();
    location.href = "index.php?page=products&pageNumber=1";
}
function getDashboardInfo(){
    let action = "getInfo";
    $.ajax({
        type: "GET",
        url: "models/admin/dashboard/get-dashboard-info.php",
        data: {
            action
        },
        dataType: "json",
        success: function (response) {
            displayAdminInfo(response);
        }
    });
}
function displayAdminInfo(response){
    for(let index in response){
        if(index == "most-popular-page-url"){
            $("#most-popular-page-name").attr("href", response[index]);
        }
        else if(index =="most-popular-page-views-count"){
            $("#" + index).html(response[index] + " Views");
        }
        else{
            $("#" + index).html(response[index]);
        }
    }
}
function getPagesStatistic(){
    let action = "getStatistic";
    let pageNumber = $("#pageNumber").val();
    $.ajax({
        type: "GET",
        url: "models/admin/dashboard/get-pages-statistic.php",
        data: {
            action,
            pageNumber
        },
        dataType: "json",
        success: function (response) {
            displayPagesStatistic(response.information);
            showPagination(response.totalNumber, "admin-dashboard", "page-statistic", 5);
            if(localStorage.getItem("focusPoint") != null) $(document).scrollTop(localStorage.getItem("focusPoint"));
        }
    });
}
function  displayPagesStatistic(data){
    const perPage = 5;
    let i = 0;
    let pageNumber = $("#pageNumber").val();
    let displayRootPath = $("#displayRoothPath").val();
    let output = `<div class="table-responsive">
                    <table class="table">
                    <thead class=" text-primary">
                        <tr><th>
                        #
                        </th>
                        <th>
                        URL
                        </th>
                        <th>
                        Views Last 24 Hours
                        </th>
                        <th>
                        Popularity In %
                        </th>
                    </tr></thead>
                    <tbody>`;
            for(let property in data){
                    let index = (parseInt(pageNumber) - 1) * perPage + i + 1;
                    output += `<tr>
                                    <td>
                                    ${index}
                                    </td>
                                    <td>
                                        <a href="index.php?page=${property}">${displayRootPath + property}</a>
                                    </td>
                                    <td>
                                    ${data[property]["views"]}
                                    </td>
                                    <td>
                                    ${data[property]["percentage"]} &#37;
                                    </td>
                                </tr>`;
                                i++;
}
    output += `     </tbody>
                </table>
            </div>`;
            $("#page-statistic").html(output);
}
function showPagination(total, page, outputDivId, itemPerPage){
    let pages = Math.ceil(total / itemPerPage);
    let pagination =`<div class="row m-0"> <ul class="pagination mx-auto">`;
    for(let i = 1; i <= pages; i++){
        pagination += `<li class="page-item `;
        if(i == $("#pageNumber").val()) pagination +="active";
        pagination += `"><a class="page-link" href="index.php?page=${page}&pageNumber=${i}">${i}</a></li>`
    }
    pagination += '</div> </ul>'

    let output = $("#" + outputDivId).html();
    output += pagination;
    let focusPoint = $("#" + outputDivId).offset().top;
    localStorage.setItem("focusPoint", focusPoint);
    $("#" + outputDivId).html(output);
}
function displayReports(){
    let action = "getReport";
    let accessPageNumber = $("#accessPageNumber").val();
    let errorsPageNumber = $("#errorsPageNumber").val();
    $.ajax({
        type: "GET",
        url: "models/admin/reports/get-all-reports.php",
        data: {
            action, 
            accessPageNumber,
            errorsPageNumber
        },
        dataType: "json",
        success: function (response) {
            displayAccessLog(response.access);
            showAdvancedPagination(response.accessNumber, "accessPageNumber" , "access-log", "admin-reports");
            displayErrorsLog(response.errors);
            showAdvancedPagination(response.errorsNumber, "errorsPageNumber" , "errors-log", "admin-reports");

            if(localStorage.getItem("focusPointErrors") != null) $(document).scrollTop(localStorage.getItem("focusPointErrors"));
            if(localStorage.getItem("focusPointAccess") != null) $(document).scrollTop(localStorage.getItem("focusPointAccess"));
            setTopOffsetForAccessAndErrorsDiv();
            $("#access-log a").on("click", function(){localStorage.removeItem("focusPointErrors")})
            $("#errors-log a").on("click", function(){localStorage.removeItem("focusPointAccess")})

        }
    });
}
function displayAccessLog(data){
    if(data != undefined){
        const perPage = 10;
        let i = 0;
        let pageNumber = $("#accessPageNumber").val();
        let displayRootPath = $("#displayRoothPath").val();
        var output = `<div class="table-responsive">
                        <table class="table">
                        <thead class=" text-primary">
                            <tr><th>
                            #
                            </th>
                            <th>
                                URL
                            </th>
                            <th>
                                IP Address
                            </th>
                            <th>
                                Time
                            </th>
                        </tr></thead>
                        <tbody>`;

        data.forEach(el=>{
            let index = (parseInt(pageNumber) - 1) * perPage + i + 1;
            output += `<tr>
                                        <td>
                                        ${index}
                                        </td>
                                        <td>
                                            <a href="index.php?page=${el.page}">${displayRootPath + el.page}</a>
                                        </td>
                                        <td>
                                        ${el.ip}
                                        </td>
                                        <td>
                                        ${el.time} UTC
                                        </td>
                                    </tr>`;
                                    i++;
        });
        output += `         </tbody>
                        </table>
                    </div`;
    }
    else{
        var output = "<h4 class='font-weight-bold my-4 text-center'>There is no logs at your provided page, please choose from pagination below</h4>";
    }
    $("#access-log").html(output);
}
function showAdvancedPagination(total, currentPageNumberHolderId , outputDivId, page){
    if(total > 0 ){
        if(page == "admin-reports"){
            var otherPageNumberHolderId = currentPageNumberHolderId == "accessPageNumber" ? "errorsPageNumber" : "accessPageNumber";
            var otherPageNumber = $("#" + otherPageNumberHolderId).val();
        }
        let currentPageNumber = $("#" + currentPageNumberHolderId).val();
        const perPage = 10;
        let ispis =`<ul class="pagination d-flex justify-content-center mt-3">`;
        let numberOfPages = Math.ceil(total / perPage);
        // console.log("broj stranica je: " + numberOfPages);
        let start = currentPageNumber - 1;
        let end = parseInt(currentPageNumber) + 1;

        if( start <= 0 ) {
            start = 1;
            end = start + 2;
        }

        if( end > numberOfPages ){
            end = numberOfPages;
            start = end - 2;
            if( start <= 0 ) start = 1;
        }

        if( currentPageNumber > 3 ) ispis+= `<li class="page-item"> <a href="index.php?page=${page}&${currentPageNumberHolderId}=1&${otherPageNumberHolderId}=${otherPageNumber}" class="page-link" data-page="1">Start</a> </li>`;
        if(currentPageNumber > 1) ispis += `<li class="page-item"> <a class="page-link" href="index.php?page=${page}&${currentPageNumberHolderId}=${parseInt(currentPageNumber) - 1}&${otherPageNumberHolderId}=${otherPageNumber}">&lt;</a> </li>`;

        for(let i = start; i<=end; i++){
            ispis += `<li class="page-item `;
            if( currentPageNumber == i) ispis+= `active`;
            ispis+=`"><a class="page-link" href="index.php?page=${page}&${currentPageNumberHolderId}=${i}&${otherPageNumberHolderId}=${otherPageNumber}">${i}</a></li>`;
        }
        if(currentPageNumber < numberOfPages) ispis += `<li class="page-item"> <a href="index.php?page=${page}&${currentPageNumberHolderId}=${parseInt(currentPageNumber) + 1}&${otherPageNumberHolderId}=${otherPageNumber}" class="page-link">&gt;</a> </li>`
        if( currentPageNumber < numberOfPages - 2 ) ispis+= `<li class="page-item"> <a href="index.php?page=${page}&${currentPageNumberHolderId}=${numberOfPages}&${otherPageNumberHolderId}=${otherPageNumber}" class="page-link" data-page="${numberOfPages}">End</a> </li>`;
        ispis += `</ul>`
        let output = $("#" + outputDivId).html();
        output += ispis;


        $("#" + outputDivId).html(output);
    }
    else{
        $("#" + outputDivId).html("");
    }
}
function displayErrorsLog(data){
    if(data != undefined){
        const perPage = 10;
        let i = 0;
        let pageNumber = $("#errorsPageNumber").val();
        var output = `<div class="table-responsive">
                        <table class="table">
                        <thead class=" text-primary">
                            <tr><th>
                            #
                            </th>
                            <th>
                                Action
                            </th>
                            <th>
                                Message
                            </th>
                            <th>
                                IP
                            </th>
                            <th>
                                Time
                            </th>
                        </tr></thead>
                        <tbody>`;
        data.forEach(el=>{
            let index = (parseInt(pageNumber) - 1) * perPage + i + 1;
            output += `<tr>
                                        <td>
                                        ${index}
                                        </td>
                                        <td>
                                            ${el.action}
                                        </td>
                                        <td>
                                        ${el.message}
                                        </td>
                                        <td>
                                        ${el.ip}
                                        </td>
                                        <td>
                                        ${el.time} UTC
                                        </td>
                                    </tr>`;
                                    i++;
        });
        output += `       </tbody>
                        </table>
                    </div`;
    }
    else{
        var output = "<h4 class='font-weight-bold my-4 text-center'>There is no logs at your provided page, please choose from pagination below</h4>";
    }
    $("#errors-log").html(output);
}
function displayMenuItems(){
    let action = "getMenuItems"
    $.ajax({
        type: "GET",
        url: "models/admin/content-manipulation/menu/get-menu-items.php",
        data: {action},
        dataType: "json",
        success: function (response) {
            showMenuItems(response);
            $(".delete").on("click", function(){deleteItem(this, "deleteMenuItem", "menu/delete-menu-item.php", displayMenuItems )});
        }
    });
}
function showMenuItems(data){
    let output = "";
    if(data == undefined || data.length == 0){
        output += "<h4 class='font-weight-bold my-4 text-center'>There is no menu items at the moment</h4>";
    }
    else{
        output += ` <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        #   
                                    </th>
                                    <th>
                                        Text
                                    </th>
                                    <th>
                                        Link
                                    </th>
                                    <th>
                                        Priority
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>`;
        data.forEach((el, index)=>{
            output += ` <tr>
                            <td>
                                ${++index}
                            </td>
                            <td>${el.text}</td>
                            <td>${el.href}</td>
                            <td>${el.priority}</td>
                            <td class="td-actions text-right">
                            <a href="index.php?page=menu-item-form&id=${el.id}" class="btn btn-primary btn-link btn-sm edit">
                                <i class="material-icons">Edit</i>
                            </a>
                            <button data-id="${el.id}" class="btn btn-danger btn-link btn-sm delete">
                                <i class="material-icons">Delete</i>
                            </button>
                            </td>
                        </tr>`;
        });
        output += `     </tbody>
                    </table>
                </div>`;
    }
    $("#admin-menu").html(output);
}
function setTopOffsetForAccessAndErrorsDiv(){
    let focusPointAccess = $("#access-log").offset().top;
    localStorage.setItem("focusPointAccess", focusPointAccess);
    let focusPointErrors = $("#errors-log").offset().top;
    localStorage.setItem("focusPointErrors", focusPointErrors);
}
function validateMenuItem(event, actionString, targetPage, previousErrorText = $(".errorInfo").text()){
    event.preventDefault();
    let regExpName = /^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/;
    let regExpUrl = /(http(s)?:\/\/)?(www\.)?[a-zA-Z0-9@:_\+~#=]{2,20}\.[a-z0-9]{2,6}[a-zA-Z0-9@:%_\+.~#?&\/=\.]*/;

    let nameIspravno = proveraTb($("#name"), regExpName, 0, false);
    let urlIspravno = proveraTb($("#url"), regExpUrl, 2, false);
    let priorityIspravno = true;
    if($("#priority").val() < 1){
        $("#priority").next().removeClass("d-none");
        priorityIspravno = false;
    }
    else{
        if(!($("#priority").next().hasClass("d-none"))){
            $("#priority").next().addClass("d-none");
            priorityIspravno = true;
        }
    }
    let distinctData = true;
    let defaultValues = null;
    if(localStorage.getItem("defaultMenuItemData") != null){
        defaultValues = localStorage.getItem("defaultMenuItemData").split(",");
    }
    if(nameIspravno && lastNameIspravno && defaultValues != null){
        if($("#name").val() == defaultValues[0] && $("#priority").val() == defaultValues[1] && $("#url").val() == defaultValues[2]){
            distinctData = false;
            $(".successInfo").hide();
            $(".errorInfo").hide();
            $(".errorInfo").text("You must enter at least 1 distinct data");
            $(".errorInfo").slideDown();
        }
        else{
            $(".errorInfo").hide();
            $(".errorInfo").text(previousErrorText);
        }
    }
    if(nameIspravno && urlIspravno && priorityIspravno && distinctData){
        let name = $("#name").val();
        let priority = $("#priority").val();
        let url = $("#url").val();
        let id = $("#id").val();
        $.ajax({
            type: "POST",
            url: "models/admin/content-manipulation/menu/" + targetPage,
            data: {
                actionString,
                name,
                priority,
                url,
                id
            },
            dataType: "json",
            success: function (response) {
                $(".successInfo").hide();
                $(".errorInfo").hide();
                $(".successInfo").slideDown();
                setDefaultMenuItemValues();
            },
            error: function (error){
                if(error.status == 422){
                    location.reload();
                }
                if(error.status == 409){
                    $(".errorInfo").hide();
                    $(".successInfo").hide();
                    $(".errorInfo").slideDown();
                }
            }
        });
    }
}
function setDefaultMenuItemValues(){
    let output = [];
    output.push($("#name").val());
    output.push($("#priority").val());
    output.push($("#url").val());

    localStorage.setItem("defaultMenuItemData", output)

}
function deleteItem(obj, actionString, deleteTargetPage, callback, checkIdTargetPage = null){
    let id = obj.dataset.id;
    var confirmed = false;
    if(checkIdTargetPage != null){
        $.ajax({
            type: "GET",
            url: "models/admin/content-manipulation/" + checkIdTargetPage,
            data: {
                id,
                actionString
            },
            async: false,
            dataType: "json",
            success: function (response) {
                if(response.number > 0){
                    if(confirm("Some books are going to be deleted if you delete this item. Are you Sure?")){
                        confirmed = true;
                    }
                    else{
                        confirmed = false;
                    }
                }
                else{
                    confirmed = true;
                }
            }
        });
        if(confirmed){
            $.ajax({
                type: "POST",
                url: "models/admin/content-manipulation/" + deleteTargetPage,
                async: false,
                data: {
                    id,
                    actionString
                },
                dataType: "json",
                success: function (response) {
                    callback();
                }
            });
        }

    }
}
function displayGenres(){
    let actionString = "displayGenres"
    $.ajax({
        type: "GET",
        url: "models/admin/content-manipulation/genres/get-genres.php",
        data: {
            actionString
        },
        dataType: "json",
        success: function (response) {
            showGenres(response);
            let oldValues = getAllValuesFromClass("genres");
            $(".editGenre").on("click", function(event){
                validateGenre(event,"editGenres", "edit-genres.php", oldValues , this);
            })
            $(".deleteGenre").on("click", function(event){
                deleteItem(this, "deleteGenre", "genres/delete-genres.php", displayGenres, "genres/get-genre-with-id.php");
            })
        }
    });
}
function showGenres(data){
    let output = "";
    if(data == undefined || data.length == 0){
        output += "<h4 class='font-weight-bold my-4 text-center'>There is no genres at the moment</h4>";
    }
    else{
        output += ` <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        #   
                                    </th>
                                    <th>
                                      Name
                                    </th>
                                    <th>
                                    </th>
                                    <th>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>`;
        data.forEach((el, index)=>{
            output += ` <tr>
                            <td>
                                ${++index}
                            </td>
                            <td colspan="3"><div class="px-0 px-2 col-sm-6 col-lg-4 col-xl-3"><input class="form-control genres" data-id="${el.id}" type="text" value="${el.name}"/></div></td>
                            <td class="td-actions text-right">
                            <button data-id="${el.id}" class="btn btn-primary btn-link btn-sm editGenre">
                                <i class="material-icons">Edit</i>
                            </button>
                            <button data-id="${el.id}" class="btn btn-danger btn-link btn-sm deleteGenre">
                                <i class="material-icons">Delete</i>
                            </button>
                            </td>
                        </tr>`;
        });
        output += `     </tbody>
                    </table>
                </div>`;
    }
    $("#admin-genres").html(output);
}
function validateGenre(event, actionString, targetPage, oldValues = null, obj = null){
    event.preventDefault();
    let name
    let regExpName = /^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/;
    let distinctData = true;
    let nameIspravno = false;
    if(obj != null){
        var id = obj.dataset.id;
        var element;
        $.each($(".genres"), function (index, el) { 
             if(el.dataset.id == id){
                 element = el;
             }
        });
        name = element.value;
        if(regExpName.test(name)){
            if($(obj).parent().prev().children().children().length == 2){
                $(obj).parent().prev().children().children().eq(1).remove();
            }
            nameIspravno = true;
        }
        else{
            if($(obj).parent().prev().children().children().length == 2){
                $(obj).parent().prev().children().children().eq(1).remove();
            }
            if($(obj).parent().prev().children().children().length == 1){
                let htmlBefore = $(obj).parent().prev().children().html();
                htmlBefore += '<p class="text-center mt-2 mb-0 text-danger">Genre Name Must be in valid format (Sci Fi)</p>';
                $(obj).parent().prev().children().html(htmlBefore);
            }
            nameIspravno = false;
        }
    }
    else{
        name = $("#genre-name").val();
        nameIspravno = proveraTb($("#genre-name"), regExpName, 0, false );
    }
    $("#errorGenre").hide();

    if(oldValues != null){
        var oldName;
        oldValues.forEach(el => {
            if(el.id == id){
                oldName = el.name;
            }
        })  
        if(nameIspravno && oldName == name){
            distinctData = false;
            $("#successGenre").hide();
            $("#errorGenre").hide();
            if($(obj).parent().prev().children().children().length == 2){
                $(obj).parent().prev().children().children().eq(1).remove();
            }
            if($(obj).parent().prev().children().children().length == 1){
                let htmlBefore = $(obj).parent().prev().children().html();
                htmlBefore += '<p class="text-center mt-2 mb-0 text-danger text-danger">Name cant be same as before</p>';
                $(obj).parent().prev().children().html(htmlBefore);
            }

        }
        else if(nameIspravno && oldName != name){
            if($(obj).parent().prev().children().children().length == 2){
                $(obj).parent().prev().children().children().eq(1).remove();
            }
            distinctData = true;
        }
    }
    if(nameIspravno && distinctData){
        $.ajax({
            type: "POST",
            url: "models/admin/content-manipulation/genres/" + targetPage,
            data: {
                actionString,
                name,
                id
            },
            dataType: "json",
            success: function (response) {
                $("#errorGenre").hide();
                $("#successGenre").hide();
                $("#successGenre").slideDown();
                displayGenres();
            },
            error: function (error){
                if(error.status == 422){
                    location.reload();
                }
                if(error.status == 409){
                    $("#successGenre").hide();
                    $("#errorGenre").hide();
                    $("#errorGenre").slideDown();
                }
            }
        });
    }
}
function getAllValuesFromClass(targetClass){
    let output = [];
    $.each($("." + targetClass), function (index, el) { 
         let id = el.dataset.id;
         output.push({
             "id" : id,
             "name": el.value
         })
    });
    return output;
}
function displayPublishers(){
    let actionString = "displayPublishers"
    $.ajax({
        type: "GET",
        url: "models/admin/content-manipulation/publishers/get-publishers.php",
        data: {
            actionString
        },
        dataType: "json",
        success: function (response) {
            showPublishers(response);
            let oldValues = getAllValuesFromClass("publishers");
            $(".editPublisher").on("click", function(event){
                validatePublisher(event,"editPublishers", "edit-publishers.php", oldValues , this);
            })
            $(".deletePublisher").on("click", function(){
                deleteItem(this, "deletePublisher", "publishers/delete-publishers.php", displayPublishers, "publishers/get-publisher-with-id.php");
            })
        }
    });
}
function showPublishers(data){
    let output = "";
    if(data == undefined || data.length == 0){
        output += "<h4 class='font-weight-bold my-4 text-center'>There is no publishers at the moment</h4>";
    }
    else{
        output += ` <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        #   
                                    </th>
                                    <th>
                                      Name
                                    </th>
                                    <th>
                                    </th>
                                    <th>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>`;
        data.forEach((el, index)=>{
            output += ` <tr>
                            <td>
                                ${++index}
                            </td>
                            <td colspan="3"><div class="px-0 px-2 col-sm-9 col-lg-8 col-xl-5"><input class="form-control publishers" data-id="${el.id}" type="text" value="${el.name}"/></div></td>
                            <td class="td-actions text-right">
                            <button data-id="${el.id}" class="btn btn-primary btn-link btn-sm editPublisher">
                                <i class="material-icons">Edit</i>
                            </button>
                            <button data-id="${el.id}" class="btn btn-danger btn-link btn-sm deletePublisher">
                                <i class="material-icons">Delete</i>
                            </button>
                            </td>
                        </tr>`;
        });
        output += `     </tbody>
                    </table>
                </div>`;
    }
    $("#admin-publishers").html(output);
}
function validatePublisher(event, actionString, targetPage, oldValues = null, obj = null){
    event.preventDefault();
    let name
    let regExpName = /^[A-ZĐŠĆŽČ][a-zšđćžč][a-zšđćžč\.']{1,14}(\s[A-ZĐŠĆŽČa-zšđćžč'\.]{1,14})*$/;
    let distinctData = true;
    let nameIspravno = false;
    if(obj != null){
        var id = obj.dataset.id;
        var element;
        $.each($(".publishers"), function (index, el) { 
             if(el.dataset.id == id){
                 element = el;
             }
        });
        name = element.value;
        if(regExpName.test(name)){
            if($(obj).parent().prev().children().children().length == 2){
                $(obj).parent().prev().children().children().eq(1).remove();
            }
            nameIspravno = true;
        }
        else{
            if($(obj).parent().prev().children().children().length == 2){
                $(obj).parent().prev().children().children().eq(1).remove();
            }
            if($(obj).parent().prev().children().children().length == 1){
                let htmlBefore = $(obj).parent().prev().children().html();
                htmlBefore += '<p class="text-center mt-2 mb-0 text-danger">Publisher Name Must be in valid format (St. Martin\'s Press)</p>';
                $(obj).parent().prev().children().html(htmlBefore);
            }
            nameIspravno = false;
        }
    }
    else{
        name = $("#publisher-name").val();
        nameIspravno = proveraTb($("#publisher-name"), regExpName, 1, false );
    }
    $("#errorPublisher").hide();

    if(oldValues != null){
        var oldName;
        oldValues.forEach(el => {
            if(el.id == id){
                oldName = el.name;
            }
        })  
        if(nameIspravno && oldName == name){
            distinctData = false;
            $("#successPublisher").hide();
            $("#errorPublisher").hide();
            if($(obj).parent().prev().children().children().length == 1){
                let htmlBefore = $(obj).parent().prev().children().html();
                htmlBefore += '<p class="text-center mt-2 mb-0 text-danger">Name cant be same as before</p>';
                $(obj).parent().prev().children().html(htmlBefore);
            }

        }
        else if(nameIspravno && oldName != name){
            if($(obj).parent().prev().children().children().length == 2){
                $(obj).parent().prev().children().children().eq(1).remove();
            }
            distinctData = true;
        }
    }
    if(nameIspravno && distinctData){
        $.ajax({
            type: "POST",
            url: "models/admin/content-manipulation/publishers/" + targetPage,
            data: {
                actionString,
                name,
                id
            },
            dataType: "json",
            success: function (response) {
                $("#errorPublisher").hide();
                $("#successPublisher").hide();
                $("#successPublisher").slideDown();
                displayPublishers();
            },
            error: function (error){
                if(error.status == 422){
                    location.reload();
                }
                if(error.status == 409){
                    $("#successPublisher").hide();
                    $("#errorPublisher").hide();
                    $("#errorPublisher").slideDown();
                }
            }
        });
    }
}
function displayAuthors(){
    let action = "getAuthors"
    $.ajax({
        type: "GET",
        url: "models/admin/content-manipulation/authors/get-authors.php",
        data: {action},
        dataType: "json",
        success: function (response) {
            showAuthors(response);
            $(".delete").on("click", function(){deleteItem(this, "deleteAuthor", "authors/delete-author.php", displayAuthors, "authors/get-author-with-id.php")});
        }
    });
}
function showAuthors(data){
    let output = "";
    if(data == undefined || data.length == 0){
        output += "<h4 class='font-weight-bold my-4 text-center'>There is no authors at the moment</h4>";
    }
    else{
        output += ` <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        #   
                                    </th>
                                    <th>
                                        First Name
                                    </th>
                                    <th>Last Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>`;
        data.forEach((el, index)=>{
            output += ` <tr>
                            <td>
                                ${++index}
                            </td>
                            <td>${el.name}</td>
                            <td>${el.surname}</td>
                            <td class="td-actions text-right">
                            <a href="index.php?page=author-form&id=${el.id}" class="btn btn-primary btn-link btn-sm edit">
                                <i class="material-icons">Edit</i>
                            </a>
                            <button data-id="${el.id}" class="btn btn-danger btn-link btn-sm delete">
                                <i class="material-icons">Delete</i>
                            </button>
                            </td>
                        </tr>`;
        });
        output += `     </tbody>
                    </table>
                </div>`;
    }
    $("#admin-authors").html(output);
}
function validateAuthor(event, actionString, targetPage, previousErrorText = $(".errorInfo").text()){
    event.preventDefault();
    let regExpName = /^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/;

    let nameIspravno = proveraTb($("#name"), regExpName, 0, false);
    let lastNameIspravno = proveraTb($("#surname"), regExpName, 1, false);
    let distinctData = true;
    let defaultValues = null;
    if(localStorage.getItem("defaultMenuItemData") != null){
        defaultValues = localStorage.getItem("defaultAuthorData").split(",");
    }
    if(nameIspravno && lastNameIspravno &&  defaultValues != null){
        if($("#name").val() == defaultValues[0] && $("#surname").val() == defaultValues[1]){
            distinctData = false;
            $(".successInfo").hide();
            $(".errorInfo").hide();
            $(".errorInfo").text("You must enter at least 1 distinct data");
            $(".errorInfo").slideDown();
        }
        else{
            $(".errorInfo").hide();
            $(".errorInfo").text(previousErrorText);
        }
    }
    if(nameIspravno && lastNameIspravno && distinctData){
        let name = $("#name").val();
        let surname = $("#surname").val();
        let id = $("#id").val();
        $.ajax({
            type: "POST",
            url: "models/admin/content-manipulation/authors/" + targetPage,
            data: {
                actionString,
                name,
                surname,
                id
            },
            dataType: "json",
            success: function (response) {
                $(".successInfo").hide();
                $(".errorInfo").hide();
                $(".successInfo").slideDown();
                setDefaultAuthorValues();
            },
            error: function (error){
                if(error.status == 422){
                    location.reload();
                }
                if(error.status == 500){
                    $(".errorInfo").hide();
                    $(".successInfo").hide();
                    $(".errorInfo").slideDown();
                }
            }
        });
    }
}
function setDefaultAuthorValues(){
        let output = [];
        output.push($("#name").val());
        output.push($("#surname").val());
        localStorage.setItem("defaultAuthorData", output)
}
function displayUsers(){
    let action = "getUsers";
    $.ajax({
        type: "GET",
        url: "models/admin/content-manipulation/users/get-users.php",
        data: {
            action
        },
        dataType: "json",
        success: function (response) {
            showUsers(response);
            $(".userManipulation").on("click", function(){changeActiveStatus(this)})
        }
    });
}
function showUsers(data){
    let output = "";
    if(data == undefined || data.length == 0){
        output += "<h4 class='font-weight-bold my-4 text-center'>There is no users at the moment</h4>";
    }
    else{
        output += ` <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        #   
                                    </th>
                                    <th>
                                        First Name
                                    </th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Addres</th>
                                    <th>Town</th>
                                    <th>Country</th>
                                    <th>Payment</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>`;
        data.forEach((el, index)=>{
            output += ` <tr>
                            <td>
                                ${++index}
                            </td>
                            <td>${el.name}</td>
                            <td>${el.surname}</td>
                            <td>${el.username}</td>
                            <td>${el.email}</td>
                            <td>${el.phone_number}</td>
                            <td>${el.addres}</td>
                            <td>${el.city_name}</td>
                            <td>${el.country_name}</td>
                            <td>
                                <ul class="list-unstyled m-0">`;
                                el.payments.forEach((el)=>{
                                    output += `<li>${el.card_number}</li>`
                                })
                            output+=`</ul></td>
                            <td>${el.role}</td>
                            <td>`;
                                if(el.active == 1){
                                    output += `<p class="text-center text-success m-0">Active</p>`;
                                }
                                else{
                                    output += `<p class="text-center text-danger">Deactivated</p>`;
                                }
                            output +=`</td>
                            <td class="td-actions text-right">
                            <a href="index.php?page=user-form&id=${el.id}" class="btn btn-primary btn-link btn-sm edit">
                                <i class="material-icons">Edit</i>
                            </a>
                            <button data-id="${el.id}" data-status="${el.active}" class="btn `;
                            if(el.active == 1){
                                output += "text-danger ";
                            }
                            else{
                                output += "text-success ";
                            }
                             output += `btn-link btn-sm userManipulation">
                                <i class="material-icons">`;
                                if(el.active == 1){
                                    output += "Deactivate";
                                }
                                else{
                                    output += "Activate";
                                }
                                output += `</i>
                            </button>
                            </td>
                        </tr>`;
        });
        output += `     </tbody>
                    </table>
                </div>`;
    }
    $("#admin-users").html(output);
}
function setDefaultUserVaules(){
    let output = [];
    let ime = $("#regName").val();
    let prezime = $("#regLastName").val();
    let email = $("#email").val();
    let username = $("#regUser").val();
    let creditCard = $("#card").val();
    let country = $("#country").val();
    let city = $("#city").val();
    let address = $("#address").val();
    let number = $("#number").val();
    let cvv = $("#cvv").val();
    let role = $('input[name="role"]:checked').val();
    output.push(ime, prezime, email, username, creditCard, country, city, address, number, cvv, role)
    localStorage.setItem("defaultUserData", output)
}
function changeActiveStatus(obj){
    let id = $(obj).data("id");
    let status = $(obj).data("status");
    let actionString = "changeStatus";
    $.ajax({
        type: "POST",
        url: "models/admin/content-manipulation/users/change-user-status.php",
        data: {
            actionString,
            id,
            status
        },
        dataType: "json",
        success: function (response) {
            displayUsers();
        }
    });
}
//21 min / 3:02