$(function(){
    $('.like-btn').on('click', function() {
        var heartIcon = $(this).find('i');
        var likesCountElement = $(this).next('.likes-count');
        var form = $(this).closest('.review-card').find('.like-form');

        if (this.classList.contains('liked')) {
            this.classList.remove('liked');
            this.classList.add('unliked');
            heartIcon.removeClass('fas').addClass('far');
            var likesCount = parseInt(likesCountElement.text()) - 1;
            likesCountElement.text(likesCount);
        } else {
            this.classList.remove('unliked');
            this.classList.add('liked');
            heartIcon.removeClass('far').addClass('fas');
            var likesCount = parseInt(likesCountElement.text()) + 1;
            likesCountElement.text(likesCount);
        }
        setTimeout(function() {
            form.submit();
        }, 1000);

    });
});