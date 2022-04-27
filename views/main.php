<?php

require_once ("./math_model/ad_model.php");
?>

<div class="container">
        <span>Введіть всі потрібні параметри</span>
    <form  method="POST">
      <div class="form">
        <div class="form__collum">
            <div class="form_text">Максимальна кількість покупців</div>
            <input class="text form__input" type="text" name="num" placeholder= "num" size="5" required>
            
            <div class="form_text">Інтенсивність реклами</div>
            <input class="text form__input" type="text" name="alpha1" placeholder= "alpha1" size="5" required>
           
            <div class="form_text">Ступінь спілкування клієнтів</div>
            <input class="text form__input" type="text" name="alpha2" placeholder= "alpha2" size="5" required>
            
            <div class="form_text">Величина прибутку від продажу одиниці товару</div>
            <input class="text form__input" type="text" name="p" placeholder= "p" size="5" required>
        </div>

        <div class="form__collum">
            <div class="form_text">Вартість (ціна) елементарного акту реклами</div>
            <input class="text form__input" type="text" name="s" placeholder= "s" size="5" required>
            
            <div class="form_text">Коефіцієнт пропорційності</div>
            <input class="text form__input" type="text" name="k" placeholder= "k" size="5" required>
            
            <div class="form_text">Оптимальність реклами</div>
            <input class="text form__input" type="text" name="alpha_opt" placeholder= "alpha_opt" size="5" required>
            
            <div class="form_text">Модифікований ступінь спілкування клієнтів </div>
            <input class="text form__input" type="text" name="alpha22" placeholder= "alpha22" size="5" required>
        </div>
       </div>   
        <button class="form__btn" type="submit">
                           <div> Calculate </div>
        </button>

<?php
//ВАЛІДАЦІЯ ЗНАЧЕНЬ
if(!empty($_POST)) {
    //ПЕРЕВЕДЕННЯ ЗНАЧЕНЬ У ПОТРІБНИЙ ВИД - МАШТАБУВАННЯ
    $N0 = $_POST["num"];
    $alpha1 = $_POST["alpha1"];
    $alpha2 = $_POST["alpha2"];

    $p = $_POST["p"];
    $s = $_POST["s"];
    $k = $_POST["k"];
    $alpha_opt = $_POST["alpha_opt"];
    $alpha22 = $_POST["alpha22"];

    //ЗАКИДУЄМО У БД
    //ПЕРЕВІРКА УМОВИ ДОЦІЛЬНОСТІ РЕКЛАМИ

    //ВИКЛИК ФУНКЦІЙ ОБРАХУНКУ
    //ФУНКЦІЇ ПОВЕРНУТЬ МАСИВИ

    //main1($alpha1, $alpha2, $k, $N0);
    //main2($alpha2, $alpha1, $alpha_opt, $alpha22, $k, $N0);

    //ВИВЕСТИ ГРАФІК
 }
    ?>
    </form>