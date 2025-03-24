$(document).ready(function() {
    $("#searchLoup").on("click", function() {
        const element = document.getElementById("hidenInput");
        var transformStyle = window.getComputedStyle(element, null).getPropertyValue('transform');
        var matrix = transformStyle.match(/^matrix\((.+)\)$/);
        if (matrix) {
            matrix = matrix[1].split(',').map(parseFloat);
            var scaleX = matrix[0];
        }
        if(scaleX === 0){
            element.style.cssText = 'transform: scale(1, 1);';
        } else {
            element.style.cssText = 'transform: scale(0, 0);';
        }
    });
});