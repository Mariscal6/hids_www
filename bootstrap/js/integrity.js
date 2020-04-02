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
    $('#filterForm').submit();
}