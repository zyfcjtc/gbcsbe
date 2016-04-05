function status_checking(status) {
    if(status == 'active')
        return true;
    else{
        alert("Please verify your email address first!");
        return false;
    }

}

function confirmation() {
    alert('Please login first.');
    return false;
}
function sucess_add_book() {
    alert('Book is added. The service will jump to main page in 5 sec');
}
function email_send()
{
    x = alert("Email has been sent!");
    window.history.back(-1);
}
function empty_uname()
{
    x = alert("Username cannot be empty!");
    window.history.back(-1);
}
function ck_uname()
{
    x = alert("Username does not exist!");
    window.history.back(-1);
}
function empty()
{
    x = alert("Please enter the username and password!");  
}
function check()
{
    x = alert("This username does not exist or the password is invalid!");
}