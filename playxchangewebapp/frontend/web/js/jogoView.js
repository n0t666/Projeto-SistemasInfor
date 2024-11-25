$(function(){
    const plataformaDropdown = $("#plataforma-dropdown");
    const elementoPreco = $("#product-price");
    const cartButtons = document.querySelectorAll('.cart-button');


    plataformaDropdown.on("change", function(){ // Quando ua opção é selecionada
        const opcaoSelecionada = $(this).children("option:selected"); // Obter elemento selecionada para consultar atributo do preço
        const preco = opcaoSelecionada.data('preco');

        if(preco){
            elementoPreco.text(preco + '€');
        }else{
            elementoPreco.hide();
        }
    });

    $('#decrement').on('click', function() {
        var quantidade = parseInt($('#linhacarrinho-quantidade').val());
        if (quantidade > 1) {
            $('#linhacarrinho-quantidade').val(quantidade - 1);
        }
    });

    $('#increment').on('click', function () {
        var quantidade = parseInt($('#linhacarrinho-quantidade').val());
        if(quantidade < 5){
            $('#linhacarrinho-quantidade').val(quantidade + 1);
        }
    });

    $('#linhacarrinho-quantidade').change(function() { // Caso o cliente tente apagar a informação colocar sempre o número 1
        if (this.value === '' || this.value === '0' || this.value > 5) {
            this.value = 1;
        }
    });

    $('.cart-button').on('click', function() {
        var quantidade = parseInt($('#linhacarrinho-quantidade').val());
        if($('#plataforma-dropdown').val() && quantidade > 0 && quantidade <= 5){
            var button = $(this);

            button.addClass('clicked');

            setTimeout(function() {
                $('#jogo-carrinho').submit();
            }, 50000);
        }


    });




});