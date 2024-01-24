<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
<meta charset="utf-8" />
<title>Animated Login Form</title>
<link rel="stylesheet" href="<?= url('/assets/web/styleLogin.css');?>">
</head>

<body>
	<form class="box" id="formLogin">
	<h1>Registro</h1>
	<input type="text" required name="name" id="name" placeholder="Nome"/>
	<input type="text" required name="email" id="email" placeholder="Email"/>
	<input type="password" required minlength="8" name="password" id="password" placeholder="Password"/>
	<input type="checkbox" id="isAdmin" name="isAdminBtn" value="isAdmin">
	<label for="isAdmin">Selecione se for ADM</label>
	<input type="submit" name="" value="Registrar" />
	</form>
	<div class="response">
		<p class="response__p" ></p>
	</div>
</body>
</html>


<script type="text/javascript" async>
    const form = document.querySelector("#formLogin");

    const headers = {
            email: "",
            password: ""
    };
	const user = JSON.parse(localStorage.getItem('userLogin'));

	console.log(user);

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
		const isAdminCheckbox = document.getElementById("isAdmin");
        const isAdminValue = isAdminCheckbox.checked ? 1 : 0;

		const dataForm = new FormData(form);
        dataForm.append('isAdmin', isAdminValue);
		console.log(dataForm);

		if (user.isAdmin == 1 && user.isActive == 1) {

			const data = await fetch(`<?= url("api/user");?>`,{
				method: "POST",
				body: dataForm,
				headers: headers
			});
			const user = await data.json();
			console.log(user);
			if (user.type !== "success") {
				let responseDiv = document.querySelector(".response__p");
				responseDiv.innerHTML = "Algo deu errado!";
				responseDiv.classList.add("error");
			} else {
				let responseDiv = document.querySelector(".response__p");
				responseDiv.innerHTML = "Registro feito com sucesso!";
				responseDiv.classList.add("success");
			}
		} else {
			let responseDiv = document.querySelector(".response__p");
			responseDiv.innerHTML = "Você não tem permissão para fazer isso!";
			responseDiv.classList.add("error");
		}});
</script>