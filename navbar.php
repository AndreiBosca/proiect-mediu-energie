<nav class="main-nav">
    <div class="nav-brand">
        <div>⚡ Monitorizare Energie</div>
        <div class="nav-user-info">Salut, <?= htmlspecialchars($_SESSION['username']) ?>!</div>
    </div>

    <div class="nav-links">
        <a href="dashboard.php">📊 Panou</a>
        <a href="chart_page.php">📈 Grafic</a>
        <a href="calculations.php">🧮 Calculator</a>
        <a href="logout.php" class="logout-btn">🚪 Deconectare</a>
    </div>
</nav>