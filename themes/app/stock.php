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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<title>Almoxarifado</title>
<link rel="shortcut icon" href="<?= url("imagens/stock.ico"); ?>" type="image/x-icon">


<div class="container">
  <h1>Lista de itens</h1>
  <div class="filter">
    <label for="brand">Marca:</label>
    <select id="brand">
      <option value="">Selecione Categoria</option>
      <?php
      foreach ($marcas as $marca) {
        echo "<option value='{$marca->id}'>{$marca->nome}</option>";
      }
      ?>
    </select>
  </div>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Quantidade</th>
        <th>Local na prateleira</th>
        <th>Marca</th>
        <th>Deletado s/n</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="itemList">
    </tbody>
  </table>
</div>

<!-- Modal para editar carros -->
<div id="edit-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Editar item</h2>
    <form id="edit-form">
      <!-- <input type="hidden" id="id" name="id"> -->
      <label for="id" id="idLabel">ID:</label>
      <input type="text" id="id" name="id">
      <label for="Nome" id="nome">Nome:</label>
      <input type="text" id="inputNome" name="inputNome">
      <label for="quantidade" id="quantidade">Quantidade:</label>
      <input type="text" id="inputQuantidade" name="inputQuantidade">
      <label for="LocalPrateleira" id="localPrateleira">Local Prateleira:</label>
      <input type="text" id="inputPrateleira" name="inputPrateleira">
      <!-- <label for="marca" id="marca">Marca Números:</label>
      <input type="text" id="inputMarca" name="inputMarca"> -->
      <div class="filter">
        <label for="brand">Marca:</label>
        <select id="brandModal">
          <option id="optionModal" value=""></option>
          <?php
          foreach ($marcas as $marca) {
            echo "<option id='optionModal' value='{$marca->id}'>{$marca->nome}</option>";
          }
          ?>
        </select>
        <!-- <label for="nameBrands">Nome da marca:</label>
        <input type="text" id="nameBrands"> -->
      </div>
      <button type="submit">Salvar</button>
    </form>
  </div>
</div>

<button id="btnAdicionarItem">Adicionar Item</button>


<!-- Adicione esta seção abaixo do seu botão "Adicionar Carro" -->
<div id="add-item-modal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeAddItemForm">&times;</span>
    <h2>Adicionar Novo Item</h2>
    <form id="add-item-form">
      <!-- Campos do formulário para adicionar um novo carro -->
      <label for="addNome">Nome:</label>
      <input type="text" id="addNome" name="addNome" required>

      <label for="addQuantidade">Quantidade:</label>
      <input type="text" id="addQuantidade" name="addQuantidade" required>

      <label for="addPrateleira">Local na Prateleira:</label>
      <input type="text" id="addPrateleira" name="addPrateleira" required>

      <label for="addBrand">Marca:</label>
      <select id="addBrand" name="addBrand" required>
        <option value="">Selecione uma Marca</option>
        <?php
        foreach ($marcas as $marca) {
          echo "<option value='{$marca->id}'>{$marca->nome}</option>";
        }
        ?>
      </select>

      <button type="submit">Adicionar Item</button>
    </form>
  </div>
</div>


<button id="btnSair">Sair</button>

