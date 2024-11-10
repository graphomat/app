<div class="content-header">
    <h1>Dashboard</h1>
</div>

<div class="dashboard-grid">
    <div class="card">
        <h3>Quick Stats</h3>
        <div id="stats-container">Loading...</div>
    </div>

    <div class="card">
        <h3>Recent Updates</h3>
        <div id="updates-container">Loading...</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Fetch stats
        const stats = await handleApiRequest('stats');
        const statsContainer = document.getElementById('stats-container');
        statsContainer.innerHTML = `
            <div class="stats-grid">
                <div class="stat-item">
                    <h4>Pages</h4>
                    <p>${stats.pages || 0}</p>
                </div>
                <div class="stat-item">
                    <h4>Menu Items</h4>
                    <p>${stats.menuItems || 0}</p>
                </div>
                <div class="stat-item">
                    <h4>Media Files</h4>
                    <p>${stats.mediaFiles || 0}</p>
                </div>
            </div>
        `;

        // Fetch recent updates
        const updates = await handleApiRequest('updates');
        const updatesContainer = document.getElementById('updates-container');
        updatesContainer.innerHTML = `
            <div class="updates-list">
                ${updates.map(update => `
                    <div class="update-item">
                        <p>${update.description}</p>
                        <small>${new Date(update.created_at).toLocaleString()}</small>
                    </div>
                `).join('')}
            </div>
        `;
    } catch (error) {
        console.error('Error loading dashboard:', error);
    }
});
</script>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 15px;
}

.stat-item {
    text-align: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 4px;
}

.stat-item h4 {
    color: var(--primary-color);
    margin-bottom: 5px;
}

.stat-item p {
    font-size: 24px;
    font-weight: bold;
    color: var(--secondary-color);
}

.updates-list {
    margin-top: 15px;
}

.update-item {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.update-item:last-child {
    border-bottom: none;
}

.update-item small {
    color: #666;
    display: block;
    margin-top: 5px;
}
</style>
