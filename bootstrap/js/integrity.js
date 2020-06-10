$(document).ready(function() {
    
});

function clearFilters() {
    var maxDays = document.getElementById('maxDays');
    maxDays.value = 100;
    var maxFiles = document.getElementById('maxFiles');
    maxFiles.value = 100;
    var dayOrder = document.getElementById('dayOrder');
    dayOrder.selectedIndex = 1;
    var fileOrder = document.getElementById('fileOrder');
    fileOrder.selectedIndex = 1;
    var md5 = document.getElementById('md5');
    md5.value = "";
    var sha1 = document.getElementById('sha1Hash');
    sha1.value = "";
    var fileName = document.getElementById('fileName');
    fileName.value = "";
}
