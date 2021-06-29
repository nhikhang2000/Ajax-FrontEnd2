//rating
var ratedIndex = -1;

$(document).ready(function () {
    resetStarColor();

    if(localStorage.getItem('ratedIndex') != null){
        setStar(parseInt(localStorage.getItem('ratedIndex')));
    }

    $('.star-rating').on('click', function () {
        ratedIndex = parseInt($(this).data('index'));
        localStorage.setItem('ratedIndex',ratedIndex);
    });

    $('.star-rating').mouseover(function(){
        resetStarColor();
        var curentIndext = parseInt($(this).data('index'));
        setStar(curentIndext);
    });
    $('.star-rating').mouseleave(function(){
        resetStarColor();

        if(ratedIndex != -1){
            setStar(ratedIndex);
        }
    });

});

function setStar(value){
    for(var i=0; i <= value; i++){
        $('.star-rating:eq('+i+')').css('color','#FF9900');
    }
}

function resetStarColor(){
    $('.star-rating').css('color', 'gray');
}
