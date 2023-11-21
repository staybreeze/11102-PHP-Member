<?php
date_default_timezone_set('Asia/Taipei');
$dsn = "mysql:host=localhost;charset=utf8;dbname=member";
$pdo = new PDO($dsn, 'root', '');
session_start();

?>
<?php

function total($table, $id)
{
    global $pdo;
    // (`id`)指定只count主鍵
    $sql = "select count(`id`) from `$table` ";

    if (is_array($id)) {
        // foreach的=>代表的是關聯
        foreach ($id as $col => $value) {
            // 而這邊用=，是因為=代表賦值
            // 我們在此要創造一個新陣列，因此是賦值而非關聯
            // 關聯代表已經有存在的事實
            // 而賦值代表此事實尚未發生，我們正在創造事實中
            // 暫時存儲迴圈中生成的條件片段
            $tmp[] = "`$col`='$value'";
        }
        // 當取值的陣列有許多KEY跟VALUE時，用JOIN或IMPLODE將其連接(變字串)
        $sql .= " where " . join(" && ", $tmp);
    } else if (is_numeric($id)) {
        $sql .= " where `id`='$id'";
    } else {
        echo "錯誤:參數的資料型態比須是數字或陣列";
    }
    // fetchColumn返回的是一個單一的值，通常是整數。
    $row = $pdo->query($sql)->fetchColumn();

    return $row;
}

// -----all-----

// SELECT `col1`,`col2`,... FROM `table1`,`table2`,...　WHERE ...
// 預設值沒有寫 = ''，那在輸入時就一定要填東西，如果預設為空值( = '')，在輸入時若沒有要填的內容，即可不用填

function all($table = null, $where = '', $other = '')
{
    // 如果重複的資料很多，就用include
    // include "./include/connect.php";

    $sql = "select * from `$table` ";
    // 資料不多可以設成自訂函式
    // $pdo=pdo('school');

    // 也可以在全域設定並呼叫
    global $pdo;
    if (isset($table) && !empty($table)) {

        if (is_array($where)) {
            /**
             * ['dept'=>'2','graduate_at'=>12] =>  where `dept`='2' && `graduate_at`='12'
             * $sql="select * from `$table` where `dept`='2' && `graduate_at`='12'"
             */
            if (!empty($where)) {
                foreach ($where as $col => $value) {
                    $tmp[] = "`$col`='$value'";
                }
                $sql .= " where " . join(" && ", $tmp);
            }
        } else {
            $sql .= " $where";
        }

        $sql .= $other;
        // echo 'all=>' . $sql;
        $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } else {
        echo "錯誤:沒有指定的資料表名稱";
    }
}

// -----find-----

function find($table, $id)
{
    global $pdo;
    $sql = "select * from `$table` ";

    if (is_array($id)) {
        foreach ($id as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
        $sql .= " where " . join(" && ", $tmp);
    } else if (is_numeric($id)) {
        $sql .= " where `id`='$id'";
    } else {
        echo "錯誤:參數的資料型態比須是數字或陣列";
    }

    $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    return $row;
}

// -----update-----

// UPDATE `table` SET `col1`='value1',`col2`='value2',...　WHERE ...

function update($table, $cols, $id)
{
    global $pdo;

    $sql = "update `$table` set ";
    // 因為要填入兩個變數，因此要分別判斷兩個變數
    // 判斷$cols
    if (!empty($cols)) {
        foreach ($cols as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
    } else {
        echo "錯誤:缺少要編輯的欄位陣列";
    }

    $sql .= join(",", $tmp);

    // 判斷$id

    // 當$id只要查id的時候
    // if (is_array($id)) {
    //     foreach ($id as $col => $value) {
    //         $tmp[] = "`$col`='$value'";
    //     }
    // } elseif (is_numeric($id)) {
    //     $sql .= " where `id`='$id'";
    // } else {
    //     echo "錯誤:參數的資料型態應為數字或陣列";
    // }


    // $id可以不只查id，也可以查其他的where
    if (is_array($id)) {
        foreach ($id as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
        $sql .= " where " . join(" && ", $tmp);
    } else if (is_numeric($id)) {
        $sql .= " where `id`='$id'";
    } else {
        echo "錯誤:參數的資料型態比須是數字或陣列";
    }
    echo $sql;
    return $pdo->exec($sql);
}

// -----delete-----

// DELETE FROM `table` WHERE ...

function del($table, $id)
{
    global $pdo;
    $sql = "delete from `$table` ";

    if (is_array($id)) {
        foreach ($id as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
        $sql .= " where " . join(" && ", $tmp);
    } else if (is_numeric($id)) {
        $sql .= " where `id`='$id'";
    } else {
        echo "錯誤:參數的資料型態比須是數字或陣列";
    }

    // echo 'del=>' . $sql;
    $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    return $row;
}

// -----insert-----


// INSERT INTO `table`(`col1`,`col2`,`col3`,`col4`,`col5`) 
//             VALUES('value1','value1','value1','value1','value1','value1');



function insert($table, $values)
{


    global $pdo;

    $sql = "insert into `$table` ";

    // $cols="(``,``,``,``,)";
    // $vals="('','','','',)";

    $cols = "(`" . join("`,`", array_keys($values)) . "`)";
    $vals = "('" . join("','", $values) . "')";

    $sql = $sql . $cols  . " values " . $vals;
    // $sql=insert into `$table` . (``,``,``,``,) ." values ".('','','','',);

    echo $sql;
    return $pdo->exec($sql);
}

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

?>