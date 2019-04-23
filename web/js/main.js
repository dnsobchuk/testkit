function loading(action) 
{
    if (action === 'show') {
        $('.lightbox').show();
    } else {
        $('.lightbox').hide();
    }

}

function genPass() 
{
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var password = "";
    for (var i = 0; i < 8; i++) {
        password += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    $('#user-password, #user-passwordrepeat').val(password);
    $('#user-password, #user-passwordrepeat').prop('type', 'password');
};

function inputPass(obj)
{
    $(obj).prop('type', 'password');
}

function inputText(obj)
{
    $(obj).prop('type', 'text');
}

function closeModal() 
{
    $('#resultModal').modal('hide');
};

