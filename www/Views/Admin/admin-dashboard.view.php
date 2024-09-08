<div class="dashboard">
    <div class="dashboard-title">
        <h2>Tableau de bord Administrateur</h2>
    </div>
    <div class="dashboard-items">
        <div class="dashboard-item">
            <canvas id="myChart"></canvas>
        </div>
        <div class="dashboard-item">
            <canvas id="myChart2"></canvas>
        </div>
        <div class="dashboard-item">
            <canvas id="myChart3"></canvas>
        </div>
        <div class="dashboard-item">
            <canvas id="myChart4"></canvas>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
// Instancier un nouvel objet User
$user = new \App\Models\User();
$review = new \App\Models\Review();
$recipe = new \App\Models\Recipe();
$page = new \App\Models\Page();

// Récupérer le nombre d'utilisateurs
$numberOfUsers = $user->countRows();
$numberOfReviews = $review->countRows();
$numberOfRecipes = $recipe->countRows();
$numberOfPages = $page->countRows();
?>


<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Utilisateurs'],
            datasets: [{
                label: 'Nombre d\'utilisateurs',
                data: [<?= $numberOfUsers ?>],
                borderWidth: 2,
                backgroundColor: ['#92140C']
                
            }]
        },
        options: {
        responsive: true,  // Permet le redimensionnement
        maintainAspectRatio: false, // Utiliser toute la taille du conteneur
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

    const ctx2 = document.getElementById('myChart2');

    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Reviews'],
            datasets: [{
                label: 'Nombre de reviews',
                data: [<?= $numberOfReviews ?>],
                borderWidth: 2,
                backgroundColor: ['#F8C630']
            }]
        },
        options: {
        responsive: true,  // Permet le redimensionnement
        maintainAspectRatio: false, // Utiliser toute la taille du conteneur
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

    const ctx3 = document.getElementById('myChart3');

    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Recettes'],
            datasets: [{
                label: 'Nombre de recettes',
                data: [<?= $numberOfRecipes ?>],
                borderWidth: 2,
                backgroundColor: ['#BE5A38']
            }]
        },
        options: {
        responsive: true,  // Permet le redimensionnement
        maintainAspectRatio: false, // Utiliser toute la taille du conteneur
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

    const ctx4 = document.getElementById('myChart4');

    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: ['Pages'],
            datasets: [{
                label: 'Nombre de pages',
                data: [<?= $numberOfReviews ?>],
                borderWidth: 2,
                backgroundColor: ['#353238']
            }]
        },
        options: {
        responsive: true,  // Permet le redimensionnement
        maintainAspectRatio: false, // Utiliser toute la taille du conteneur
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>