<?php session_start(); ?>
<?php
if ($_SESSION['user'] == '')
    header('Location: /');
?>

<?php
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Заказы</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous"
        ></script>
        <script src="js/jquery.mask.js"></script>
        <script src="js/script.js"></script>

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    </head>
    <body>
        <header class="p-3 mb-3 border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="orders.php" class="nav-link px-2 link-secondary">Заказы</a></li>
                        <li><a href="executers.php" class="nav-link px-2 link-dark">Исполнители</a></li>
                        <li><a href="clients.php" class="nav-link px-2 link-dark">Клиенты</a></li>
                    </ul>

                    <div class="dropdown text-end">
                        <a
                            href="#"
                            class="d-block link-dark text-decoration-none dropdown-toggle"
                            id="dropdownUser1"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-person-square"></i>
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#" id="js-deauthentication">Выйти</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="container">
                <div class="d-flex justify-content-between mb-3">
                    <button type="button" class="btn btn-success js-openModal" data-bs-toggle="modal" data-bs-target="#orderModal" data-change-modal="false">
                        <i class="bi bi-plus"></i>
                        Добавить
                    </button>
                    <div class="col-4">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control"
                                aria-describedby="button-addon"
                                placeholder="Найти"
                            />
                            <button class="btn btn-primary" type="button" id="button-addon">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <table class="w-100 table table-bordered">
                    <tr class="text-center">
                        <th class="py-2 bg-light text-dark">Номер заказа</th>
                        <th class="py-2 bg-light text-dark">Срок заказа</th>
                        <th class="py-2 bg-light text-dark">Статус</th>
                        <th class="py-2 bg-light text-dark">Создан</th>
                        <th class="py-2 bg-light text-dark">Исполнитель</th>
                        <th class="py-2 bg-light text-dark">Клиент</th>
                    </tr>

                    <?php
                    $order = new Order();
                    $user = new User();
                    $client = new Client();
                    $device = new Device();

                    $result = $order->get()['msg'];

                    while($row = $result->fetch_assoc()):?>
                        <tr class="text-center">
                            <td class="align-middle">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#orderModal" data-change-modal="true" class="js-openModal">
                                    <?= $row['id'] ?>
                                </a>
                            </td>
                            <td class="align-middle">
                                <?php if ($row['dateFinish'] == NULL || $row['dateFinish'] == 0):?>
                                    Не указано
                                <?php else:
                                    echo date('d.m.Y', $row['dateFinish']);
                                endif; ?>
                            </td>
                            <td class="align-middle">
                                <?php if ($row['status'] == 'new'): ?>
                                    <div class="rounded bg-primary text-white text-center">Новый</div>
                                <?php endif; ?>
                                <?php if ($row['status'] == 'inWork'): ?>
                                    <div class="rounded bg-warning text-white text-center">В работе</div>
                                <?php endif; ?>
                                <?php if ($row['status'] == 'executed'): ?>
                                    <div class="rounded bg-success text-white text-center">Исполнен</div>
                                <?php endif; ?>
                                <?php if ($row['status'] == 'canceled'): ?>
                                    <div class="rounded bg-danger text-white text-center">Отменен</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['createBy'] != NULL || $row['createBy'] != ''): ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#managerModal" data-userID="<?=$row['createBy']?>">
                                        <?=$user->get($row['createBy'], ['fullName'])['msg']->fetch_assoc()['fullName'];?>
                                    </a>
                                <?php else: ?>
                                    Не указано
                                <?php endif; ?>
                                <div><small class="text-secondary">
                                    <?php if ($row['dateCreate'] == NULL || $row['dateCreate'] == 0):?>
                                        Не указано
                                    <?php else:
                                        echo date('d.m.Y', $row['dateCreate']);
                                    endif; ?>
                                </small></div>
                            </td>
                            <td class="align-middle">
                                <?php if ($row['executer'] != NULL || $row['executer'] != ''): ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#executerModal" data-execuerID="<?=$row['executer']?>">
                                        <?=$user->get($row['executer'], ['fullName'])['msg']->fetch_assoc()['fullName'];?>
                                    </a>
                                <?php else: ?>
                                    Не указано
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['client'] != NULL || $row['client'] != ''): ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#clientModal" data-execuerID="<?=$row['client']?>">
                                        <?=$client->get($row['client'], ['fullName'])['msg']->fetch_assoc()['fullName'];?>
                                    </a>
                                <?php else: ?>
                                    Не указано
                                <?php endif; ?>

                                <div>
                                    <small class="text-secondary" data-deviceID="<?=$row['deviceID']?>">
                                        <?php if ($row['deviceID'] != NULL || $row['deviceID'] != ''): ?>
                                            <?php print_r($device->get($row['deviceID'], ['name'])['msg']->fetch_assoc()['name']);?>
                                        <?php else: ?>
                                            Не указано
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </main>

        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Добавить заказ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="clientPhoneDataList" class="form-label">Номер телефона клиента</label>
                                <input
                                    class="form-control js-phone"
                                    id="clientPhoneDataList"
                                    placeholder="+7 (999) 876 54 32"
                                    name="clientPhone"
                                />
                                <datalist id="clientPhoneOptions">
                                    <option value="+7 (999) 876 54 32">Иванов Иван</option>
                                    <option value="+7 (991) 876 54 33">Петров Петр</option>
                                    <option value="+7 (929) 866 54 34">Алексеев Алексей</option>
                                    <option value="+7 (994) 276 54 35">Дмитриев Дмитрий</option>
                                    <option value="+7 (919) 876 54 36">Прохоров Прохор</option>
                                </datalist>
                            </div>
                            <div class="col-8">
                                <label for="clientFullName" class="form-label">ФИО клиента</label>
                                <input
                                    class="form-control"
                                    id="clientFullName"
                                    placeholder="Иванов Иван Иванович"
                                    name="clientFullName"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="clientDeviceDataList" class="form-label">Устройство</label>
                                <input
                                    class="form-control"
                                    list="clientDeviceOptions"
                                    id="clientDeviceDataList"
                                    placeholder="Samsung Galaxy A5"
                                    name="clientDevice"
                                />
                                <datalist id="clientDeviceOptions">
                                    <option value="15326478532156933">Samsung Galaxy A5</option>
                                    <option value="12365478521452612">Samsung Galaxy A6</option>
                                    <option value="25632541789654122">Apple iPhone SE</option>
                                </datalist>
                            </div>
                            <div class="col-6">
                                <label for="clientDeviceSN" class="form-label">Серийный номер/IMEI</label>
                                <input
                                    class="form-control"
                                    id="clientDeviceSN"
                                    placeholder="359289040436509"
                                    name="clientDeviceSN"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="clientDeviceDesc" class="form-label">Описание устройства</label>
                                <textarea
                                    class="form-control"
                                    placeholder="Царапины на экране"
                                    id="clientDeviceDesc"
                                    name="clientDeviceDesc"
                                ></textarea>
                            </div>
                            <div class="col-6">
                                <label for="clientDeviceDefectDesc" class="form-label">Описание дефекта</label>
                                <textarea
                                    class="form-control"
                                    placeholder="Не работает камера"
                                    id="clientDeviceDefectDesc"
                                    name="clientDeviceDefectDesc"
                                ></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="preliminaryPrice" class="form-label">Предварительная цена</label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="1000"
                                        aria-describedby="preliminaryPriceDesc"
                                        id="preliminaryPrice"
                                        name="preliminaryPrice"
                                    />
                                    <span class="input-group-text" id="preliminaryPriceDesc">руб.</span>
                                </div>
                            </div>
                            <div class="col-8">
                                <label for="executorDataList" class="form-label">Исполнитель</label>
                                <input
                                    class="form-control"
                                    list="executorOptions"
                                    id="executorDataList"
                                    name="executor"
                                    placeholder="Иванов Иван Иванович"
                                />
                                <datalist id="executorOptions">
                                    <option value="Иванов Иван"></option>
                                    <option value="Петров Петр"></option>
                                    <option value="Петров Петр"></option>
                                    <option value="Дмитриев Дмитрий"></option>
                                    <option value="Прохоров Прохор"></option>
                                </datalist>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="totalPrice" class="form-label">Итоговая цена</label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="1000"
                                        aria-describedby="totalPriceDesc"
                                        id="totalPrice"
                                        name="totalPrice"
                                    />
                                    <span class="input-group-text" id="totalPriceDesc">руб.</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="clientDeviceSN" class="form-label">Статус</label>
                                <select class="form-select" name="status" id="orderStatus">
                                    <option value="new" class="text-primary" selected>Новый</option>
                                    <option value="inWork" class="text-warning">В работе</option>
                                    <option value="executed" class="text-success">Исполнен</option>
                                    <option value="canceled" class="text-danger">Отменен</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="executorWorkFinish" class="form-label">Дата выполнения</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="executorWorkFinish"
                                    name="executorWorkFinish"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="executorWorkDesc" class="form-label">Описание работы</label>
                                <textarea
                                    class="form-control"
                                    placeholder="Заменен модуль камеры"
                                    id="executorWorkDesc"
                                    name="executorWorkDesc"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="js-orderBtn" data-action="add">Добавить</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="managerModal" tabindex="-1" aria-labelledby="managerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="managerModalLabel">Информация о менеджере</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="managerFullName" class="form-label">ФИО менеджера</label>
                                <input
                                    class="form-control"
                                    id="managerFullName"
                                    placeholder="Иванов Иван Иванович"
                                    value="Никулина Ирина"
                                />
                            </div>
                            <div class="col-4">
                                <label for="managerPhone" class="form-label">Номер телефона</label>
                                <input
                                    class="form-control js-phone"
                                    id="managerPhone"
                                    placeholder="+7 (999) 876 54 32"
                                    value="+7 (999) 876 54 32"
                                />
                            </div>
                            <div class="col-4">
                                <label for="managerPass" class="form-label">Пароль</label>
                                <div class="input-group js-pass">
                                    <input
                                        type="password"
                                        class="form-control"
                                        placeholder="******"
                                        aria-describedby="managerPassDesc"
                                        id="managerPass"
                                    />
                                    <button class="btn btn-primary" type="button" id="managerPassDesc">
                                        <i class="bi bi-eye-slash-fill"></i>
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <tr class="text-center">
                                        <th class="py-2 bg-light text-dark">Номер заказа</th>
                                        <th class="py-2 bg-light text-dark">Срок заказа</th>
                                        <th class="py-2 bg-light text-dark">Статус</th>
                                        <th class="py-2 bg-light text-dark">Исполнитель</th>
                                        <th class="py-2 bg-light text-dark">Клиент</th>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="align-middle">
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#orderModal"
                                                data-bs-dismiss="modal"
                                                >1</a
                                            >
                                        </td>
                                        <td class="align-middle">24.04.2021</td>
                                        <td class="align-middle">
                                            <div class="rounded bg-success text-white text-center">Исполнен</div>
                                        </td>
                                        <td class="align-middle">
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#executerModal"
                                                data-bs-dismiss="modal"
                                                >Иванов Пётр</a
                                            >
                                        </td>
                                        <td>
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#clientModal"
                                                data-bs-dismiss="modal"
                                                >Чащин Николай</a
                                            >
                                            <div><small class="text-secondary">Samsung A6</small></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="executerModal"
            tabindex="-1"
            aria-labelledby="executerModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="executerModalLabel">Информация об исполнителе</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="executerFullName" class="form-label">ФИО исполнителя</label>
                                <input
                                    class="form-control"
                                    id="executerFullName"
                                    placeholder="Иванов Иван Иванович"
                                    value="Никулина Ирина"
                                />
                            </div>
                            <div class="col-4">
                                <label for="executerPhone" class="form-label">Номер телефона</label>
                                <input
                                    class="form-control js-phone"
                                    id="executerPhone"
                                    placeholder="+7 (999) 876 54 32"
                                    value="+7 (999) 876 54 32"
                                    name="executerPhone"
                                />
                            </div>
                            <div class="col-4">
                                <label for="executerPass" class="form-label">Пароль</label>
                                <div class="input-group js-pass">
                                    <input
                                        type="password"
                                        class="form-control"
                                        placeholder="******"
                                        aria-describedby="executerPassDesc"
                                        id="executerPass"
                                    />
                                    <button class="btn btn-primary" type="button" id="executerPassDesc">
                                        <i class="bi bi-eye-slash-fill"></i>
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <tr class="text-center">
                                        <th class="py-2 bg-light text-dark">Номер заказа</th>
                                        <th class="py-2 bg-light text-dark">Срок заказа</th>
                                        <th class="py-2 bg-light text-dark">Статус</th>
                                        <th class="py-2 bg-light text-dark">Создан</th>
                                        <th class="py-2 bg-light text-dark">Клиент</th>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="align-middle">
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#orderModal"
                                                data-bs-dismiss="modal"
                                                >1</a
                                            >
                                        </td>
                                        <td class="align-middle">24.04.2021</td>
                                        <td class="align-middle">
                                            <div class="rounded bg-success text-white text-center">Исполнен</div>
                                        </td>
                                        <td>
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#managerModal"
                                                data-bs-dismiss="modal"
                                                >Никулина Ирина</a
                                            >
                                            <div><small class="text-secondary">20.04.2021</small></div>
                                        </td>
                                        <td>
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#clientModal"
                                                data-bs-dismiss="modal"
                                                >Чащин Николай</a
                                            >
                                            <div><small class="text-secondary">Samsung A6</small></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clientModalLabel">Информация о клиенте</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="clientFullName" class="form-label">ФИО клиента</label>
                                <input
                                    class="form-control"
                                    id="clientFullName"
                                    placeholder="Иванов Иван Иванович"
                                    value="Никулина Ирина"
                                    name="clientFullName"
                                />
                            </div>
                            <div class="col-4">
                                <label for="clientPhone" class="form-label">Номер телефона</label>
                                <input
                                    class="form-control js-phone"
                                    id="clientPhone"
                                    placeholder="+7 (999) 876 54 32"
                                    value="+7 (999) 876 54 32"
                                    name="clientPhone"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="clientDesc" class="form-label">Дополнительно</label>
                                <textarea
                                    class="form-control"
                                    placeholder="Любит брокколи"
                                    id="clientDesc"
                                    name="clientDesc"
                                ></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link active"
                                            id="home-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#home"
                                            type="button"
                                            role="tab"
                                            aria-controls="home"
                                            aria-selected="true"
                                        >
                                            Устройства
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link"
                                            id="profile-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#profile"
                                            type="button"
                                            role="tab"
                                            aria-controls="profile"
                                            aria-selected="false"
                                        >
                                            Заказы
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div
                                        class="tab-pane fade show pt-3 active"
                                        id="home"
                                        role="tabpanel"
                                        aria-labelledby="home-tab"
                                    >
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <th class="py-2 bg-light text-dark">Название</th>
                                                <th class="py-2 bg-light text-dark">Серийный номер/IMEI</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Samsung A6</td>
                                                <td>12365478963254484</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div
                                        class="tab-pane fade pt-3"
                                        id="profile"
                                        role="tabpanel"
                                        aria-labelledby="profile-tab"
                                    >
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <th class="py-2 bg-light text-dark">Номер заказа</th>
                                                <th class="py-2 bg-light text-dark">Срок заказа</th>
                                                <th class="py-2 bg-light text-dark">Статус</th>
                                                <th class="py-2 bg-light text-dark">Создан</th>
                                                <th class="py-2 bg-light text-dark">Исполнитель</th>
                                                <th class="py-2 bg-light text-dark">Устройства</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td class="align-middle">
                                                    <a
                                                        href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#orderModal"
                                                        data-bs-dismiss="modal"
                                                        >1</a
                                                    >
                                                </td>
                                                <td class="align-middle">24.04.2021</td>
                                                <td class="align-middle">
                                                    <div class="rounded bg-success text-white text-center">
                                                        Исполнен
                                                    </div>
                                                </td>
                                                <td>
                                                    <a
                                                        href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#managerModal"
                                                        data-bs-dismiss="modal"
                                                        >Никулина Ирина</a
                                                    >
                                                    <div><small class="text-secondary">20.04.2021</small></div>
                                                </td>
                                                <td class="align-middle">
                                                    <a
                                                        href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#executerModal"
                                                        data-bs-dismiss="modal"
                                                        >Иванов Пётр</a
                                                    >
                                                </td>
                                                <td>
                                                    Samsung A6
                                                    <div><small class="text-secondary">12365478963254484</small></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
