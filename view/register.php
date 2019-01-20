<form data-ajax="false" method="post" action="action/register.php"
      onsubmit='if($("#p1").val() !== $("#p2").val()){ alert("hasła różnią się"); return false;}'>
    <input type="text" name="login"  placeholder="login">
    <input type="password" id='p1' name="password1" placeholder="hasło">
    <input type="password" id=p2 name="password2" placeholder="powtórz hasło">
    <input type="submit" value="Zarejestruj">
</form>