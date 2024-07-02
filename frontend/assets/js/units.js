// document.addEventListener('DOMContentLoaded', () => {
//     fetchUnits();
    
//     // Event listener for form submission
//     document.getElementById('add-unit-form').addEventListener('submit', (event) => {
//         event.preventDefault();
//         addUnit();
//     });
// });

// // Function to fetch all units
// function fetchUnits() {
//     fetch('http://localhost:8080/condominio_gestao/backend/routes/api.php?action=getAllUnidades')
//         .then(response => response.json())
//         .then(data => displayUnits(data.records))
//         .catch(error => console.error('Error fetching units:', error));
// }

// // Function to display units in the DOM
// function displayUnits(units) {
//     const unitsContainer = document.getElementById('units-container');
//     unitsContainer.innerHTML = ''; // Clear the container

//     if (units && units.length > 0) {
//         const table = document.createElement('table');
//         table.classList.add('table', 'table-striped');
//         table.innerHTML = `
//             <thead>
//                 <tr>
//                     <th>Number</th>
//                     <th>Area</th>
//                     <th>Condominium</th>
//                     <th>Actions</th>
//                 </tr>
//             </thead>
//             <tbody>
//                 ${units.map(unit => `
//                     <tr>
//                         <td>${unit.numero}</td>
//                         <td>${unit.area}</td>
//                         <td>${unit.condominio_id}</td>
//                         <td>
//                             <button class="btn btn-primary btn-sm" onclick="updateUnit(${unit.id})">Update</button>
//                             <button class="btn btn-danger btn-sm" onclick="deleteUnit(${unit.id})">Remove</button>
//                         </td>
//                     </tr>
//                 `).join('')}
//             </tbody>
//         `;
//         unitsContainer.appendChild(table);
//     } else {
//         unitsContainer.innerHTML = '<p>No units found.</p>';
//     }
// }

// // Function to add a new unit


// function addUnit() {
//     const unitNumber = document.getElementById('unitNumber').value;
//     const unitArea = document.getElementById('unitArea').value;
//     const condominiumName = document.getElementById('condominiumName').value;

//     const unitData = {
//         numero: unitNumber,
//         area: unitArea,
//         condominio_id: condominiumName
//     };

//     fetch('http://localhost:8080/condominio_gestao/backend/routes/api.php?action=createUnidade', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(unitData)
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.message === "Unidade criada com sucesso.") {
//             // Close the modal
//             document.querySelector('#addUnitModal .btn-close').click();
//             // Fetch and display units again
//             fetchUnits();
//         } else {
//             alert('Error adding unit.');
//         }
//     })
//     .catch(error => console.error('Error adding unit:', error));
// }

// // Function to update a unit (placeholder)
// // function updateUnit(id) {
// //     // Logic for updating a unit
// //     alert('Update unit function called for unit id: ' + id);
// // }

// // Function to delete a unit
// function deleteUnit(id) {
//     fetch(`https://api.exemplo.com/unidades/${id}`, {
//         method: 'DELETE'
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.message === "Unidade deletada com sucesso.") {
//             fetchUnits(); // Refresh the list
//         } else {
//             alert('Error deleting unit.');
//         }
//     })
//     .catch(error => console.error('Error deleting unit:', error));
// }

$(document).ready(function() {
    // Função para carregar os dados da API e atualizar a tabela
    function loadUnitData() {
        $.ajax({
            url: 'http://localhost:8080/condominio_gestao/backend/routes/api.php?action=getAllUnidades',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Dados recebidos:', data); // Log para verificar os dados recebidos

                // Limpa o conteúdo atual da tabela
                $('#datatablesSimple tbody').empty();

                // Verifica se há dados para exibir
                if (data && data.length > 0) {
                    // Itera sobre os dados recebidos e adiciona cada unidade na tabela
                    $.each(data, function(index, unit) {
                        var row = `<tr>
                                       <td>${unit.numero}</td>
                                       <td>${unit.area}</td>
                                       <td>${unit.condominio_nome}</td> <!-- Exibe o nome do condomínio -->
                                       <td>
                                           <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateCondoModal">Update</button>
                                           <button type="button" class="btn btn-danger btn-sm">Remove</button>
                                       </td>
                                   </tr>`;
                        $('#datatablesSimple tbody').append(row);
                    });
                } else {
                    // Caso não haja dados
                    $('#datatablesSimple tbody').append('<tr><td colspan="4">Nenhum dado encontrado.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar dados da API:', error);
            }
        });
    }

    // Carregar os dados quando a página carregar
    loadUnitData();
});

$(document).ready(function() {
    // Função para carregar os nomes dos condomínios disponíveis
    function loadCondominioNames() {
        $.ajax({
            url: 'http://localhost:8080/condominio_gestao/backend/routes/api.php?action=getAllCondominioNames',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#condominiumName');
                select.empty(); // Limpa as opções existentes

                // Adiciona uma opção padrão (seleção inicial)
                select.append($('<option>').attr('disabled', true).attr('selected', true).text('Select Condominium Name'));

                // Preenche as opções do select com os nomes dos condomínios
                $.each(data, function(index, nome) {
                    select.append($('<option>').text(nome));
                });
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar nomes dos condomínios:', error);
            }
        });
    }

    // Carrega os nomes dos condomínios quando a página carrega
    loadCondominioNames();
});

