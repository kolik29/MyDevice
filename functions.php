<?php session_start();

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
            throw new ErrorException('Ошибка запроса SELECT');

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
            'createBy' => $this->getCurrentUserID()['msg']['id']
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

    public function get($orderID = '') {
        if ($orderID == '')
            $result = $this->select('orders');
        else
            $result = $this->select('orders', ['*'], ['id' => $orderID]);

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

    public function get($id, $fields = ['*']) {
        if ($result = $this->select('clients', $fields, ['id' => $id]))
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

    public function get($id, $fields = ['*']) {
        if ($result = $this->select('devices', $fields, ['id' => $id]))
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

$db = new DB();

if ($_GET['function'] == 'authentication')
    echo json_encode($db->authentication($_GET['login'], $_GET['password']));

if ($_GET['function'] == 'deauthentication')
    echo json_encode($db->deauthentication());

if ($_GET['function'] == 'order.add')
    echo json_encode(orderAdd());

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
        1,
        $_GET['status']
    );
}

if ($_GET['function'] == 'order.get')
    echo json_encode(orderGet());

function orderGet() {
    $order = new Order();

    $result = $order->get(intval($_GET['id']));
    
    return $result['msg']->fetch_assoc();
}