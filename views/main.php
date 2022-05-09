<?php

require_once ("./math_model/ad_model.php");

$errNum = $errAlpha1= $errAlpha2= $errP = '';
$errS = $errK= $errAlpha_opt= $errAlpha22 =  '';
$servername = "localhost";
$database = "advertising_campaign";
$username = "root";
$password = "";

$conn3 = mysqli_connect($servername,$username,$password,$database);
mysqli_set_charset($conn3, 'utf8');
if (!$conn3) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


<div class="container">
    <div class="main__title">Введіть всі потрібні параметри</div>
    <form class="container" method="POST">
        <div class="form">
            <div class="form__collum">
                <div class="form_text">Максимальна кількість покупців</div>
                <input class="text form__input" type="text" name="num" placeholder= "num" size="5"  required>
                <?php echo $errNum; ?>
                <div class="form_text">Інтенсивність реклами</div>
                <input class="text form__input" type="text" name="alpha1" placeholder= "alpha1" size="5" required>
                <?php echo $errAlpha1; ?>
                <div class="form_text">Ступінь спілкування клієнтів</div>
                <input class="text form__input" type="text" name="alpha2" placeholder= "alpha2" size="5" required>
                <?php echo $errAlpha2; ?>
                <div class="form_text">Величина прибутку від продажу одиниці товару</div>
                <input class="text form__input" type="text" name="p" placeholder= "p" size="5" required>
                <?php echo $errP; ?>

                 <div class="form_text">Дні</div>
                <input class="text form__input" type="text" name="t_days" placeholder= "t_days" size="5" required>
                 <div class="form_text">Місто</div>
                <input class="text form__input" type="text" name="region_title" placeholder= "region_title" size="5" required>
            </div>

            <div class="form__collum">
                <div class="form_text">Вартість (ціна) елементарного акту реклами</div>
                <input class="text form__input" type="text" name="s" placeholder= "s" size="5" required>
                <?php echo $errS; ?>
                <div class="form_text">Коефіцієнт пропорційності</div>
                <input class="text form__input" type="text" name="k" placeholder= "k" size="5" required>
                <?php echo $errK; ?>
                <div class="form_text">Оптимальність реклами</div>
                <input class="text form__input" type="text" name="alpha_opt" placeholder= "alpha_opt" size="5" required>
                <?php echo $errAlpha_opt; ?>
                <div class="form_text">Модифікований ступінь спілкування клієнтів </div>
                <input class="text form__input" type="text" name="alpha22" placeholder= "alpha22" size="5" required>
                <?php echo $errAlpha22; ?>

                 <div class="form_text">prod_title</div>
                <input class="text form__input" type="text" name="prod_title" placeholder= "prod_title" size="5" required>
                 <div class="form_text">amm</div>
                <input class="text form__input" type="text" name="amm" placeholder= "amm" size="5" required>

            </div>
        </div>
        <button class="form__btn" type="submit" onclick="showDiv()">
            Почати
        </button>
                <input type="button" class="form__btn" onclick="showDiv()">
            Пои
        </input>

        <?php
        //ВАЛІДАЦІЯ ЗНАЧЕНЬ
        $pattern_int = '/^\d+$/';
        $pattern_float = '/^[\d]*[\.,]?[\d]*$|/';

        $flag = 0;
        if (!empty($_POST)) {
            if (isset($_POST["num"]) && !preg_match($pattern_int, $_POST["num"])) {
                $errNum = "Неправильно введено число! Введіть ціле число!";
                $flag = 1;
            }
            if (isset($_POST["alpha1"]) && !preg_match($pattern_int, $_POST["alpha1"])) {
                $errAlpha1 = "Неправильно введено число! Введіть ціле число!";
                $flag = 1;
            }
            if (isset($_POST["alpha2"]) && !preg_match($pattern_int, $_POST["alpha2"])) {
                $errAlpha2 = "Неправильно введено число! Введіть ціле число!";
                $flag = 1;
            }
            if (isset($_POST["p"]) && !preg_match($pattern_float, $_POST["p"])) {
                $errP = "Неправильно введено число! ";
                $flag = 1;
            }if (isset($_POST["s"]) && !preg_match($pattern_float, $_POST["s"])) {
                $errS = "Неправильно введено число!";
                $flag = 1;
            }
            if (isset($_POST["k"]) && !preg_match($pattern_float, $_POST["k"])) {
                $errK = "Неправильно введено число!";
                $flag = 1;
            }
            if (isset($_POST["alpha_opt"]) && !preg_match($pattern_int, $_POST["alpha_opt"])) {
                $errAlpha_opt = "Неправильно введено число! Введіть ціле число!";
                $flag = 1;
            }
            if (isset($_POST["alpha22"]) && !preg_match($pattern_int, $_POST["alpha22"])) {
                $errAlpha22 = "Неправильно введено число! Введіть ціле число!";
                $flag = 1;
            }

            //ПЕРЕВЕДЕННЯ ЗНАЧЕНЬ У ПОТРІБНИЙ ВИД - МАШТАБУВАННЯ
            $N0 = $_POST["num"];
            $alpha1 = $_POST["alpha1"];
            $alpha2 = $_POST["alpha2"];
            $p = $_POST["p"];
            $s = $_POST["s"];
            $k = $_POST["k"];
            $alpha_opt = $_POST["alpha_opt"];
            $alpha22 = $_POST["alpha22"];

            //ДОДАТИ ІНПУТИ НА ЦІ ПОЛЯ----------------------------
            $T_days = 10; //$_POST["t_days"]
            $region_title = 'Chernivtsi'; //$_POST["region_title"]
            $prod_title = 'Phone'; //$_POST["prod_title"]

            $alpha1 =  $alpha1 * 0.01;
            $alpha2 =  $alpha2 * 0.01;
            $alpha_opt = $alpha_opt * 0.01;
            $alpha22 = $alpha22 * 0.01;

            //ПЕРЕВІРКА УМОВИ ДОЦІЛЬНОСТІ РЕКЛАМИ
            if(!isreason($p,$alpha2,$alpha1,$k,$N0,$s)){
                echo "No reason";//ВИВЕСТИ ПОВІДОМЛЕННЯ ПРО НЕДОЦІЛЬНІСТЬ ЦІЄЇ РЕКЛАМИ---------------------
            } else{
                echo "Is reason";
            }

            //ЗАКИДУЄМО У БД
            if(!empty($_POST) && isreason($p,$alpha2,$alpha1,$k,$N0,$s)) {
                if($flag == 0) {
                    $conn = mysqli_connect($servername,$username,$password,$database);
                if (!$conn) {
                    die("Помилка з'єднання: " . mysqli_connect_error());
                } else{
                    $sql2 = "INSERT INTO product (title, price) VALUES ('$prod_title','$p')";
                    $sql = "SELECT @@identity;";
                    $result = mysqli_query($conn, $sql2) or die("Error " . mysqli_error($conn));
                    $get_id = mysqli_query($conn, $sql) or die("Error " . mysqli_error($conn));
                    if($result && $get_id)
                    {
                        while ($row = mysqli_fetch_row($get_id)) {
                            $prod_id = $row[0];
                        }
                        mysqli_free_result($get_id);
                    }

                    $sql3 = "INSERT INTO region (region_title, N0) VALUES ('$region_title', '$N0')";
                    $sql = "SELECT @@identity;";
                    $result = mysqli_query($conn, $sql3) or die("Error " . mysqli_error($conn));
                    $get_id = mysqli_query($conn, $sql) or die("Error " . mysqli_error($conn));
                    if($result && $get_id)
                    {
                        while ($row = mysqli_fetch_row($get_id)) {
                            $region_id = $row[0];
                        }
                        mysqli_free_result($get_id);
                    }

                    $sql4 = "INSERT INTO add_ (product, region) VALUES ('$prod_id','$region_id')";
                    $sql = "SELECT @@identity;";
                    $result = mysqli_query($conn, $sql4) or die("Error " . mysqli_error($conn));
                    $get_id = mysqli_query($conn, $sql) or die("Error " . mysqli_error($conn));
                    if($result && $get_id)
                    {
                        while ($row = mysqli_fetch_row($get_id)) {
                            $ad_id = $row[0];
                        }
                        mysqli_free_result($get_id);
                    }

                    $sql1 = "INSERT INTO add_data (id_add, add_price, alpha1, alpha2, alpha_opt, alpha2_2, k, T_days) 
                              VALUES ('$ad_id','$s','$alpha1', '$alpha2', '$alpha_opt',' $alpha22','$k', '$T_days')";
                    $result = mysqli_query($conn, $sql1) or die("Error " . mysqli_error($conn));

                    list($T1, $N1) = change_point($alpha2, $alpha1, $k, $N0);
                    $sql5 = "INSERT INTO coefficients (id_add, T1, N1) VALUES ('$ad_id','$T1', '$N1');";
                    $result = mysqli_query($conn, $sql5) or die("Error " . mysqli_error($conn));

                    mysqli_close($conn);
                }
            }}

            //МАСИВИ, ЩО ПРИЙМАЮТЬ ДАНІ ДЛЯ ГРАФІКА
            $N_t_first = array();
            $T_first = array();

            $N_t_second = array();
            $T_second = array();

            //ВИКЛИК ФУНКЦІЙ ОБРАХУНКУ
            list($T_first, $N_t_first) = main1($alpha1, $alpha2, $k, $N0);
            list($T_second, $N_t_second) = main2($alpha2, $alpha1, $alpha_opt, $alpha22, $k, $N0);

            $graph = array(array());
            $graph[0][0] = "x";
            $graph[0][1] = "y1";
            $graph[0][2] = "y2";

            for($i = 1; $i <= 101; $i++){
                $j = 0;
                $graph[$i][$j] = $T_first[$i-1];
                $graph[$i][$j+1] = $N_t_first[$i-1];
                $graph[$i][$j+2] = $N_t_second[$i-1];
            }
            $myfile = fopen("graph_data.csv", "w");

            // formatting each row of data in CSV format
            // and outputting it
            foreach ($graph as $line)
            {
                fputcsv($myfile, $line);
            }

            // closing the file
            fclose($myfile);

            //ФУНКЦІЇ ПОВЕРТАЮТЬ МАСИВИ

            //ВИВЕСТИ ГРАФІК---------------------------------
            //T_first i T_second вісь Х
            //N_t_first і N_t_second вісь У
            //ДВА ГРАФІКИ НА ОДНОМУ РІЗНИМИ КОЛЬОРАМИ

            //ОБЧИСЛЕННЯ ІНШИХ ДАНИХ ПРО РЕКЛАМУ
            //ВИВЕСТИ ЦІ ДАНІ З ОПИСОМ ДО ЧИ ПІСЛЯ ГРАФІКА-----------------------
            $S_spend_first = sum_spend_first($s, $alpha1);//ЗАГАЛЬНІ ВИТРАТИ БЕЗ КОРИГУВАННЯ АЛЬФА

            $S_spend_second = sum_spend_second($s, $alpha1, $T1, $alpha_opt);//ЗАГАЛЬНІ ВИТРАТИ З КОРИГУВАННЯМ АЛЬФА

            $D_first = income_first($p, $alpha1, $alpha2, $k, $N0);//ДОХІД БЕЗ КОРИГУВАННЯ АЛЬФА

            $D_second = income_second($p, $alpha1, $alpha2, $k, $N0, $N1, $alpha_opt, $alpha22, $T1);//ДОХІД З КОРИГУВАНЯМ АЛЬФА

            list($P_first, $P_second) = profit_both($p, $alpha1, $alpha2, $k, $N0, $N1, $alpha_opt, $alpha22, $T1, $s);//ПРИБУТОК БЕЗ ТА З КОРИГУВАННЯМ АЛЬФА
        }
        ?>







    <div class="form__graph" id="form_graph">
        <div id="chartdiv"></div>
    </div>
 
    </form>

</div>