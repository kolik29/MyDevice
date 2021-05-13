<?php if(!isset($_SESSION)) session_start();

class DB {
    public function connectDB() {
        include 'config.php';
        
        $conn = new mysqli($config['server'], $config['user'], $config['password'], $config['database']);
        if (mysqli_connect_errno())
            die("Connection failed: " . mysqli_connect_error());

        return $conn;
    }

    public function authentication($login, $password) {
        $conn = $this->connectDB();

        if ($result = $this->select('users', ['login'], ['login' => $login, 'password' => md5($password)])) {
            if ($result->num_rows == 1) {//если пользователь найден
                $_SESSION['user'] = md5($login.$password.time());

                $this->update('users', ['session' => $_SESSION['user']], ['login' => $login, 'password' => md5($password)]);

                return [
                    'result' => 'success',
                    'msg' => ''
                ];
            } elseif ($result->num_rows == 0) //есль пользователь не найден
                return [
                    'result' => 'fail',
                    'msg' => 'Неправильный логи или пароль'
                ];
            else //если найдено несколько пользователей
                return [
                    'result' => 'fail',
                    'msg' => 'Ошибка аутентификации'
                ];
            }
        else //если ошибка при запросе
            return [
                'result' => 'fail',
                'msg' => 'Ошибка аутентификации'
            ];

        $conn->close();
    }

    public function deauthentication() {
        if ($this->update('users', ['session' => ''], ['session' => $_SESSION['user']])) { //выход из системы
            unset($_SESSION['user']);
            
            return [
                'result' => 'success',
                'msg' => ''
            ];
        } else //если ошибка при запросе
            return [
                'result' => 'fail',
                'msg' => 'Ошибка деаутентификации'
            ];
    }

    public function select($table, $fields = ['*'], $where = '') {
        $conn = $this->connectDB();

        $sql = 'SELECT '.implode(', ', $fields).' FROM '.$table;

        if ($where != '') {
            $sql .= ' WHERE ';
            
            if (is_string($where))
                $sql .= $where;

            if (is_array($where)) {
                $where_str = [];
                
                foreach ($where as $field=>$value)
                    if (is_string($value))
                        array_push($where_str, $field.'="'.$value.'"');

                    if (is_integer($value))
                        array_push($where_str, $field.'='.$value);
                        

                $sql .= implode(' AND ', $where_str);
            }
        }

        if ($result = $conn->query($sql))
            return $result;
        else
            throw new ErrorException('Ошибка запроса SELECT');

        $conn->close();
    }

    public function insert($table, $data) {
        $conn = $this->connectDB();

        $fields = array_keys($data);

        foreach ($fields as $field)
            if (is_string($data[$field]))
                $data[$field] = '"'.$data[$field].'"';

        $sql = 'INSERT INTO '.$table.' ('.implode(', ', $fields).') VALUES ('.implode(', ', $data).')';

        if ($conn->query($sql))
            return $conn->insert_id;
        else
            throw new ErrorException('Ошибка запроса INSERT: '.$sql);

        $conn->close();
    }

    public function update($table, $set, $where) {
        $conn = $this->connectDB();

        $sql = 'UPDATE '.$table.' SET ';

        $set_arr = [];

        foreach($set as $field => $value) {
            $val = is_string($value) ? '"'.$value.'"' : $value;
            array_push($set_arr, $field.'='.$val);
        }

        $sql .= implode(', ', $set_arr);

        $sql .= ' WHERE ';
        
        if (is_string($where))
            $sql .= $where;

        if (is_array($where)) {
            $where_str = [];
            
            foreach ($where as $field=>$value)
                if (is_string($value))
                    array_push($where_str, $field.'="'.$value.'"');

                if (is_integer($value))
                    array_push($where_str, $field.'='.$value);

            $sql .= implode(' AND ', $where_str);
        }

        if ($result = $conn->query($sql))
            return $result;
        else
            throw new ErrorException('Ошибка запроса SELECT');

        $conn->close();
    }

    public function getCurrentUserID() {
        if ($result = $this->select('users', ['id'], ['session' => $_SESSION['user']])) {
            if ($result->num_rows == 1) {//если пользователь найден
                return [
                    'result' => 'success',
                    'msg' => $result->fetch_assoc()['id']
                ];
            } elseif ($result->num_rows == 0) //есль пользователь не найден
                return [
                    'result' => 'fail',
                    'msg' => 'Неправильный логи или пароль'
                ];
            else //если найдено несколько пользователей
                return [
                    'result' => 'fail',
                    'msg' => 'Ошибка аутентификации'
                ];
            }
        else //если ошибка при запросе
            return [
                'result' => 'fail',
                'msg' => 'Ошибка аутентификации'
            ];
    }
}

