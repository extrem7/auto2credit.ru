const MobileMenu = {
    toggleMenuMobile() {
        $('.mobile-btn').toggleClass('open');
        $('.menu-container, body').toggleClass('open-menu');
    },
    controller() {
        $("#mobile-menu").click(() => {
            this.toggleMenuMobile();
        });
    }
};

class Mail {
    constructor() {
        this.stopPhones = ['+7 (111) 111-11-11', '+7 (222) 222-22-22', '+7 (333) 333-33-33', '+7 (444) 444-44-44',
            '+7 (555) 555-55-55', '+7 (666) 666-66-66', '+7 (777) 777-77-77', '+7 (888) 888-88-88', '+7 (999) 999-99-99',
            '+7 (000) 000-00-00'];
        $('#callback :input[type=submit]').click((e) => {
            e.preventDefault();
            const val = $('#callback input[name=phone]').val();
            if (val && !this.stopPhones.includes(val)) {
                $('#callback .input-validate').removeClass('error');
                this.contact();
            } else {
                $('#callback .input-validate').addClass('error');
            }
        });
    }

    contact() {
        const data = {
            action: 'contact',
            subject: 'Заказать звонок',
            name: $('#callback input[name=name]').val(),
            tel: $('#callback input[name=phone]').val()
        };
        this.send(data);
    }

    send(data) {
        $('#callback :input[type=submit]').prop('disabled', true);
        $.post(AdminAjax, data).done((res) => {
            res = JSON.parse(res);
            $('.modal').modal('hide');
            if (res.status === 'ok') {
                $('#success').modal('show');
                $("#callback form")[0].reset();
                $('#callback :input[type=submit]').prop('disabled', false);
            } else {
                $('#sorry').modal('show');
            }
            setTimeout(() => {
                $('.modal').modal('hide');
            }, 5000);
        });
    }
}

$(() => {
    $('.seo_link').click(function (e) {
        window.open(
            $(this).data('link')
        );
        return false;
    });
    $(window).on('load resize scroll', () => {
        if ($(this).scrollTop() > 50 && window.innerWidth > 992) {
            $(".header").addClass('sticky-header');
        } else {
            $(".header").removeClass('sticky-header');
        }
    });
    $('.modal .phone').inputmask("mask", {"mask": "+7 (999) 999-99-99", "clearIncomplete": true});
    $("#arrow-down").click(function () {
        $('html, body').animate({
            scrollTop: $(".mult-1").offset().top - 50
        }, 1000);
    });
    $('#geoapi select').change(function () {
        $(this).closest('form').submit();
    });
    MobileMenu.controller();
    new WOW({mobile: false}).init();
    new Mail();
});

$(window).on('load', () => {
    setTimeout(() => {
        ReLoadImages();
    }, 1500);
});

function ReLoadImages() {
    $('*[data-lazysrc]').each(function () {
            $(this).attr('src', $(this).attr('data-lazysrc'));
        }
    );
}