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
<div class="container">
  <h1>Lista de logs</h1>
  <div class="filter">

  </div>
  <table>
    <thead>
      <tr>
        <th>ID Item</th>
        <th>Item</th>
        <th>Quantidade</th>
        <th>Local na prateleira</th>
        <th>Usuario</th>
        <th>Email</th>
        <th>Data e Hora</th>
      </tr>
    </thead>
    <tbody id="logList">
    </tbody>
  </table>
</div>

<button id="btnSair">Sair</button>

<script type="text/javascript">
  // Função para abrir a modal com dados do produto (vai receber por parâmetro o id do produto)

  // Função para carregar os dados do produto na modal


  window.addEventListener("load", async () => {
    const url = "<?= url("api/log/list"); ?>";
    const response = await fetch(url, {
      method: "get"
    });
    const logs = await response.json();
    const listLog = document.querySelector("#logList");
    listLog.innerHTML = "";
    logs.forEach((log) => {
      const tr = document.createElement("tr");
      tr.setAttribute("data-id", log.id);
      tr.innerHTML = `<td>${log.id_item}</td><td>${log.item_nome}</td><td>${log.item_quantidade}</td><td>${log.item_localizacao}</td><td>${log.usuario_nome}</td><td>${log.usuario_email}</td><td>${log.data_hora_exclusao}</td>`;
      listLog.appendChild(tr);
      // console.log(car);
    });
  });



  // Seletor para o botão Sair
  const btnSair = document.querySelector("#btnSair");

  // Adicionar um ouvinte de evento para o botão Sair
  btnSair.addEventListener("click", function() {
    // Redirecionar para a URL desejada
    window.location.href = "<?php echo url('/'); ?>";
  });
</script>