var wait = true;

$(document).ready(function() {
    var selector = $('#filter');
    var current = window.location.href;
    var all = current.split("?");
    if (all.length > 1) {
        var filterValue = all[1].split("=");
        var value = filterValue[1];
        selector.val(value).change();
    } else {
        wait = false; 
    }
});

function applyLimits(element) {
    if (wait) {
        wait = false;
    } else {
        var filter = element.options[element.selectedIndex].value;
        console.log(filter);
        var current = window.location.href;
        var all = current.split("?");
        var base = all[0];
        var url = base;
        if (filter > 0) {
            url += "?filter=" + filter;
        }
        
        window.location.href = url;
    }
}