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
//ДЛЯ ВАЛІДАЦІЯ ЗНАЧЕНЬ
$pattern_int = '/^\d+$/';
$pattern_float = '/^[\d]*[\.,]?[\d]*$|/';

$flag = 0;
?>

<div class="container">
    <div class="main__title">Введіть всі потрібні параметри</div>
    <form class="container" method="POST">
        <div class="form" id="form">
            <div class="form__collum">
                <div class="form_text">Максимальна кількість покупців</div>
                <input class="text form__input" type="text" name="num" placeholder= "num" size="5"  required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["num"]) && !preg_match($pattern_int, $_POST["num"])) {
                            $errNum = "Неправильно введено число! Введіть ціле число!";
                            $flag = 1;
                            echo $errNum;
                        }
                    }
                    ?></span>
                <div class="form_text">Інтенсивність реклами</div>
                <input class="text form__input" type="text" name="alpha1" placeholder= "alpha1" size="5" required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["alpha1"]) && !preg_match($pattern_int, $_POST["alpha1"])) {
                            $errAlpha1 = "Неправильно введено число! Введіть ціле число!";
                            $flag = 1;
                            echo $errAlpha1;
                        }
                    }
                    ?></span>
                <div class="form_text">Ступінь спілкування клієнтів</div>
                <input class="text form__input" type="text" name="alpha2" placeholder= "alpha2" size="5" required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["alpha2"]) && !preg_match($pattern_int, $_POST["alpha2"])) {
                            $errAlpha2 = "Неправильно введено число! Введіть ціле число!";
                            $flag = 1;
                            echo $errAlpha2;
                        }
                    }
                    ?></span>
                <div class="form_text">Величина прибутку від продажу одиниці товару</div>
                <input class="text form__input" type="text" name="p" placeholder= "p" size="5" required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["p"]) && !preg_match($pattern_float, $_POST["p"])) {
                            $errP = "Неправильно введено число! ";
                            $flag = 1;
                            echo $errP;
                        }
                    }
                    ?></span>

                 <div class="form_text">Тривалість реклами (дні)</div>
                <input class="text form__input" type="text" name="t_days" placeholder= "t_days" size="5" required>
                 <div class="form_text">Місто</div>
                <input class="text form__input" type="text" name="region_title" placeholder= "region_title" size="5" required>
            </div>

            <div class="form__collum">
                <div class="form_text">Вартість (ціна) елементарного акту реклами</div>
                <input class="text form__input" type="text" name="s" placeholder= "s" size="5" required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["s"]) && !preg_match($pattern_float, $_POST["s"])) {
                            $errS = "Неправильно введено число!";
                            $flag = 1;
                            echo $errS;
                        }
                    }
                    ?></span>
                <div class="form_text">Коефіцієнт пропорційності</div>
                <input class="text form__input" type="text" name="k" placeholder= "k" size="5" required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["k"]) && !preg_match($pattern_float, $_POST["k"])) {
                            $errK = "Неправильно введено число!";
                            $flag = 1;
                            echo $errK;
                        }
                    }
                    ?></span>
                <div class="form_text">Оптимальність реклами</div>
                <input class="text form__input" type="text" name="alpha_opt" placeholder= "alpha_opt" size="5" required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["alpha_opt"]) && !preg_match($pattern_int, $_POST["alpha_opt"])) {
                            $errAlpha_opt = "Неправильно введено число! Введіть ціле число!";
                            $flag = 1;
                            echo $errAlpha_opt;
                        }
                    }
                    ?></span>
                <div class="form_text">Модифікований ступінь спілкування клієнтів </div>
                <input class="text form__input" type="text" name="alpha22" placeholder= "alpha22" size="5" required>
                <span class="error">
                    <?php if(!empty($_POST)) {
                        if (isset($_POST["alpha22"]) && !preg_match($pattern_int, $_POST["alpha22"])) {
                            $errAlpha22 = "Неправильно введено число! Введіть ціле число!";
                            $flag = 1;
                            echo $errAlpha22;
                        }
                    }
                    ?></span>

                 <div class="form_text">Найменування реклами</div>
                <input class="text form__input" type="text" name="prod_title" placeholder= "prod_title" size="5" required>
                

            </div>
        </div>
        <button class="form__btn" type="submit" onclick="hideDiv()">
            Почати
        </button>
    </form>

        <?php

        if (!empty($_POST) && $flag == 0) {

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
            $T_days = $_POST["t_days"];
            $region_title = $_POST["region_title"];
            $prod_title = $_POST["prod_title"];

            $alpha1 =  $alpha1 * 0.01;
            $alpha2 =  $alpha2 * 0.01;
            $alpha_opt = $alpha_opt * 0.01;
            $alpha22 = $alpha22 * 0.01;

            //ПЕРЕВІРКА УМОВИ ДОЦІЛЬНОСТІ РЕКЛАМИ
            if(!isreason($p,$alpha2,$alpha1,$k,$N0,$s)){
                echo "<button class='error__btn'>Дана реклама не буде доцільною</button>";
       
            } else{
                echo "<button class='form__btn' onclick='showResult()'>Показати результати</button>";
            }

            //ЗАКИДУЄМО У БД
            if(isreason($p,$alpha2,$alpha1,$k,$N0,$s)) {
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
            }

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
            fclose($myfile);


            //ВИВЕСТИ ГРАФІК---------------------------------
            //T_first i T_second вісь Х
            //N_t_first і N_t_second вісь У


            //ОБЧИСЛЕННЯ ІНШИХ ДАНИХ ПРО РЕКЛАМУ
            $S_spend_first = sum_spend_first($s, $alpha1);//ЗАГАЛЬНІ ВИТРАТИ БЕЗ КОРИГУВАННЯ АЛЬФА

            $S_spend_second = sum_spend_second($s, $alpha1, $T1, $alpha_opt);//ЗАГАЛЬНІ ВИТРАТИ З КОРИГУВАННЯМ АЛЬФА

            $D_first = income_first($p, $alpha1, $alpha2, $k, $N0);//ДОХІД БЕЗ КОРИГУВАННЯ АЛЬФА

            $D_second = income_second($p, $alpha1, $alpha2, $k, $N0, $N1, $alpha_opt, $alpha22, $T1);//ДОХІД З КОРИГУВАНЯМ АЛЬФА

            list($P_first, $P_second) = profit_both($p, $alpha1, $alpha2, $k, $N0, $N1, $alpha_opt, $alpha22, $T1, $s);//ПРИБУТОК БЕЗ ТА З КОРИГУВАННЯМ АЛЬФА
        }}
        ?>
        <div class="result" id="result">
            <div class="main__title">   Результати
            </div>
            <div class="result__container">
                <div class="result__collum">
                    <div class="form_text">Загальні витрати без коригування альфа</div>
                    <div><input name="type" value="<?= $S_spend_first ?>" ></div>
                    <div class="form_text">Загальні витрати з коригування альфа</div>
                    <div><input name="type" value="<?= $S_spend_second ?>" ></div>
                    <div class="form_text">Дохід без коригування альфа</div>
                    <div><input name="type" value="<?= $D_first ?>" ></div>
                </div>
                <div class="result__collum">
                    <div class="form_text">Дохід з коригування альфа</div>
                    <div><input name="type" value="<?= $D_second ?>" ></div>
                    <div class="form_text">Прибуток без корегування альфа</div>
                    <div><input name="type" value="<?= $P_first ?>" ></div>
                    <div class="form_text">Прибуток з коригуванням альфа</div>
                    <div><input name="type" value="<?= $P_second ?>" ></div>
                </div>
            </div>
            <button class="form__btn" onclick="showGraph()">
                Показати графік
            </button>

            <div class="form__graph" id="form_graph">
                <div id="chartdiv"></div>
            </div>
        </div>
</div>