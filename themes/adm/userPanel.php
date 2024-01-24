<?php
//$this->layout("_theme");
?>
<style>
    .content {
        flex-grow: 1;
        padding: 20px;
        background-color: #f4f4f4;
        margin-left: 250px;
        margin-top: 40px;
        /* Adicionei para deixar espaço para a barra horizontal fixa */
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        font-size: 24px;
        text-align: center;
        margin-bottom: 20px;
    }

    .filter {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    select,
    input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    label,
    input,
    select,
    button {
        margin-bottom: 10px;
        font-size: 16px;
    }

    button {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    button:hover {
        background-color: #45a049;
    }

    /* Adicione estilos para a modal aqui */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<link rel="shortcut icon" href="<?= url("imagens/stock.ico"); ?>" type="image/x-icon">
<title>Almoxarifado</title>
<div class="container">
    <h1>Lista de funcionários</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Adm</th>
                <th>Ativo</th>
                <th>Desativar</th>
            </tr>
        </thead>
        <tbody id="userList">
        </tbody>
    </table>
</div>

<div id="edit-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Editar usuario</h2>
    <form id="edit-form">
      <!-- <input type="hidden" id="id" name="id"> -->
      <label for="id" id="idLabel">ID:</label>
      <input type="text" id="id" name="id">
      <label for="Nome" id="nome">Nome:</label>
      <input type="text" id="inputNome" name="inputNome">
      <label for="email" id="email">Email:</label>
      <input type="text" id="inputEmail" name="inputEmail">
      <label for="isAdmin" id="isAdmin">Adm:</label>
      <input type="text" id="inputIsAdmin" name="inputIsAdmin">
      <label for="isActive" id="isActive">Ativo:</label>
      <input type="text" id="inputIsActive" name="inputIsActive">
  
      </div>
      <button type="submit">Salvar</button>
    </form>
  </div>
</div>

<button id="btnAdicionarItem">Adicionar usuario</button>


<button id="btnSair">Sair</button>


<script type="module" async>
    // import {
    //     request,
    //     requestDebugError
    // } from "<?php echo url("/assets/_shared/functions.js"); ?>";

    // const url = "<?php echo url("api/user/list"); ?>";

    // const options = {
    //     method: "GET"
    // };
    // const userList = document.getElementById('userList');

    // // Utilizando async/await para aguardar a resposta da API
    // try {
    //     const data = await request(url, options);

    //     // Limpar o conteúdo existente no corpo da tabela
    //     userList.innerHTML = '';

    //     // Iterar sobre os usuários recebidos da API
    //     data.forEach(user => {
    //         const row = document.createElement('tr');

    //         // Criar células para cada propriedade do usuário
    //         const idCell = document.createElement('td');
    //         idCell.textContent = user.id;
    //         row.appendChild(idCell);

    //         const nameCell = document.createElement('td');
    //         nameCell.textContent = user.nome;
    //         row.appendChild(nameCell);

    //         const emailCell = document.createElement('td');
    //         emailCell.textContent = user.email;
    //         row.appendChild(emailCell);

    //         const isAdminCell = document.createElement('td');
    //         isAdminCell.textContent = user.isAdmin;
    //         row.appendChild(isAdminCell);

    //         const isActiveCell = document.createElement('td');
    //         isActiveCell.textContent = user.isActive;
    //         row.appendChild(isActiveCell);

    //         const deleteCell = document.createElement('td');
    //         const deleteButton = document.createElement('button');
    //         deleteButton.textContent = 'Desativar';
    //         // Adicione um evento de clique ao botão de exclusão, se necessário
    //         // deleteButton.addEventListener('click', () => { /* Lógica de exclusão */ });
    //         deleteCell.appendChild(deleteButton);

    //         row.appendChild(deleteCell);

    //         userList.appendChild(row);
    //     });
    // } catch (error) {
    //     // Lida com erros na requisição
    //     console.error('Erro na requisição:', error);
    // }
    

//     deleteButton.addEventListener('click', async (event) => {

//     if (event.target.tagName === "BUTTON") {
//       if (user.isActive == 1) {

//         const dataFormSetDelete = new FormData();
//         dataFormSetDelete.append('id', event.target.parentNode.parentNode.getAttribute("data-id"));
//         dataFormSetDelete.append('isActive', 0);

//         const urlDeleteUser = "<?= url("api/user/delete/"); ?>" + "/" + event.target.parentNode.parentNode.getAttribute("data-id");
//         const optionsDeleteUser = {
//           method: "post",
//           body: dataFormSetDelete
//         };

//         fetch(urlDeleteUser, optionsDeleteUser)
//           .then((response) => {
//             if (!response.ok) {
//               throw new Error(`Erro ao excluir o usuario: ${response.status}`);
//             }
//             // Faça algo após a exclusão, como recarregar a lista de carros
//             // ou atualizar a interface de usuário
//           })
//           .catch((error) => {
//             console.error("Erro:", error);
//           });

//         }
//     }
// });
    
        

//     const btnSair = document.getElementById("btnSair");

//     btnSair.addEventListener("click", function() {
//         window.location.href = "<?php echo url('/'); ?>";
//     });
</script>

<script type="text/javascript">
  const user = JSON.parse(sessionStorage.getItem("userLogin"));

  const tableUsers = document.querySelector("table");

  const modal = document.querySelector("#edit-modal");
  // Seletor para o botão de fechar a modal
  const closeModalButton = document.querySelector(".close");


  // Função para abrir a modal com dados do produto (vai receber por parâmetro o id do produto)
  function openModal() {
    modal.style.display = "block";
  }

  // Fechar a modal ao clicar no botão de fechar
  closeModalButton.onclick = function() {
    modal.style.display = "none";
  };

  // Fechar a modal quando o usuário clicar fora dela
  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };

  // Função para carregar os dados do produto na modal

  window.addEventListener('load', async ()=>{
    if (user.isActive == 1) {

      const url = "<?= url("api/user/list"); ?>";
      const response = await fetch(url, {
        method: "get"
      });
      const users = await response.json();
      console.log(users);
      const listUser = document.querySelector("#userList");
      listUser.innerHTML = "";
      users.forEach((user) => {
        const tr = document.createElement("tr");
        tr.setAttribute("data-id", user.id);

        if (user.isActive == 0) {
          tr.setAttribute("style", "background-color: red;");
        }
        tr.innerHTML = `<td>${user.id}</td><td>${user.nome}</td><td>${user.email}</td><td>${user.isAdmin}</td><td>${user.isActive}</td><td><button>Desativar</button></td>`;
        listUser.appendChild(tr);

      });
    }
  });

  tableUsers.addEventListener("click", (event) => {
    if (event.target.tagName === "TD") {
      if (user.isActive == 1 && user.isAdmin == 1) {

        const urlGetUser = "<?= url("api/user/list"); ?>" + "/" + event.target.parentNode.getAttribute("data-id");
        const optionsGetUser = {
          method: "get"
        };
        fetch(urlGetUser, optionsGetUser).then((response) => {
          response.json().then((user) => {
            // carregar os dados no formulário
            const form = document.querySelector("#edit-form");
            form.querySelector("#id").value = user[0].id;
            form.querySelector("#inputNome").value = user[0].nome;
            form.querySelector("#inputEmail").value = user[0].email;
            form.querySelector("#inputIsAdmin").value = user[0].isAdmin;
            form.querySelector("#optionActive").innerHTML = user[0].isActive;
          });
        });
        openModal();
      }
    }

    if (event.target.tagName === "BUTTON") {
      if (user.isActive == 1 && user.isAdmin == 1) {

        const dataFormSetDelete = new FormData();
        dataFormSetDelete.append('id', event.target.parentNode.parentNode.getAttribute("data-id"));
        dataFormSetDelete.append('isActive', 0);

        const urlDeleteItem = "<?= url("api/user/delete"); ?>"  + "/" + event.target.parentNode.parentNode.getAttribute("data-id");
        const optionsDeleteItem = {
          method: "post",
          body: dataFormSetDelete
        };

        fetch(urlDeleteItem, optionsDeleteItem)
          .then((response) => {

            if (!response.ok) {0
              throw new Error(`Erro ao excluir o item: ${response.status}`);
            }
            else{
              alert("Usuario desativado com sucesso!");
            }
            // Faça algo após a exclusão, como recarregar a lista de carros
            // ou atualizar a interface de usuário
          })
          .catch((error) => {
            console.error("Erro:", error);
          });
        }
        else{
          alert("Você não tem permissão para fazer isso!");
        }
    }
  });

 
  // Seletor para o botão Sair
  const btnSair = document.querySelector("#btnSair");

//   // Adicionar um ouvinte de evento para o botão Sair
  btnSair.addEventListener("click", function() {
    // Redirecionar para a URL desejada
    window.location.href = "<?php echo url('/'); ?>";
  });

  const closeAddUserForm = document.querySelector("#closeAddUserForm");

  btnAdicionarItem.addEventListener("click", function() {
    window.location.href = "<?php echo url('/registro'); ?>";
  });

</script>