$(document).ready(function(){
    // allo stato iniziale solo la prima immagine è visibili
    $("main > section:last-child > div > img").hide();
    var $shownImage = $("main > section:last-child > div > img:first-child")
        .show()
        .addClass("shown");
    
    //funzionamento al click di prev
    $("main > section > img:nth-of-type(1)").click(function() {
        $shownImage
            .removeClass("shown")
            .hide();
        if ($shownImage.index()) {
            $shownImage = $shownImage
                .prev()
                .show()
                .addClass("shown");
        } else {
            $shownImage = $("main > section:last-child > div > img:last-child")
                .show()
                .addClass("shown");
        }
    });

    //funzionamento al click di next
    $("main > section > img:nth-of-type(2)").click(function() {
        $shownImage
            .removeClass("shown")
            .hide();
        if ($shownImage.index() != $("main > section:last-child > div > img").length - 1) {
            $shownImage = $shownImage
                .next()
                .show()
                .addClass("shown");
        } else {
            $shownImage = $("main > section:last-child > div > img:first-child")
                .show()
                .addClass("shown");
        }
    });

    //funzionamento click di un'immagine (non funziona sul mio chrome :C)
    $("main > section:last-child > div > img").click(function() {
        var $id = $(this).attr("alt");
        window.location = `singolo-prodotto.php?idMaglia=${$id}`;
    });
});