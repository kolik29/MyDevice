$(() => {
    if ($('.js-phone').length) $('.js-phone').mask('+7 (000) 000 00 00');

    $('.js-pass').on('click', function () {
        var input = $(this).parent().find('input');
        if (input.attr('type') == 'password') input.attr('type', 'text');
        else input.attr('type', 'password');

        $(this).toggleClass('showPassword');
    });

    $('#js-btnAuth').on('click', function () {
        $.get('functions.php?function=authentication&' + $(this).closest('form').serialize(), function (data) {
            data = JSON.parse(data);

            if (data.result == 'fail') {
                $('#js-validation').text(data.msg);
                $('#formLogin, #formPassword').addClass('is-invalid');
            } else if (data.result == 'success') location.reload();
        });
    });

    $('#js-deauthentication').on('click', function () {
        $.get('functions.php?function=deauthentication', function (data) {
            data = JSON.parse(data);

            if (data.result == 'fail') console.log(data.msg);
            else if (data.result == 'success') location.reload();
        });
    });

    $('#js-orderBtn').on('click', function () {
        $.get('functions.php?function=order.add&' + $(this).closest('form').serialize(), function (data) {
            data = JSON.parse(data);

            if (data.result == 'fail') console.log(data);
            else if (data.result == 'success') location.reload();
        });
    });

    $('.js-openModal').on('click', function () {
        if ($(this).data('change-modal')) {
            $('#orderModal .modal-title').text('Изменить заказ');
            $('#orderModal #js-orderBtn').data('action', 'save').text('Сохранить');

            $.get('functions.php?function=order.get&id=' + parseInt($(this).text()), function (data) {
                data = JSON.parse(data);

                $('#clientDeviceDesc').val(data.deviceDesc);
                $('#clientDeviceDefectDesc').val(data.deviceDefect);
                $('#preliminaryPrice').val(data.preliminaryPrice);
                $('#orderStatus').val(data.status);
                $('#executorWorkFinish').val(data.dateFinish);
            });
        } else {
            $('#orderModal .modal-title').text('Добавить заказ');
            $('#orderModal #js-orderBtn').data('action', 'add').text('Добавить');
        }
    });
});
