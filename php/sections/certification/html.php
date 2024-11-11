<?php
$currentLang = $_GET['lang'] ?? 'en';
$certificationFile = $sectionData['certification_file'] ?? 'Cert_Unity_241108_073542.pdf';
?>

<div class="certification-section">
    <div class="container">
        <h2 class="section-title">
            [translate key="certification.section_title" lang="<?php echo $currentLang; ?>"]
        </h2>

        <div class="section-description">
            [translate key="certification.section_description" lang="<?php echo $currentLang; ?>"]
        </div>

        <div class="certification-content">
            <div class="certification-info">
                <div class="info-text">
                    [translate key="certification.info_text" lang="<?php echo $currentLang; ?>"]
                </div>
                
                <?php if (!empty($certificationFile)): ?>
                    <div class="certification-document">
                        <a href="<?php echo htmlspecialchars($certificationFile); ?>" 
                           class="cert-download-btn" 
                           target="_blank">
                            [translate key="certification.download_button" lang="<?php echo $currentLang; ?>"]
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="certification-badges">
                <?php if (!empty($sectionData['badges'])): ?>
                    <?php foreach ($sectionData['badges'] as $badge): ?>
                        <div class="badge-item">
                            <?php if (!empty($badge['icon'])): ?>
                                <img src="<?php echo htmlspecialchars($badge['icon']); ?>" 
                                     alt="<?php echo htmlspecialchars($badge['title']); ?>"
                                     class="badge-icon">
                            <?php endif; ?>
                            <h3 class="badge-title">
                                [translate key="certification.badge_<?php echo $badge['key']; ?>_title" 
                                          lang="<?php echo $currentLang; ?>"]
                            </h3>
                            <div class="badge-description">
                                [translate key="certification.badge_<?php echo $badge['key']; ?>_description" 
                                          lang="<?php echo $currentLang; ?>"]
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
