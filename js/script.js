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
        if ($(this).data('action') == 'add')
            $.get('functions.php?function=order.add&' + $(this).closest('form').serialize(), (data) => {
                data = JSON.parse(data);

                if (data.result == 'fail') console.log(data);
                else if (data.result == 'success') location.reload();
            });
        else if ($(this).data('action') == 'save')
            $.get(
                'functions.php?function=order.save&orderID=' +
                    parseInt($(this).data('orderId')) +
                    '&clientID=' +
                    parseInt($(this).data('clientId')) +
                    '&executerID=' +
                    parseInt($(this).data('executerId')) +
                    '&' +
                    $(this).closest('form').serialize(),
                function (data) {
                    data = JSON.parse(data);

                    if (data.result == 'fail') console.log(data);
                    else if (data.result == 'success') location.reload();
                }
            );
    });

    $('#js-executerBtn').on('click', function () {
        if ($(this).data('action') == 'add')
            $.get('functions.php?function=executer.add&' + $(this).closest('form').serialize(), function (data) {
                data = JSON.parse(data);

                if (data.result == 'fail') console.log(data);
                else if (data.result == 'success') location.reload();
            });
        else if ($(this).data('action') == 'save')
            $.get(
                'functions.php?function=executer.save&id=' +
                    $(this).data('executer-id') +
                    '&' +
                    $(this).closest('form').serialize(),
                function (data) {
                    data = JSON.parse(data);

                    if (data !== true) console.log(data);
                    else if (data === true) location.reload();
                }
            );
    });

    $('.js-openOrderModal').on('click', function () {
        if ($(this).data('change-modal')) {
            $('#orderModal .modal-title').text('Изменить заказ');
            $('#orderModal #js-orderBtn').data('action', 'save').data('orderId', $(this).text()).text('Сохранить');

            $.get('functions.php?function=order.get&id=' + parseInt($(this).text()), function (data) {
                data = JSON.parse(data);

                $('#clientDeviceDesc').val(data.deviceDesc);
                $('#clientDeviceDefectDesc').val(data.deviceDefect);
                $('#preliminaryPrice').val(data.preliminaryPrice);
                $('#orderStatus').val(data.status);
                $('#executerWorkFinish').val(data.dateFinish);

                $.get('functions.php?function=client.get&id=' + parseInt(data.client), (dataClient) => {
                    dataClient = JSON.parse(dataClient);

                    $('#orderModal #clientFullName').val(dataClient.fullName);
                    $('#orderModal #clientPhoneDataList').val(dataClient.phone);
                });

                $.get('functions.php?function=device.getByID&deviceID=' + parseInt(data.deviceID), (dataDevice) => {
                    dataDevice = JSON.parse(dataDevice);

                    $('#orderModal #clientDeviceDataList').val(dataDevice.name);
                    $('#orderModal #clientDeviceSN').val(dataDevice.number);
                });

                $.get('functions.php?function=executer.get&id=' + parseInt(data.executer), (dataExecuter) => {
                    dataExecuter = JSON.parse(dataExecuter);

                    $('#orderModal #executerDataList').val(dataExecuter.fullName);
                });
            });
        } else {
            $('#orderModal .modal-title').text('Добавить заказ');
            $('#orderModal #js-orderBtn').data('action', 'add').text('Добавить');
        }
    });

    $('.js-openExecuterModal').on('click', function () {
        $.get('functions.php?function=executer.get&id=' + parseInt($(this).text()), (data) => {
            data = JSON.parse(data);

            $('#executerFullName').val(data.fullName);
            $('#executerPhone').val(data.phone);
            $('#workType').val(data.workType);
            $('#executerDesc').val(data.executerDesc);

            $('#js-executerBtn').data('action', 'save').data('executer-id', $(this).text()).text('Сохранить');
        });
    });

    $('.js-openClientModal').on('click', function () {
        $.get('functions.php?function=client.get&id=' + parseInt($(this).data('client-id')), (data) => {
            data = JSON.parse(data);

            $('#clientModal #clientFullName').val(data.fullName);
            $('#clientModal #clientPhone').val(data.phone);
            $('#clientModal #clientDesc').val(data.description);

            $('#js-clientBtn').data('action', 'save').data('client-id', $(this).data('client-id')).text('Сохранить');

            $.get('functions.php?function=device.get&clientID=' + parseInt($(this).data('client-id')), (data) => {
                data = JSON.parse(data);

                var html =
                    '<tr class="text-center"><th class="py-2 bg-light text-dark">Название</th><th class="py-2 bg-light text-dark">Серийный номер/IMEI</th></tr>';

                data.forEach((row) => {
                    html += '<tr class="text-center"><td>' + row.name + '</td><td>' + row.number + '</td></tr>';
                });

                $('#clientDevices table').html('<tbody>' + html + '</tbody>');
            });

            $.get(
                'functions.php?function=orders.getByClient&clientID=' + parseInt($(this).data('client-id')),
                (data) => {
                    data = JSON.parse(data);

                    var html =
                        '<tr class="text-center"><th class="py-2 bg-light text-dark">Номер заказа</th><th class="py-2 bg-light text-dark">Срок заказа</th><th class="py-2 bg-light text-dark">Статус</th><th class="py-2 bg-light text-dark">Создан</th><th class="py-2 bg-light text-dark">Исполнитель</th><th class="py-2 bg-light text-dark">Устройства</th></tr>';

                    data.forEach((row) => {
                        var status = '',
                            dateFinish = new Date(parseInt(row.dateFinish) * 1000),
                            dateCreate = new Date(parseInt(row.dateCreate) * 1000);

                        if (row.status == 'new')
                            status = '<div class="rounded bg-primary text-white text-center">Новый</div>';

                        if (row.status == 'inWork')
                            status = '<div class="rounded bg-warning text-white text-center">В работе</div>';

                        if (row.status == 'executed')
                            status = '<div class="rounded bg-success text-white text-center">Исполнен</div>';

                        if (row.status == 'canceled')
                            status = '<div class="rounded bg-danger text-white text-center">Отменен</div>';

                        html += '<tr class="text-center">';
                        html += '<td class="align-middle">';
                        html += row.id;
                        html += '</td>';
                        html += '<td class="align-middle">';

                        if (row.dateFinish == null) html += 'Не установлено';
                        else html += formatDate(dateFinish);

                        html += '</td>';
                        html += '<td class="align-middle">';
                        html += status;
                        html += '</td>';
                        html += '<td class="align-middle">';

                        html += row.createBy + '<small class="text-secondary">' + formatDate(dateCreate) + '</small>';

                        html += '</td>';
                        html += '<td class="align-middle">';
                        html += row.executer;
                        html += '</td>';
                        html += '<td class="align-middle">';
                        html += row.deviceID;
                        html += '</td>';
                        html += '</tr>';
                    });

                    $('#clientOrders table').html('<tbody>' + html + '</tbody>');
                }
            );
        });
    });

    $('#js-clientBtn').on('click', function () {
        if ($(this).data('action') == 'save')
            $.get(
                'functions.php?function=client.save&id=' +
                    $(this).data('client-id') +
                    '&' +
                    $(this).closest('form').serialize(),
                function (data) {
                    data = JSON.parse(data);

                    if (data !== true) console.log(data);
                    else if (data === true) location.reload();
                }
            );
    });

    if ($('#orderModal').length) clearModal('orderModal');

    if ($('#executerModal').length) clearModal('executerModal');
});

function clearModal(id) {
    var orderModal = document.getElementById(id);
    orderModal.addEventListener('hide.bs.modal', function () {
        setTimeout(() => {
            $('#' + id + ' input, #' + id + ' textarea').val('');
            $('#' + id + ' .btn')
                .text('Добавить')
                .data('action', 'add');
        }, 100);
    });
}

function formatDate(date) {
    var dd = date.getDate();
    if (dd < 10) dd = '0' + dd;

    var mm = date.getMonth() + 1;
    if (mm < 10) mm = '0' + mm;

    var yy = date.getFullYear();

    return dd + '.' + mm + '.' + yy;
}
