$(document).ready(function () {
    $("#myForm").on("submit", function () {
        event.preventDefault();
        if (!(document.getElementById("confirmButt").hasAttribute("disabled") || document.getElementById("confirmButt").disabled === "true")) {
            $.ajax({
                url: '/template/assets/code/php/scripts/formHandler.php',
                method: 'post',
                dataType: 'html',
                data: $(this).serialize(),
                success: dataFromAjaxPHP,
                error: function (jqXHR, exception) {
                    if (jqXHR.status === 0) {
                        alert('Not connect. Verify Network.');
                    } else if (jqXHR.status == 404) {
                        alert('Requested page not found (404).');
                    } else if (jqXHR.status == 500) {
                        alert('Internal Server Error (500).');
                    } else if (exception === 'parsererror') {
                        alert('Requested JSON parse failed.');
                    } else if (exception === 'timeout') {
                        alert('Time out error.');
                    } else if (exception === 'abort') {
                        alert('Ajax request aborted.');
                    } else {
                        alert('Uncaught Error. ' + jqXHR.responseText);
                    }
                }
            })
        }
    });

    function dataFromAjaxPHP(data) {
        var test = JSON.parse(data);
        (document).getElementById("mWindow").style.visibility = "visible";
        for (key in test) {
            if (test.hasOwnProperty(key)) {
                console.log(test[key]);
                message(test[key]);
            }
        }
    }
})

function message(errorCode) {
    //errors map
    const arr = new Map([
        ['1', 'Вы пытаетесь отправить пустую форму. Пожалуйста, заполните все обязательные(*) поля.'],
        ['2', 'Вы заполнили не все обязательные(*) поля. Введите название организации.'],
        ['3', 'Вы заполнили не все обязательные(*) поля. Введите фамилию и имя представителя.'],
        ['4', 'Вы заполнили не все обязательные(*) поля. Введите номер телефона.'],
        ['5', 'Вы заполнили не все обязательные(*) поля. Введите email-адрес.'],
        ['6', 'Вы заполнили не все обязательные(*) поля. Введите регион комм. деятельности.'],
        ['7', 'Некорректный формат названия организации'],
        ['8', 'Некорректный формат фамилии и имени представителя'],
        ['9', 'Некорректный формат номера телефона'],
        ['10', 'Некорректный формат email-адреса'],
        ['11', 'Некорректный формат региона комм. деятельности']
    ])
    //checking error codes
    for (let key of arr.keys()) {
        if (key === errorCode) {
            const $newP = document.createElement('p');
            $newP.textContent = arr.get(key);
            const $mess = document.querySelector('#forErrors');
            $mess.appendChild($newP);
        }
    }
}