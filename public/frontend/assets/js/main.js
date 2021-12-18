$(document).ready(function() {
    var slider = $('#imageGallery').lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        thumbItem: 6,
        slideMargin: 0,
        enableDrag: false,
        currentPagerPosition: 'left',
        onSliderLoad: function (el) {
            el.lightGallery({
                selector: '#imageGallery .lslide'
            });
        }
    });


    $('#orderBy').change(function () {
        $('#filter-arrange').submit();
    })

    $('.filter-price,.filter-brand').click(function () {
        $('#filter-price').submit();
    })

});
