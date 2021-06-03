$(document).ready(function () {
    menu();
    insertAccess();
    if($("#isLogged").val().trim()=="true"){
        setInterval(updateActivity, 10000);// ============PODESITI VREME ZA KOJE SE VRSI UPDATE U BAZU AKTIVNOSTI==========
    }
    newlyAdded();
    $("#card").keyup(prilagodiFormat);
    $("#register").click(proveraRegister);
    if(window.location.href.includes("login")){
        $("#login").click(proveriLogin);
    }
    if(window.location.href.includes("products")){
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
    $(".shoppingCartAction").click(function(e){manipulateShoppingCart(this, e)});
    $(".addCart").on("click", increaseCartQuantity);

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
function proveraRegister(e){
    e.preventDefault();
    let register = $("#register");
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
    let regExpName = /^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}$/;
    let regExpLastName =/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})+(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/;
    let regExpEmail = /^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})*$/;
    let regExpUsername = /[\d\w\.-_]{4,15}/;
    let regExpCreditCard = /^\d{4}(\-\d{4}){3}$/;
    let regExpCountry = /^[A-Z]\w{2,10}$/;
    let regExpAddress = /^[A-Z][\w]{4,20}(\s[\w]{4,20}){0,3}(\s[0-9]{1,4})$/;

    let validnoIme, validnoNumber,  validnoPrezime, validnoMail, validnoUsername, validnoPass, validnoCredit, validnoCountry, validnoCity, validnoAddress, validnoCVV;

    validnoIme = proveraTb(ime, regExpName, 3);
    validnoPrezime = proveraTb(prezime, regExpLastName, 4);
    validnoMail = proveraTb(email, regExpEmail, 5);
    validnoUsername = proveraTb(username, regExpUsername, 6);
    validnoPass = proveraTb(password, regExpUsername, 7);
    validnoCredit = proveraTb(creditCard, regExpCreditCard, 8);
    validnoCVV = proveraTb(cvv, regExpCVV, 9);
    validnoCountry = proveraTb(country, regExpCountry, 10);
    validnoCity = proveraTb(city, regExpCountry, 11);
    validnoAddress = proveraTb(address, regExpAddress, 12);
    validnoNumber = proveraTb(number, regExpNumber, 13);
    if(validnoIme && validnoPrezime && validnoMail && validnoUsername && validnoCredit && validnoPass && validnoCountry && validnoCity && validnoAddress && validnoNumber && validnoCVV){
        $.ajax({
            type: "POST",
            url: "models/authorization/register-user.php",
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
                register:register.val(),
                number:number.val(),
                cvv:cvv.val()
            },
            dataType: "json",
            success: function (data) {
                if(data.redirect){
                    window.location.href = "index.php?page=login";
                }
                if(data.message == "You successfuly made account"){
                    $(".errorInfo").hide();
                    $(".successInfo").slideDown();
                }
            },
            error: function(error, status, message){
                if(error.responseText){
                    $(".successInfo").hide();
                    $(".errorInfo").slideDown();
                }
            }
        });
    }

}
function proveraTb(field, regExp, index){
    if(!regExp.test(field.val())){
        $(".wrong:eq(" + index + ")").removeClass("d-none");
        $(field).css("border", "1px solid red");
        return false
        
    }
    else{
        if($(".wrong:eq(" + index + ")").hasClass("d-none")){
            return true

        }
        else{
            $(".wrong:eq(" + index + ")").addClass("d-none");
            $(field).css("border", "1px solid #ced4da");
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
                    window.location.href = "index.php?page=home";
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
function updateActivity(){
    $.ajax({
        type: "POST",
        url: "models/onlineUsersControl/updateActivity.php",
        data: {
            action: "updateActivity"
        },
        dataType: "json",
        success: function (response) {
        },
        error: function(error){

        }
    });
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
                    $(".successInfo").slideDown();
                }
            },
            error: function(error){
                if(error.responseJSON.message == "error"){
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
            console.log(response);
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
            console.log(error.responseText);
        }
    });
}
function makeOrder(){
    console.log("porudzbina poslata");
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
    console.log(quantity);
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
            showProducts(response.data);
            showPagination(response.total);
            $(".shoppingCartAction").click(function(e){manipulateShoppingCart(this, e)});
            $(".addCart").on("click", increaseCartQuantity);
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
    $("#books").html(output);
}
function showPagination(total){
    let perPage = 4;
    let pages = Math.ceil(total / perPage);
    let pagination = `<div class="row m-0"> <ul class="pagination mx-auto">`;
    for(let i = 1; i <= pages; i++){
        pagination += `<li class="page-item `;
        if(i == $("#pageNumber").val()) pagination +="active";
        pagination += `"><a class="page-link" href="index.php?page=products&pageNumber=${i}">${i}</a></li>`
    }
    pagination += '</div> </ul>'

    let output = $("#books").html();
    output += pagination;

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