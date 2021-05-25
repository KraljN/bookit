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
    if(window.location.href.includes("contact")){
        dohvatiSubjects();
        $("#authorDownload").on("click", preuzmiWord)
    }
    if(window.location.href.includes("contact")){
        dohvatiSubjects();
        $("#authorDownload").on("click", preuzmiWord)
    }
    if(window.location.href.includes("shopping-cart")){
        $(".reload").on("click", function(){location.reload()})
        $("input[type=number]").on("blur", function(){
            manipulateShoppingCart(this);
            location.reload();
        })
        $("#purchase").on("click", makeOrder);
    }
    $(".shoppingCartAction").click(function(){manipulateShoppingCart(this)});

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
                <h6><span class="price">${el.value}&euro;</span></h6>
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
function manipulateShoppingCart(obj){
    var action = obj.dataset.action;
    var id = obj.dataset.id;
    var quantity = null;
    if(action == "changeQuantity") quantity = obj.value;
    // console.log(quantity);
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
        data: action,
        dataType: "json",
        success: function (response) {
            
        }
    });
}
function notificate(message){
    $("#popUp p").html(message);
    $("#popUp").finish().delay(200).fadeIn();
    $("#popUp").delay(1800).fadeOut();

}