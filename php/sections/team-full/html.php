<?php
$currentLang = $_GET['lang'] ?? 'en';
$teamMembers = $sectionData['team_members'] ?? [];
?>

<div class="team-full-section">
    <div class="container">
        <h2 class="section-title">
            [translate key="team_full_section_title" lang="<?php echo $currentLang; ?>"]
        </h2>

        <div class="section-description">
            [translate key="team_full_section_description" lang="<?php echo $currentLang; ?>"]
        </div>

        <div class="team-full-grid">
            <?php foreach ($teamMembers as $member): ?>
                <div class="team-member-full">
                    <div class="member-header">
                        <?php if (!empty($member['photo'])): ?>
                            <div class="member-photo">
                                <img src="<?php echo htmlspecialchars($member['photo']); ?>" 
                                     alt="<?php echo htmlspecialchars($member['name']); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="member-title-info">
                            <h3 class="member-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                            <div class="member-position">
                                [translate key="team_position_<?php echo $member['position_key']; ?>" 
                                          lang="<?php echo $currentLang; ?>"]
                            </div>
                            <?php if (!empty($member['credentials'])): ?>
                                <div class="member-credentials">
                                    <?php echo htmlspecialchars($member['credentials']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="member-content">
                        <div class="member-bio-full">
                            [translate key="team_bio_full_<?php echo $member['bio_key']; ?>" 
                                      lang="<?php echo $currentLang; ?>"]
                        </div>
                        
                        <?php if (!empty($member['specialties'])): ?>
                            <div class="member-specialties">
                                <h4>[translate key="team_specialties_title" lang="<?php echo $currentLang; ?>"]</h4>
                                <ul>
                                    <?php foreach ($member['specialties'] as $specialty): ?>
                                        <li>
                                            [translate key="team_specialty_<?php echo $specialty; ?>" 
                                                      lang="<?php echo $currentLang; ?>"]
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($member['education'])): ?>
                            <div class="member-education">
                                <h4>[translate key="team_education_title" lang="<?php echo $currentLang; ?>"]</h4>
                                <ul>
                                    <?php foreach ($member['education'] as $edu): ?>
                                        <li><?php echo htmlspecialchars($edu); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($member['publications'])): ?>
                            <div class="member-publications">
                                <h4>[translate key="team_publications_title" lang="<?php echo $currentLang; ?>"]</h4>
                                <ul>
                                    <?php foreach ($member['publications'] as $pub): ?>
                                        <li><?php echo htmlspecialchars($pub); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
