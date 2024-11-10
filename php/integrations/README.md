# Integrations System

This system provides powerful integration capabilities through shortcodes, webhooks, and API endpoints that can be used within sections.

## Shortcodes

Shortcodes allow you to embed dynamic content in your sections. They are processed at runtime and converted to HTML.

### YouTube Example
```php
// In your section content:
[youtube id="VIDEO_ID" width="560" height="315" autoplay="0" controls="1"]

// Register new shortcode:
class MyShortcode {
    public static function register() {
        ShortcodeProcessor::register('my-shortcode', [self::class, 'render']);
    }

    public static function render($attrs) {
        // Process attributes and return HTML
        return '<div>...</div>';
    }
}
```

### Translation Example
```php
// In your section content:
[translate key="welcome_message" lang="es"]

// Will be replaced with translation from database
```

## Webhooks

Webhooks allow external services to receive notifications about content changes.

### Content Update Example
```php
// In your section's query.php:
WebhookProcessor::trigger('content.updated', [
    'content_id' => $contentId,
    'content_type' => 'section',
    'section' => $sectionName,
    'user_id' => $currentUserId,
    'changes' => [
        'title' => [
            'old' => $oldTitle,
            'new' => $newTitle
        ]
    ]
]);

// Configure webhook URL in admin panel:
// Settings -> Integrations -> Webhooks
// Add URL: https://api.example.com/webhooks/content-updates
```

## API Endpoints

The API system allows sections to expose and consume data through REST endpoints.

### Translation API Example
```php
// Get translations:
GET /api/translations?lang=es&type=section&content_id=123

// Create translation:
POST /api/translations
{
    "language_code": "es",
    "content_type": "section", 
    "content_id": 123,
    "field_name": "title",
    "translation": "¡Bienvenidos!"
}

// Update translation:
PUT /api/translations/456
{
    "translation": "¡Hola Mundo!"
}

// Headers required:
X-API-Key: your_api_key_here
Content-Type: application/json
```

## Using in Sections

### Example: Multilingual Video Section

```php
// In section's html.php:
<div class="video-section">
    <h2>[translate key="video_title" lang="<?php echo $currentLang; ?>"]</h2>
    <div class="video">
        [youtube id="<?php echo $videoId; ?>" width="800" height="450"]
    </div>
    <p>[translate key="video_description" lang="<?php echo $currentLang; ?>"]</p>
</div>

// In section's query.php:
$videoId = $_POST['video_id'] ?? null;
if ($videoId) {
    // Update video ID in database
    // Then trigger webhook
    WebhookProcessor::trigger('content.updated', [
        'content_id' => $sectionId,
        'content_type' => 'section',
        'section' => 'video',
        'user_id' => $currentUserId,
        'changes' => [
            'video_id' => [
                'old' => $oldVideoId,
                'new' => $videoId
            ]
        ]
    ]);
}
```

## Database Schema

The integrations system uses the following tables:

### Languages & Translations
```sql
CREATE TABLE languages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(5) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    is_default BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    language_id INT NOT NULL,
    content_type VARCHAR(50) NOT NULL,
    content_id INT NOT NULL,
    field_name VARCHAR(50) NOT NULL,
    translation TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (language_id) REFERENCES languages(id),
    UNIQUE KEY unique_translation (language_id, content_type, content_id, field_name)
);
```

### Webhooks
```sql
CREATE TABLE webhooks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL,
    events JSON NOT NULL,
    secret_key VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_triggered TIMESTAMP NULL
);
```

### API Keys
```sql
CREATE TABLE api_keys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    api_key VARCHAR(255) NOT NULL UNIQUE,
    permissions JSON NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_used TIMESTAMP NULL
);
