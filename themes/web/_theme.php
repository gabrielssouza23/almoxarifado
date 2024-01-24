<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="<?= url('/assets/web/styleHome.css');?>">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="Counter-Up-master\jquery.counterup.min.js"></script>
    <script src="Counter-Up-master\jquery.counterup.js"></script>

</head>
<body>
    <!--Header-->
    <header id="header">
            <a href="#" class="logo">Logo</a>
            <ul>
                <li><a href="<?=url('/'); ?>">Home</a></li>
                <li><a href="<?=url('/admin/carros'); ?>">Carros</a></li>
                <li><a href="<?=url('/admin/usuarios'); ?>">Usuários</a></li>
                <li><a href="#">Marcas</a></li>
            </ul>
            <div class="toggle" onclick="toggle()"></div>
    </header>
    <!--Banner-->
    <section class="banner" id="home">
        <h2>Bem vindo!<br></h2>
    </section>

    <script type="text/javascript">
    //static scroll
    window.addEventListener("scroll", function(){
        var header = document.querySelector("header");
        header.classList.toggle("sticky", window.scrollY > 0);
    })
    //hamburger
    function toggle(){
        var header = document.querySelector("header");
        header.classList.toggle("active");
    }
    //counter
    $(document).ready(function(){
    $('.counter').counterUp({
      delay: 10,
      time: 750
    });
    });
    </script>
</body>
</html>