<?php
require_once __DIR__ . '/query.php';
$educationData = getEducationData();
?>

<section class="education-section" aria-labelledby="education-heading">
    <div class="education-container">
        <h2 id="education-heading">[translate key="education_section_title" lang="en"]</h2>
        
        <?php if ($educationData): ?>
            <?php if (isset($educationData['intro'])): ?>
                <div class="education-intro">
                    <?php echo htmlspecialchars($educationData['intro']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($educationData['programs']) && !empty($educationData['programs'])): ?>
                <div class="education-programs">
                    <?php foreach ($educationData['programs'] as $program): ?>
                        <div class="program-card">
                            <?php if (isset($program['image'])): ?>
                                <div class="program-image">
                                    <img src="<?php echo htmlspecialchars($program['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($program['title']); ?>"
                                         loading="lazy">
                                </div>
                            <?php endif; ?>

                            <div class="program-content">
                                <h3><?php echo htmlspecialchars($program['title']); ?></h3>
                                
                                <?php if (isset($program['description'])): ?>
                                    <p class="program-description">
                                        <?php echo htmlspecialchars($program['description']); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (isset($program['details']) && !empty($program['details'])): ?>
                                    <ul class="program-details">
                                        <?php foreach ($program['details'] as $detail): ?>
                                            <li><?php echo htmlspecialchars($detail); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php if (isset($program['duration']) || isset($program['start_date'])): ?>
                                    <div class="program-meta">
                                        <?php if (isset($program['duration'])): ?>
                                            <span class="duration">
                                                <i class="icon">⏱</i>
                                                <?php echo htmlspecialchars($program['duration']); ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if (isset($program['start_date'])): ?>
                                            <span class="start-date">
                                                <i class="icon">📅</i>
                                                <?php echo htmlspecialchars($program['start_date']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($program['link'])): ?>
                                    <a href="<?php echo htmlspecialchars($program['link']); ?>" 
                                       class="program-link">
                                        [translate key="learn_more_button" lang="en"]
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($educationData['cta'])): ?>
                <div class="education-cta">
                    <h3><?php echo htmlspecialchars($educationData['cta']['title']); ?></h3>
                    <p><?php echo htmlspecialchars($educationData['cta']['description']); ?></p>
                    <a href="<?php echo htmlspecialchars($educationData['cta']['link']); ?>" 
                       class="cta-button">
                        <?php echo htmlspecialchars($educationData['cta']['button_text']); ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p class="no-education">[translate key="education_not_available" lang="en"]</p>
        <?php endif; ?>
    </div>
</section>
