$(document).ready(function () {
    $('.dec').each(function () {
        $(this).on('click', function () {
            var input = $(this).siblings('.quantity-input');

            if (input) {
                var quantidade = parseInt(input.val());
                console.log(quantidade);
                console.log(input);
                if (quantidade > 1) {
                    input.val(quantidade - 1);
                }
            }
        });

    });

    $('.inc').each(function () {
        $(this).on('click', function () {
            var input = $(this).siblings('.quantity-input');
            if (input) {
                var quantidade = parseInt(input.val());
                input.val(quantidade + 1);
            }
        });

    });

    $('.quantity-input').each(function () {
        $(this).on('change', function () {
            if (this.value === '' || this.value === '0' || this.value < 0) {
                this.value = 1;
            }
        });
    });

    $('#quantitySub').click(function () {
        $('#carrinho').submit();
    })

    $('#apply-coupon').on('click', function () {
        var couponCode = $('#coupon-code').val().trim();
        if (couponCode) {
            $('#coupon-text').text("Cupão aplicado: " + couponCode);
            $('#coupon-section').show();
            $('#codigo').val(couponCode);
        }else{
            $('#codigo').val('');
        }
    });


    $('#remove-coupon').on('click', function () {
        $('#coupon-section')[0].style.setProperty('display', 'none', 'important');
        $('#coupon-code').val('');
        $('#codigo').val('');
    });
});