document.addEventListener('DOMContentLoaded', () => {
    fetchUnits();

    // Event listener for form submission
    document.getElementById('add-unit-form').addEventListener('submit', (event) => {
        event.preventDefault();
        addUnit();
    });
});

// Function to fetch all units
function fetchUnits() {
    fetch('http://localhost:8080/condominio_gestao/backend/routes/api.php?action=getAllUnidades')
        .then(response => response.json())
        .then(data => displayUnits(data.records))
        .catch(error => console.error('Error fetching units:', error));
}

// Function to display units in the DOM
function displayUnits(units) {
    const unitsContainer = document.getElementById('units-container');
    unitsContainer.innerHTML = ''; // Clear the container

    if (units && units.length > 0) {
        const table = document.createElement('table');
        table.classList.add('table', 'table-striped');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Area</th>
                    <th>Condominium</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ${units.map(unit => `
                    <tr>
                        <td>${unit.numero}</td>
                        <td>${unit.area}</td>
                        <td>${unit.condominio_id}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="updateUnit(${unit.id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUnit(${unit.id})">Remove</button>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        `;
        unitsContainer.appendChild(table);
    } else {
        unitsContainer.innerHTML = '<p>No units found.</p>';
    }
}

// Function to add a new unit
function addUnit() {
    const unitNumber = document.getElementById('unitNumber').value;
    const unitArea = document.getElementById('unitArea').value;
    const condominiumName = document.getElementById('condominiumName').value;

    const unitData = {
        numero: unitNumber,
        area: unitArea,
        condominio_id: condominiumName
    };

    fetch('http://localhost:8080/condominio_gestao/backend/routes/api.php?action=createUnidade', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(unitData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Unidade criada com sucesso.") {
            // Close the modal
            document.querySelector('#addUnitModal .btn-close').click();
            // Fetch and display units again
            fetchUnits();
        } else {
            alert('Error adding unit.');
        }
    })
    .catch(error => console.error('Error adding unit:', error));
}


// Função para preencher o modal de atualização de unidade com os dados da unidade selecionada
function updateUnit(id) {
    // Primeiro, buscar os dados da unidade com o ID fornecido
    fetch(`http://localhost:8080/condominio_gestao/backend/routes/api.php?action=getUnit&id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Preencher os campos do modal com os dados recebidos
            document.getElementById('updateUnitId').value = data.id;
            document.getElementById('updateUnitNumber').value = data.numero;
            document.getElementById('updateUnitArea').value = data.area;
            document.getElementById('updateCondominiumName').value = data.condominio_id; // Selecione o condomínio correto

            // Abrir o modal de atualização de unidade
            var updateUnitModal = new bootstrap.Modal(document.getElementById('updateUnitModal'));
            updateUnitModal.show();
        })
        .catch(error => console.error('Error fetching unit details:', error));
}

// Event listener para o envio do formulário de atualização de unidade
document.getElementById('update-unit-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Coletar os dados do formulário
    var unitId = document.getElementById('updateUnitId').value;
    var unitNumber = document.getElementById('updateUnitNumber').value;
    var unitArea = document.getElementById('updateUnitArea').value;
    var condominiumId = document.getElementById('updateCondominiumName').value;

    // Montar os dados para enviar via AJAX
    var unitData = {
        id: unitId,
        numero: unitNumber,
        area: unitArea,
        condominio_id: condominiumId
    };

    // Requisição AJAX para atualizar a unidade
    fetch('http://localhost:8080/condominio_gestao/backend/routes/api.php?action=updateUnit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(unitData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Unit updated successfully.") {
            // Fechar o modal de atualização de unidade
            var updateUnitModal = bootstrap.Modal.getInstance(document.getElementById('updateUnitModal'));
            updateUnitModal.hide();

            // Atualizar a lista de unidades exibidas
            fetchUnits();
        } else {
            alert('Error updating unit.');
        }
    })
    .catch(error => console.error('Error updating unit:', error));
});



// Function to delete a unit
function deleteUnit(id) {
    fetch(`https://api.exemplo.com/unidades/${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Unidade deletada com sucesso.") {
            fetchUnits(); // Refresh the list
        } else {
            alert('Error deleting unit.');
        }
    })
    .catch(error => console.error('Error deleting unit:', error));
}

