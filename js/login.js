const loginAdd = document.querySelector('.loginAdd');
const loginInput = document.querySelectorAll('.login-input-php');
const madalLogin = document.querySelector('.madalLogin');
const madalLoginTetx = document.querySelector('.madalLogin p');

loginAdd.addEventListener('click', (e) => {
    loginInput.forEach((element, index) => {
        if (element.value === '') {
            element.style.border = '1px solid red';
        }
    });
});
$(function () {
    $('.loginAdd').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'http://localhost/bekend/kocka_admin/server.php?action=login',
            type: 'GET',
            data: {
                login: $('.login-input-php').val(),
                password: $('.login-input-php-password').val()
            },
            success: function (response) {
                let data = JSON.parse(response);
                if (data['status'] == 200) {
                    window.location = data['message'];
                }
                else if (data['status'] == 404) {
                    madalLogin.classList.add('active');
                    madalLoginTetx.innerHTML = `${data['message']}`
                    loginInput.forEach((element, index) => {
                        element.style.border = '1px solid red';
                    });
                }
                else if (data['status'] == 500) {
                    madalLogin.classList.add('active');
                    madalLoginTetx.innerHTML = `${data['message']}`
                }
            },
            error: function (data) {
                alert('Xatolik !');
            }
        })
    })
});
setInterval(() => {
    madalLogin.classList.remove('active');
    loginInput.forEach((element, index) => {
        element.style.border = 'none';
    });
}, 5000);