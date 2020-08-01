$(document).ready(function () {
    menu();
    insertAccess();
    if(window.location.href.includes("home")){
        newlyAdded();
    }
    $("#card").keyup(prilagodiFormat);
    $("#register").click(proveraRegister);
    $("#successInfo").hide();
    $("#errorInfo").hide();
    if(window.location.href.includes("login")){
        $("#login").click(proveriLogin);
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
    data.forEach(el=>{
        output+=`
        <div class="col-lg-3 col-md-6">
            <div class="item">
                <img src="${el.path}" alt="${el.alt}" class="img-fluid"/>
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
    let regExpAddress = /^[A-Z][\w]{4,10}(\s[\w]{4,10}){0,3}(\s[0-9]{1,4})$/;

    let validnoIme, validnoNumber,  validnoPrezime, validnoMail, validnoUsername, validnoPass, validnoCredit, validnoCountry, validnoCity, validnoAddress, validnoCVV;

    validnoIme = proveraTb(ime, regExpName, 2);
    validnoPrezime = proveraTb(prezime, regExpLastName, 3);
    validnoMail = proveraTb(email, regExpEmail, 4);
    validnoUsername = proveraTb(username, regExpUsername, 5);
    validnoPass = proveraTb(password, regExpUsername, 6);
    validnoCredit = proveraTb(creditCard, regExpCreditCard, 7);
    validnoCVV = proveraTb(cvv, regExpCVV, 8);
    validnoCountry = proveraTb(country, regExpCountry, 9);
    validnoCity = proveraTb(city, regExpCountry, 10);
    validnoAddress = proveraTb(address, regExpAddress, 11);
    validnoNumber = proveraTb(number, regExpNumber, 12);
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
                if(data.redirect == true){
                    window.location.href = "index.php?page=login";
                }
                if(data.message == "You successfuly made account"){
                    $("#errorInfo").hide();
                    $("#successInfo").slideDown();
                }
            },
            error: function(error, status, message){
                if(error.responseText){
                    $("#successInfo").hide();
                    $("#errorInfo").slideDown();
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
    let username = $("#logUser");
    let password = $("#logPass");
    let validnoUsername, validnoPass;
    validnoPass = proveraTb(username, regExpUsername, 0);
    validnoUsername = proveraTb(password, regExpUsername, 1);
    if(validnoPass && validnoPass){
        $.ajax({
            type: "POST",
            url: "models/authorization/logIn.php",
            data: {
                username:username.val(),
                password:password.val(),
                action:"uloguj"
            },
            dataType: "json",
            success: function (data) {
                if(data.redirect == true){
                    window.location.href = "index.php?page=login";
                }
            },
            error: function(error, status, message){
        
            }
        });
    }
}