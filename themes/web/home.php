<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almoxarifado</title>
    <link rel="shortcut icon" href="<?= url("imagens/stock.ico"); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= url('/assets/web/styleHome.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="Counter-Up-master\jquery.counterup.min.js"></script>
    <script src="Counter-Up-master\jquery.counterup.js"></script>

</head>

<body>

    <script>
        if (sessionStorage.getItem("userLogin") == null) {
            alert("Você não está logado! aperte OK para ser redirecionado para a página de login!");
            window.location.href = "<?= url("/api-login"); ?>";
        }
    </script>

    <!--Header-->
    <header id="header">
        <a href="" class="logo"><img id="logoImg" style="width: 100px;" src="<?= url("imagens/tmwLogo.png"); ?>" alt=""></a>
        <ul>
            <li><a href="<?= url('/'); ?>">Home</a></li>
            <li><a href="<?= url('/estoque'); ?>">Estoque</a></li>
            <li><a href="<?= url('/usuarios');?>">Usuários</a></li>
            <li><a href="<?= url('/logs'); ?>">Logs</a></li>
            <li><a href="<?= url('/api-login'); ?>">Login</a></li>
            <li><a id="logout" href="">Logout</a></li>   
        </ul>
        <div class="toggle" onclick="toggle()"></div>
    </header>
    <!--Banner-->
    <section class="banner" id="home">
        <h2>Bem vindo!<br></h2>
    </section>

    <script type="text/javascript">


        const logout = document.querySelector("#logout");
        logout.addEventListener("click", (event) => {
            event.preventDefault();
            sessionStorage.removeItem("userLogin");
            alert("Você foi deslogado!")
            window.location.href = "<?= url("/api-login"); ?>";
        });
        //static scroll
        window.addEventListener("scroll", function() {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0);
        })
        //hamburger
        function toggle() {
            var header = document.querySelector("header");
            header.classList.toggle("active");
        }
        //counter
        $(document).ready(function() {
            $('.counter').counterUp({
                delay: 10,
                time: 750
            });
        });
        // Verificar se a página foi recarregada
        window.addEventListener('load', function() {
            // Adicionar um marcador ao localStorage
            localStorage.setItem('paginaCarregada', 'true');
        });

        // Verificar quando a página está sendo descarregada (fechada)
        window.addEventListener('unload', function() {
            // Verificar se a página foi carregada antes de limpar o localStorage
            if (localStorage.getItem('paginaCarregada') === 'true') {
                // Limpar o localStorage
                localStorage.clear();
            }
        });
    </script>
</body>

</html>