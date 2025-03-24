function changeDis() {
    let i;
    var e = document.getElementById("agreeWithConf");
    if (e.checked) {
        document.getElementById("confirmButt").removeAttribute("disabled");
        document.getElementById("confirmButt").className = 'tempClass';
    } else {
        document.getElementById("confirmButt").setAttribute("disabled", true);
        document.getElementById("confirmButt").className = 'sendButt';
    }
}

$(document).ready(function () {
    $("#okButt").on("click", function () {
        (document).getElementById("mWindow").style.visibility = "hidden";
        (document).getElementById("forErrors").innerHTML = '';
        $("#myForm")[0].reset();
    });
    $('.input-file input[type=file]').on('change', function(){
        let file = this.files[0];
        $(this).next().html(file.name);
    });
});