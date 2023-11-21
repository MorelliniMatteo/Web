$(document).ready(function(){
    // allo stato iniziale solo la prima immagine è visibile
    $("main > section > div > img:last-of-type").hide();
    var $shownImage = $("main > section > div > img:first-of-type")
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
            $shownImage = $("main > section > div > img:last-of-type")
                .show()
                .addClass("shown");
        }
    });

    //funzionamento al click di next
    $("main > section > img:nth-of-type(2)").click(function() {
        $shownImage
            .removeClass("shown")
            .hide();
        if ($shownImage.index() != $("main > section > div > img").length - 1) {
            $shownImage = $shownImage
                .next()
                .show()
                .addClass("shown");
        } else {
            $shownImage = $("main > section > div > img:first-of-type")
                .show()
                .addClass("shown");
        }
    });

});
