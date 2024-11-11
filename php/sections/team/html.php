<?php
$currentLang = $_GET['lang'] ?? 'en';
$teamMembers = $sectionData['team_members'] ?? [];
?>

<div class="team-section">
    <div class="container">
        <h2 class="section-title">
            [translate key="team_section_title" lang="<?php echo $currentLang; ?>"]
        </h2>

        <div class="section-description">
            [translate key="team_section_description" lang="<?php echo $currentLang; ?>"]
        </div>

        <div class="team-grid">
            <?php foreach ($teamMembers as $member): ?>
                <div class="team-member">
                    <?php if (!empty($member['photo'])): ?>
                        <div class="member-photo">
                            <img src="/<?php echo htmlspecialchars($member['photo']); ?>"
                                 alt="<?php echo htmlspecialchars($member['name']); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="member-info">
                        <h3 class="member-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                        <div class="member-position">
                            [translate key="team_position_<?php echo $member['position_key']; ?>" 
                                      lang="<?php echo $currentLang; ?>"]
                        </div>
                        <div class="member-bio">
                            [translate key="team_bio_<?php echo $member['bio_key']; ?>" 
                                      lang="<?php echo $currentLang; ?>"]
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