<script type="text/javascript">
  const user = JSON.parse(sessionStorage.getItem("userLogin"));


  const tableBrands = document.querySelector("table");
  // Seletor para a modal
  const modal = document.querySelector("#edit-modal");
  // Seletor para o botão de fechar a modal
  const closeModalButton = document.querySelector(".close");

  const selectBrand = document.querySelector("#brand");
  const selectBrandModal = document.querySelector("#brandModal");

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

      const url = "<?= url("api/itens"); ?>";
      console.log(selectBrand.value)
      const response = await fetch(url, {
        method: "get"
      });
      const itens = await response.json();
      const listItem = document.querySelector("#itemList");
      listItem.innerHTML = "";
      itens.forEach((item) => {
        console.log(item);
        const tr = document.createElement("tr");
        tr.setAttribute("data-id", item.id);
        if (item.deletado == 1) {
          tr.setAttribute("style", "display: none;");
        }

        if (item.quantidade == 0 && item.deletado == 0) {
          tr.setAttribute("style", "background-color: red;");
        }
        tr.innerHTML = `<td>${item.id}</td><td>${item.nome}</td><td>${item.quantidade}</td><td>${item.localizacao_prateleira}</td><td>${item.marca}</td><td>${item.deletado}</td><td><button>X</button></td>`;
        listItem.appendChild(tr);

      });
    }
  });

  tableBrands.addEventListener("click", (event) => {
    if (event.target.tagName === "TD") {
      if (user.isActive == 1) {

        const dataFormGetUser = new FormData();
        dataFormGetUser.append('id', event.target.parentNode.getAttribute("data-id"));
        const urlGetItem = "<?= url("api/itens/brand/"); ?>" + selectBrand.value + "/" + event.target.parentNode.getAttribute("data-id");
        const optionsGetItem = {
          method: "get",
          body: dataFormGetUser
        };
        fetch(urlGetItem, optionsGetItem).then((response) => {
          response.json().then((brand) => {
            // carregar os dados no formulário
            const form = document.querySelector("#edit-form");
            form.querySelector("#id").value = brand[0].id;
            form.querySelector("#inputNome").value = brand[0].nome;
            form.querySelector("#inputQuantidade").value = brand[0].quantidade;
            form.querySelector("#inputPrateleira").value = brand[0].localizacao_prateleira;
            form.querySelector("#optionModal").innerHTML = brand[0].marca;
            form.querySelector("#optionModal").value = brand[0].id_marca;
          });
        });
        openModal();
      }
    }

    if (event.target.tagName === "BUTTON") {
      if (user.isActive == 1) {

        const dataFormSetDelete = new FormData();
        dataFormSetDelete.append('id', event.target.parentNode.parentNode.getAttribute("data-id"));
        dataFormSetDelete.append('deletado', 1);

        const urlDeleteItem = "<?= url("api/itens/delete/"); ?>" + selectBrand.value + "/" + event.target.parentNode.parentNode.getAttribute("data-id");
        const optionsDeleteItem = {
          method: "post",
          body: dataFormSetDelete
        };

        fetch(urlDeleteItem, optionsDeleteItem)
          .then((response) => {
            if (!response.ok) {
              throw new Error(`Erro ao excluir o item: ${response.status}`);
            }
            // Faça algo após a exclusão, como recarregar a lista de carros
            // ou atualizar a interface de usuário
          })
          .catch((error) => {
            console.error("Erro:", error);
          });

        const dataHoraAtual = new Date();
        const formatoDataHora = new Intl.DateTimeFormat('pt-BR', {
          dateStyle: 'full',
          timeStyle: 'long'
        });
        const dataHoraFormatada = formatoDataHora.format(dataHoraAtual);

        const dataFormSetLog = new FormData();

        const userLogadoString = sessionStorage.getItem("userLogin");
        const userLogado = JSON.parse(userLogadoString);
        console.log(userLogado.id)

        dataFormSetLog.append('id_item', event.target.parentNode.parentNode.getAttribute("data-id"));
        dataFormSetLog.append('id_usuario', userLogado.id);
        dataFormSetLog.append('data_hora_exclusao', dataHoraFormatada);
        console.log(dataHoraFormatada)

        const urlDeleteLog = "<?= url("api/itens/delete/log"); ?>";
        const optionsDeleteLog = {
          method: "post",
          body: dataFormSetLog
        };

        fetch(urlDeleteLog, optionsDeleteLog)
          .then((response) => {
            if (!response.ok) {
              throw new Error(`Erro ao excluir o item: ${response.status}`);
            }
            // Faça algo após a exclusão, como recarregar a lista de carros
            // ou atualizar a interface de usuário
          })
          .catch((error) => {
            console.error("Erro:", error);
          });
      }
    }
  });

  selectBrand.addEventListener("change", async () => {
    if (user.isActive == 1) {

      const url = "<?= url("api/itens/brand/"); ?>" + selectBrand.value;
      console.log(selectBrand.value)
      const response = await fetch(url, {
        method: "get"
      });
      const itens = await response.json();
      const listItem = document.querySelector("#itemList");
      listItem.innerHTML = "";
      itens.forEach((item) => {
        console.log(item);
        const tr = document.createElement("tr");
        tr.setAttribute("data-id", item.id);
        if (item.deletado == 1) {
          tr.setAttribute("style", "display: none;");
        }

        if (item.quantidade == 0 && item.deletado == 0) {
          tr.setAttribute("style", "background-color: red;");
        }
        tr.innerHTML = `<td>${item.id}</td><td>${item.nome}</td><td>${item.quantidade}</td><td>${item.localizacao_prateleira}</td><td>${item.marca}</td><td>${item.deletado}</td><td><button>X</button></td>`;
        listItem.appendChild(tr);

      });
    }
  });

  const editForm = document.querySelector("#edit-form");
  editForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    if (user.isActive == 1) {

      const selectBrandModal = document.querySelector("#brandModal");

      const dataForm = new FormData(editForm);
      dataForm.append('deletado', 0);
      dataForm.append('id_marcas', selectBrandModal.value);

      $.ajax({
        type: "POST",
        url: `<?= url("api/item/") ?>${event.target.parentNode.parentNode.getAttribute("data-id")}`,
        data: dataForm,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.user.type = success) {
            console.log("Item atualizado com sucesso!", response.message);
            // Adicione aqui código para exibir uma mensagem de sucesso ao usuário, se necessário
            alert("Item atualizado com sucesso!");
          } else {
            console.error("Erro ao atualizar item:", response.message);
            // Adicione aqui código para exibir uma mensagem de erro ao usuário, se necessário
            alert("Erro ao atualizar item: " + response.message);
          }
        },
        error: function() {
          console.error("Erro ao atualizar item: Erro na requisição AJAX");
          // Adicione aqui código para exibir uma mensagem de erro ao usuário, se necessário
          alert("Erro ao atualizar item: Erro na requisição AJAX");
        }
      });
    }
  });

  // Seletor para o botão Sair
  const btnSair = document.querySelector("#btnSair");

  // Adicionar um ouvinte de evento para o botão Sair
  btnSair.addEventListener("click", function() {
    // Redirecionar para a URL desejada
    window.location.href = "<?php echo url('/'); ?>";
  });

  const addItemModal = document.querySelector("#add-item-modal");
  const addItemForm = document.querySelector("#add-item-form");
  const btnAdicionarItem = document.querySelector("#btnAdicionarItem");
  const closeAddItemForm = document.querySelector("#closeAddItemForm");

  // Abrir o formulário de adição ao clicar no botão "Adicionar Carro"
  btnAdicionarItem.addEventListener("click", function() {
    addItemModal.style.display = "block";
  });

  // Fechar o formulário de adição ao clicar no botão de fechar
  closeAddItemForm.onclick = function() {
    addItemModal.style.display = "none";
  };

  // Enviar dados do formulário para a API ao submeter o formulário
  addItemForm.addEventListener("submit", async function(event) {
    event.preventDefault();
    if (user.isActive == 1) {


      const formData = new FormData(addItemForm);
      const selectBrandAdd = document.querySelector("#addBrand");
      formData.append('add_id_marcas', selectBrandAdd.value);




      $.ajax({
        type: "POST",
        url: "<?= url("api/item/add"); ?>",
        data: formData,
        processData: false, // Evita o processamento automático do FormData
        contentType: false, // Não define automaticamente o cabeçalho Content-Type
        success: function(response) {
          alert("Item adicionado com sucesso!");
        },
        error: function() {
          alert("Erro ao adicionar item!");

        }
      });
    }
  });
</script>