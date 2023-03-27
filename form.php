<form action="" method="POST">
 <p> Форма </p>
 <p> Напишите имя, год и email. <br>
  <input name="fio" />
  <select name="year">
    <?php 
    for ($i = 1922; $i <= 2022; $i++) {
      printf('<option value="%d">%d год</option>', $i, $i);
    }
    ?>
  </select>
  <input name="email" />
  </p>
  <p>Выберите пол: <br>
  <INPUT name="gender" type="radio" value="m" selected = "selected">
М
<INPUT name="gender" type="radio" value="j">
Ж
</p>
  <p>Выберите суперсилу: <br>
  <select name="superpower[]" size="4" multiple="multiple">
  <option value="t" selected = "selected">God</option>
  <option value="b">fly</option>
  <option value="c">idclip</option>
  <option value="p">fireball</option>
</select></p> 
<p>
Сколько у вас конечностей <br>

<INPUT name="limbs" type="radio" value="0" selected = "selected">
0
<INPUT name="limbs" type="radio" value="1">
1
<INPUT name="limbs" type="radio" value="2">
2
<INPUT name="limbs" type="radio" value="3">
3
<INPUT name="limbs" type="radio" value="4">
4
</p>
<INPUT type="text" name="TextBox" size="100" maxlength="100">
<p>
C контрактом ознакомлен.
    <input type="checkbox" name="formWheelchair" value="Yes" />
</p>
<p>
  <input type="submit" value="ok" />
  
</p>
</form>
