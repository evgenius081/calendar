<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заметка</title>
</head>
<body style="display: flex;justify-content: center;align-items: center; height: 96vh; flex-direction: column; font-family: 'Segoe UI'; background-color: #3f51b5; color: #fff">
<div style="margin-bottom: 70px; border: 1px solid #fff; background-color: #1a237e; width: 100px; font-size: 30px; text-align: center; height: 45px; border-radius: 20px">
<?
 if(isset($_SESSION['uid'])){
     echo '<a href="/logout/" style="color: #fff; text-decoration: none; width: 100px; height: 50px; text-align: center; cursor: pointer">Logout</a>';
 }else{
     echo '<a href="/login/" style="color: #fff; text-decoration: none; line-height: 30px">Login</a>';
 }


?>
</div>
<div>
    <div style="overflow: auto; height: 18vh; width: 80%; margin: 0 auto">
    <ol style="font-family: 'Segoe UI'; margin: 0">
    <?php
        foreach($this->var['note'] as $value){
        echo '<li data-id="'.$value['id'].'">'. $value['description'];
        if(isset($_SESSION['uid'])){
            echo '<span class="delete" id="'.$value['id'].'" style="float: right; cursor:pointer;">х</span>';
        }
        echo '<p>Создано: '.$value['created_at'].'</p><p>Автор: '.$value['creator'].'</p></li>';

    }
    ?>
    </ol>
    </div>
    <?
    if(isset($_SESSION['uid'])){
        echo "<form method=\"post\"style=\"display: flex; flex-direction: column; align-items: center; font-family: 'Segoe UI'\">
        <p style=\"text-align: center; font-size: 36px; margin-bottom: 0\">Заметка</p>
        <textarea  name=\"descript\" style=\"width: 400px; height: 200px; margin-bottom: 20px\"></textarea>
        <input type=\"submit\" value=\"OK\" id=\"submit\" style=\"width: 50px; height: 30px; font-size: 18px; font-family: 'Segoe UI'\">
    </form>";
    }else{
        echo '<h2>Авторизируйтесь чтобы добавлять или удалаять заметки</h2>';
    }


    ?>
</div>
<script>
    let noteDel = document.getElementsByClassName('delete');
    for(var i=0; i<noteDel.length; i++){
        noteDel[i].addEventListener('click', function(e){
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/calendar/'+this.id+'/delete/');
            xhr.send();
            xhr.onreadystatechange = function(){
                if(xhr.readyState === 4 && xhr.status === 200){
                    e.toElement.parentElement.remove();
                }
            }
        });
    }

    let submit = document.getElementById('submit');
    submit.addEventListener('click', function (e){
        let xhr = new XMLHttpRequest();
        xhr.fetch('/controller/Calendar.php');
    })

    // let logout = document.getElementById('logout');
    // logout.addEventListener('click', fucntion(e){
    //     console.log('asdasdawdawd');
    //     // let xhr = new XMLHttpRequest();
    //     // xhr.fetch('/logout/');
    // })
</script>
</body>
</html>
