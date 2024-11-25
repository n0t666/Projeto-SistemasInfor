$('.dec').each(function(){
    $(this).on('click', function(){
        var input = $(this).siblings('.quantity-input');

        if(input){
            var quantidade = parseInt(input.val());
            console.log(quantidade);
            console.log(input);
            if(quantidade > 1){
                input.val(quantidade - 1);
            }
        }
    });

});

$('.inc').each(function(){
    $(this).on('click', function(){
        var input = $(this).siblings('.quantity-input');
        if(input){
            var quantidade = parseInt(input.val());
            console.log(quantidade);
            console.log(input);
            if (quantidade < 5) {
                input.val(quantidade + 1);
            }
        }
    });

});

$('.quantity-input').each(function(){
    $(this).on('change', function(){
        if (this.value === '' || this.value === '0' || this.value > 5) {
            this.value = 1;
        }
    });
});

$('#quantitySub').click(function(){
    $('#carrinho').submit();
})