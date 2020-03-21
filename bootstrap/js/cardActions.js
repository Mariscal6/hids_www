function hideCard(element) {
    var affected = element.getAttribute('affects');
    $('#' + affected).remove();

    var cardsLeft = document.getElementsByName("reportCard").length;
    console.log(cardsLeft);

    if (cardsLeft == 0) {
        $('#reportsRead').removeAttr('hidden');
    }
}