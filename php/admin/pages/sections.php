<?php
// Get all sections that have admin.php files
$sections = [];
$sectionsPath = __DIR__ . '/../../sections/';
$sectionDirs = glob($sectionsPath . '*', GLOB_ONLYDIR);

foreach ($sectionDirs as $dir) {
    $adminFile = $dir . '/admin.php';
    if (file_exists($adminFile)) {
        $sectionName = basename($dir);
        $sections[] = [
            'name' => $sectionName,
            'path' => $adminFile
        ];
    }
}
?>

<div class="sections-page">
    <h1>Sections Management</h1>
    
    <div class="sections-grid">
        <?php foreach ($sections as $section): ?>
        <div class="section-card">
            <h3><?= ucfirst($section['name']) ?> Section</h3>
            <div class="section-content">
                <?php include $section['path']; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.sections-page {
    padding: 20px;
}

.sections-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.section-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
}

.section-card h3 {
    margin: 0 0 15px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.section-content {
    min-height: 100px;
}
</style>
