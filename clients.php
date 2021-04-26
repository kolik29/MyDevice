<?php session_start(); ?>
<?php
if ($_SESSION['user'] == '')
    header('Location: /');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Клиенты</title>

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
                        <li><a href="orders.php" class="nav-link px-2 link-dark">Заказы</a></li>
                        <li><a href="executers.php" class="nav-link px-2 link-dark">Исполнители</a></li>
                        <li><a href="clients.php" class="nav-link px-2 link-secondary">Клиенты</a></li>
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
                    <div class="col-4 offset-8">
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
                        <th class="py-2 bg-light text-dark">Номер клиента</th>
                        <th class="py-2 bg-light text-dark">ФИО</th>
                        <th class="py-2 bg-light text-dark">Телефон</th>
                    </tr>
                    <tr class="text-center">
                        <td class="align-middle">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#clientModal">1</a>
                        </td>
                        <td class="align-middle">Чащин Николай</td>
                        <td class="align-middle">+7 (999) 123 45 56</td>
                    </tr>
                </table>
            </div>
        </main>

        <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clientModalLabel">Информация о клиенте</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="executerFullName" class="form-label">ФИО клиента</label>
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
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="executorDesc" class="form-label">Дополнительно</label>
                                <textarea
                                    class="form-control"
                                    placeholder="Любит брокколи"
                                    id="executorWorkDesc"
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
