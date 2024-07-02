document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('loginNome').value;
    const password = document.getElementById('loginPassword').value;

    const loginData = {
        username: username,
        password: password
    };

    fetch('http://localhost:8080/condominio_gestao/backend/routes/api.php?action=login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(loginData)
    })
    .then(response => response.text())
    .then(data => {
        console.log('Resposta recebida como texto:', data);  // Log para ver a resposta

        // Tente fazer o parse apenas se o texto estiver no formato esperado
        try {
            const parsedData = JSON.parse(data);
            if (parsedData.message === "Login successful.") {
                const userRole = parsedData.user.role;
                handleRedirection(userRole);
            } else {
                alert('Erro no login: ' + parsedData.message);
            }
        } catch (error) {
            console.error('Erro ao parsear JSON:', error);
            alert('Erro inesperado ao fazer login.');
        }
    })
    .catch(error => console.error('Erro ao fazer login:', error));
});

function handleRedirection(userRole) {
    if (userRole === 'Admin') {
        window.location.href = '/admin-dashboard.html';
    } else if (userRole === 'Residente') {
        window.location.href = '/resident-dashboard.html';
    } else if (userRole === 'Funcionario') {
        window.location.href = '/staff-dashboard.html';
    } else if (userRole === 'PrestadorServico') {
        window.location.href = '/service-provider-dashboard.html';
    } else {
        alert('Role não reconhecido.');
    }
}


