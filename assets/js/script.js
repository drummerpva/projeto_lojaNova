$(function () {
    if (typeof maxSlider != "undefined") {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: maxSlider,
            values: [$("#slider0").val(), $("#slider1").val()],
            slide: function (event, ui) {
                $("#amount").val("R$ " + ui.values[ 0 ] + " - R$ " + ui.values[ 1 ]);
            },
            change: function (event, ui) {
                $("#slider" + ui.handleIndex).val(ui.value);
                $(".filterarea form").submit();
            }
        });
    }
    $("#amount").val("R$ " + $("#slider-range").slider("values", 0) +
            " - R$ " + $("#slider-range").slider("values", 1));
    $(".filterarea").find("input").bind("change", function () {
        $(".filterarea form").submit();
    });

    $(".formAddCart button").bind("click", function (e) {
        e.preventDefault();
        var qt = parseInt($(".addToCartQT").val());
        if ($(this).html() == "-" && qt > 1) {
            qt--;
        } else if ($(this).html() == "+") {
            qt++;
        }
        $(".addToCartQT").val(qt);
        $("input[name=qtProduct]").val(qt);

    });
    $(".photoItem").on("click", function () {
        var url = $(this).find("img").attr('src');
        $('.mainPhoto img').attr("src", url);
    });

});