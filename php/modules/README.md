# Independent Modules

This directory contains standalone modules that can be integrated into the main application. Each module is self-contained with its own configuration, templates, and database schema.

## Available Modules

### Blog Module
Location: `/modules/blog`
- Complete blogging functionality
- Templates for list and single post views
- Admin interface for post management
- Database schema for posts

### RSS Module
Location: `/modules/rss`
- RSS feed generation
- Feed configuration management
- Admin interface for feed settings
- Database schema for feed entries

### Sitemap Module
Location: `/modules/sitemap`
- XML sitemap generation
- Automatic URL management
- Admin interface for sitemap settings
- Database schema for sitemap entries

## Integration

Each module contains:
- `html.php` - Frontend templates and display logic
- `query.php` - Database queries and data handling
- `admin.php` - Admin panel interface
- `schema.sql` - Module-specific database schema

The main database schema for all modules is located in `/modules/schema.sql`