class Order extends DB {
    public function add($clientID, $device, $defect, $preliminaryPrice, $executer, $status = 'new') {
        if ($this->insert('orders', [
            'client' => $clientID,
            'executer' => $executer,
            'deviceID' => $device['ID'],
            'deviceDesc' => $device['desc'],
            'deviceDefect' => $defect,
            'preliminaryPrice' => $preliminaryPrice,
            'status' => $status,
            'dateCreate' => time(),
            'createBy' => $this->getCurrentUserID()['msg']
        ]))
            return [
                'result' => 'success',
                'msg' => ''
            ];
        else //если ошибка при запросе
            return [
                'result' => 'fail',
                'msg' => 'Ошибка при создании нового заказа'
            ];
    }

    public function get($orderID = '', $where = []) {
        if ($orderID == '' && count($where) == 0)
            $result = $this->select('orders');
        
        if ($orderID != '' && count($where) == 0)
            $result = $this->select('orders', ['*'], ['id' => $orderID]);

        if ($orderID == '' && count($where) > 0)
            $result = $this->select('orders', ['*'], $where);

        if ($result)
            return [
                'result' => 'success',
                'msg' => $result
            ];                

        return [
            'result' => 'fail',
            'msg' => 'Ошибка при поулчении заказа'
        ];
    }
}

class Client extends DB {
    public function add($fullName, $phone, $description = '') {
        if ($insert_id = $this->insert('clients', [
            'fullName' => $fullName,
            'phone' => $phone,
            'description' => $description
        ]))
            return [
                'result' => 'success',
                'msg' => $insert_id
            ];
        else //если ошибка при запросе
            return [
                'result' => 'fail',
                'msg' => 'Ошибка при создании нового клиента'
            ];
    }

    public function get($id = '', $fields = ['*']) {
        if ($id == '')
            $result = $this->select('clients', $fields);
        else
            $result = $this->select('clients', $fields, ['id' => $id]);

        if ($result)
            return [
                'result' => 'success',
                'msg' => $result
            ];             

        return [
            'result' => 'fail',
            'msg' => 'Ошибка при поулчении заказа'
        ];
    }

    public function save($id, $fields) {
        if ($result = $this->update('clients', $fields, ['id' => $id]))
            return [
                'result' => 'success',
                'msg' => $result
            ];

        return [
            'result' => 'fail',
            'msg' => 'Ошибка при записи клиента'
        ];
    }
}

class Device extends DB {    
    public function add($name, $number, $clientID) {
        if ($insert_id = $this->insert('devices', [
            'name' => $name,
            'number' => $number,
            'clientID' => $clientID
        ]))
            return [
                'result' => 'success',
                'msg' => $insert_id
            ];
        else //если ошибка при запросе
            return [
                'result' => 'fail',
                'msg' => 'Ошибка при добавлении устройства'
            ];
    }

    public function get($id = '', $fields = ['*'], $where = []) {
        if (count($where) == 0)
            $result = $this->select('devices', $fields, ['id' => $id]);
        else
            $result = $this->select('devices', $fields, $where);

        if ($result)
            return [
                'result' => 'success',
                'msg' => $result
            ];             

        return [
            'result' => 'fail',
            'msg' => 'Ошибка при поулчении заказа'
        ];
    }
}

class User extends DB {
    public function get($id, $fields = ['*']) {
        if ($result = $this->select('users', $fields, ['id' => $id]))
            return [
                'result' => 'success',
                'msg' => $result
            ];             

        return [
            'result' => 'fail',
            'msg' => 'Ошибка при поулчении заказа'
        ];
    }
}

class Executer extends DB {
    public function add($fullName, $phone, $workType, $executerDesc) {
        if ($insert_id = $this->insert('executers', [
            'fullName' => $fullName,
            'phone' => $phone,
            'workType' => $workType,
            'executerDesc' => $executerDesc,
            'date' => time()
        ]))
            return [
                'result' => 'success',
                'msg' => $insert_id
            ];
        else //если ошибка при запросе
            return [
                'result' => 'fail',
                'msg' => 'Ошибка при добавлении исполнителя'
            ];
    }

