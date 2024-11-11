<?php
require_once __DIR__ . '/query.php';
$expertiseData = getExpertiseData();
?>

<section class="expertise-section" aria-labelledby="expertise-heading">
    <div class="expertise-container">
        <h2 id="expertise-heading">[translate key="expertise_section_title" lang="en"]</h2>
        
        <?php if ($expertiseData && !empty($expertiseData)): ?>
            <div class="expertise-grid">
                <?php foreach ($expertiseData as $area): ?>
                    <div class="expertise-card">
                        <?php if (isset($area['icon'])): ?>
                            <div class="expertise-icon">
                                <img src="<?php echo htmlspecialchars($area['icon']); ?>" 
                                     alt="<?php echo htmlspecialchars($area['title']); ?> [translate key='icon_alt_text' lang='en']"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>
                        
                        <h3><?php echo htmlspecialchars($area['title']); ?></h3>
                        
                        <?php if (isset($area['description'])): ?>
                            <p><?php echo htmlspecialchars($area['description']); ?></p>
                        <?php endif; ?>
                        
                        <?php if (isset($area['key_points']) && !empty($area['key_points'])): ?>
                            <ul class="expertise-points">
                                <?php foreach ($area['key_points'] as $point): ?>
                                    <li><?php echo htmlspecialchars($point); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-expertise">[translate key="expertise_not_available" lang="en"]</p>
        <?php endif; ?>
    </div>
</section>
