<?php if(!isset($_SESSION)) session_start(); ?>
<?php
if (isset($_SESSION) && $_SESSION['user'] == '')
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
        <title>Исполнители</title>

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
                        <li><a href="executers.php" class="nav-link px-2 link-secondary">Исполнители</a></li>
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
                    <button type="button" class="btn btn-success js-openModal" data-bs-toggle="modal" data-bs-target="#executerModal" data-change-modal="false">
                        <i class="bi bi-plus"></i>
                        Добавить
                    </button>
                    <!-- <div class="col-4">
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
                    </div> -->
                </div>
                <table class="w-100 table table-bordered">
                    <tr class="text-center">
                        <th class="py-2 bg-light text-dark">Номер исполнителя</th>
                        <th class="py-2 bg-light text-dark">ФИО</th>
                        <th class="py-2 bg-light text-dark">Телефон</th>
                        <th class="py-2 bg-light text-dark">Работает</th>
                        <th class="py-2 bg-light text-dark">Дата приёма</th>
                    </tr>
                    <?php
                        $executers = new Executer();
                        $result = $executers->get()['msg'];
                    ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="align-middle">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#executerModal" data-executer-id="<?=$row['id']?>" class="js-openExecuterModal"><?=$row['id']?></a>
                        </td>
                        <td class="align-middle"><?=$row['fullName']?></td>
                        <td class="align-middle"><?=$row['phone']?></td>
                        <td class="align-middle">
                            <?php if ($row['workType'] == 0): ?>
                                <div class="rounded bg-success text-white text-center">На постоянной основе</div>
                            <?php endif; ?>
                            <?php if ($row['workType'] == 1): ?>
                                <div class="rounded bg-primary text-white text-center">По совместительству</div>
                            <?php endif; ?>
                            <?php if ($row['workType'] == 2): ?>
                                <div class="rounded bg-danger text-white text-center">Уволен</div>
                            <?php endif; ?>
                        </td>
                        <td><?=date('d.m.Y', intval($row['date']))?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </main>

        <div
            class="modal fade"
            id="executerModal"
            tabindex="-1"
            aria-labelledby="executerModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="executerModalLabel">Информация об исполнителе</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="executerFullName" class="form-label">ФИО</label>
                                <input
                                    class="form-control"
                                    id="executerFullName"
                                    name="executerFullName"
                                    placeholder="Иванов Иван Иванович"
                                />
                            </div>
                            <div class="col-4">
                                <label for="executerPhone" class="form-label">Номер телефона</label>
                                <input
                                    class="form-control js-phone"
                                    id="executerPhone"
                                    name="executerPhone"
                                    placeholder="+7 (999) 876 54 32"
                                />
                            </div>
                            <div class="col-4">
                                <label for="workType" class="form-label">Работает</label>
                                <select class="form-select" id="workType" name="workType">
                                    <option value="0" class="text-success" selected>На постоянной основе</option>
                                    <option value="1" class="text-primary">По совместительству</option>
                                    <option value="2" class="text-danger">Уволен</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="executerDesc" class="form-label">Дополнительно</label>
                                <textarea class="form-control" placeholder="Любит брокколи" id="executerDesc" name="executerDesc"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="js-executerBtn" data-action="add">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