    public function get($id = '', $fields = ['*']) {
        if ($id == '')
            $result = $this->select('executers', $fields);
        else
            $result = $this->select('executers', $fields, ['id' => $id]);

        if ($result)
            return [
                'result' => 'success',
                'msg' => $result
            ];             

        return [
            'result' => 'fail',
            'msg' => 'Ошибка при поулчении исполнителя/исполнителей'
        ];
    }

    public function save($id, $fields) {
        if ($result = $this->update('executers', $fields, ['id' => $id]))
            return [
                'result' => 'success',
                'msg' => $result
            ];

        return [
            'result' => 'fail',
            'msg' => 'Ошибка при записи исполнителя'
        ];
    }
}

$db = new DB();

function orderAdd() {
    $order = new Order();
    $client = new Client();
    $device = new Device();

    $clientID = $client->add($_GET['clientFullName'], $_GET['clientPhone'])['msg'];
    $deviceID = $device->add($_GET['clientDevice'], $_GET['clientDeviceSN'], $clientID)['msg'];
    
    return $order->add(
        $clientID,
        [
            'ID' => $deviceID,
            'desc' => $_GET['clientDeviceDesc']
        ],
        $_GET['clientDeviceDefectDesc'],
        $_GET['preliminaryPrice'],
        $_GET['executer'],
        $_GET['status']
    );
}

function orderGet() {
    $order = new Order();

    $result = $order->get(intval($_GET['id']));
    
    return $result['msg']->fetch_assoc();
}

function orderSave() {
    $order = new Order();

    $result = $order->get(intval($_GET['id']));
    
    return $result['msg']->fetch_assoc();
}

function executerAdd() {
    $executer = new Executer();

    return $executer->add(
        $_GET['executerFullName'],
        $_GET['executerPhone'],
        $_GET['workType'],
        $_GET['executerDesc']
    );
}

function executerGet() {
    $order = new Executer();

    $result = $order->get(intval($_GET['id']));
    
    return $result['msg']->fetch_assoc();
}

function executerSave() {
    $executer = new Executer();

    $result = $executer->save(intval($_GET['id']), [
        'fullName' => $_GET['executerFullName'],
        'phone' => $_GET['executerPhone'],
        'workType' => $_GET['workType'],
        'executerDesc' => $_GET['executerDesc'],
    ]);

    return $result['msg'];
}

function clientGet() {
    $client = new Client();

    $result = $client->get(intval($_GET['id']));
    
    return $result['msg']->fetch_assoc();
}

function clientSave() {
    $client = new Client();

    $result = $client->save(intval($_GET['id']), [
        'fullName' => $_GET['clientFullName'],
        'phone' => $_GET['clientPhone'],
        'description' => $_GET['clientDesc']
    ]);
    
    return $result['msg'];
}

function deviceGet() {
    $device = new Device();

    $query = $device->get('', ['*'], [
        'clientID' => $_GET['clientID']
    ]);

    $result = [];

    while ($row = $query['msg']->fetch_assoc())
        $result[] = $row;
    
    return $result;
}

function deviceGetByID() {
    $device = new Device();

    $query = $device->get($_GET['deviceID']);

    return $query['msg']->fetch_assoc();
}

function getByClient() {
    $order = new Order();

    $query = $order->get('', [
        'client' => $_GET['clientID']
    ]);

    $result = [];

    while ($row = $query['msg']->fetch_assoc())
        $result[] = $row;
    
    return $result;
}

if (array_key_exists('function', $_GET)) {
    if ($_GET['function'] == 'authentication')
        echo json_encode($db->authentication($_GET['login'], $_GET['password']));

    if ($_GET['function'] == 'deauthentication')
        echo json_encode($db->deauthentication());

    if ($_GET['function'] == 'order.add')
        echo json_encode(orderAdd());

    if ($_GET['function'] == 'order.get')
        echo json_encode(orderGet());

    if ($_GET['function'] == 'order.save')
        echo json_encode(orderSave());

    if ($_GET['function'] == 'executer.add')
        echo json_encode(executerAdd());

    if ($_GET['function'] == 'executer.get')
        echo json_encode(executerGet());

    if ($_GET['function'] == 'executer.save')
        echo json_encode(executerSave());

    if ($_GET['function'] == 'client.get')
        echo json_encode(clientGet());

    if ($_GET['function'] == 'client.save')
        echo json_encode(clientSave());

    if ($_GET['function'] == 'device.get')
        echo json_encode(deviceGet());

    if ($_GET['function'] == 'device.getByID')
        echo json_encode(deviceGetByID());

    if ($_GET['function'] == 'orders.getByClient')
        echo json_encode(getByClient());
}