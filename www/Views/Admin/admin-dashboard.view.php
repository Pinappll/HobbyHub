<div class="dashboard">
    <div class="dashboard-title">
        <h2>Tableau de bord Administrateur</h2>
    </div>
    <div class="dashboard-items">
        <div class="dashboard-item">
            <canvas id="userRolesPieChart"></canvas>
        </div>
        <div class="dashboard-item">
            <canvas id="userRegistrationsChart"></canvas>
        </div>
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
// Instancier les modèles nécessaires
$user = new \App\Models\User();
$review = new \App\Models\Review();
$recipe = new \App\Models\Recipe();
$page = new \App\Models\Page();

// Récupérer le nombre d'utilisateurs, de reviews, de recettes et de pages
$numberOfUsers = $user->countRows();
$numberOfReviews = $review->countRows();
$numberOfRecipes = $recipe->countRows();
$numberOfPages = $page->countRows();

// Récupérer les inscriptions d'utilisateurs par mois
$userRegistrationsByMonth = $user->getUserRegistrationsByMonth();

// Générer les données pour le graphique des inscriptions par mois
$months = array_map(function($entry) {
    return date('M Y', strtotime($entry['month']));
}, $userRegistrationsByMonth);

$registrationCounts = array_map(function($entry) {
    return $entry['count'];
}, $userRegistrationsByMonth);

// Récupérer le nombre d'utilisateurs par rôle
$userRolesCount = $user->countUsersByRole();
$roleLabels = array_map(function($entry) {
    return ucfirst($entry['type_user']);  // Mettre en majuscule la première lettre
}, $userRolesCount);

$roleCounts = array_map(function($entry) {
    return $entry['count'];
}, $userRolesCount);
?>
<script>
    // Graphique des rôles des utilisateurs (Pie Chart)
    const userRolesCtx = document.getElementById('userRolesPieChart').getContext('2d');
    new Chart(userRolesCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($roleLabels) ?>,
            datasets: [{
                label: 'Répartition des utilisateurs par rôle',
                data: <?= json_encode($roleCounts) ?>,
                backgroundColor: ['#92140c', '#f8c630', '#2d2d2d'], // Couleurs pour les différents rôles
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    // Graphique des inscriptions d'utilisateurs par mois
    const userRegistrationsCtx = document.getElementById('userRegistrationsChart').getContext('2d');
    new Chart(userRegistrationsCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($months) ?>,
            datasets: [{
                label: 'Inscriptions par mois',
                data: <?= json_encode($registrationCounts) ?>,
                backgroundColor: '#f8c630',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique du nombre total d'utilisateurs
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Utilisateurs'],
            datasets: [{
                label: 'Nombre d\'utilisateurs',
                data: [<?= $numberOfUsers ?>],
                borderWidth: 2,
                backgroundColor: ['#92140c']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique du nombre total de reviews
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
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique du nombre total de recettes
    const ctx3 = document.getElementById('myChart3');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Recettes'],
            datasets: [{
                label: 'Nombre de recettes',
                data: [<?= $numberOfRecipes ?>],
                borderWidth: 2,
                backgroundColor: ['#92140c']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique du nombre total de pages
    const ctx4 = document.getElementById('myChart4');
    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: ['Pages'],
            datasets: [{
                label: 'Nombre de pages',
                data: [<?= $numberOfPages ?>],
                borderWidth: 2,
                backgroundColor: ['#f8c630']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
