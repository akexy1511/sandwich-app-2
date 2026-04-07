</div>
<footer class="app-footer">
    © CEPES 2026 — Cyril Libouton & Alexy Viatour
</footer>

<script>
    // Gestionnaire d'événements pour le bouton de changement de thème
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-toggle');
        const icon = document.querySelector('.theme-toggle-icon');
        
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                // Changer l'icône
                icon.textContent = newTheme === 'dark' ? '☀️' : '🌙';
                icon.style.transform = newTheme === 'dark' ? 'rotate(180deg)' : 'rotate(0deg)';
            });
            
            // Initialiser l'icône correctement
            const currentTheme = document.documentElement.getAttribute('data-theme');
            icon.textContent = currentTheme === 'dark' ? '☀️' : '🌙';
        }
    });
</script>

</body>
</html>
