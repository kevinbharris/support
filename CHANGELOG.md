# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Removed - BREAKING CHANGE
- **Complete ACL (Access Control List) integration removed**
- Removed all ACL documentation files (ACL.md, ACL_QUICKSTART.md, ACL_IMPLEMENTATION.md, MAINTAINERS_ACL.md)
- Removed ACL example file (examples/blade-acl-examples.blade.php)
- Removed ACL config file (src/Config/acl.php)
- Removed ACL translation file (src/Resources/lang/en/acl.php)
- Removed all Policy classes (AttachmentPolicy, CannedResponsePolicy, CategoryPolicy, NotePolicy, PriorityPolicy, RulePolicy, StatusPolicy, TicketPolicy)
- Removed AuthServiceProvider (src/Providers/AuthServiceProvider.php)
- Removed SupportPermission middleware (src/Http/Middleware/SupportPermission.php)
- Removed SupportPermissionsSeeder (src/Database/Seeders/SupportPermissionsSeeder.php)
- Removed permission middleware from all admin routes
- Removed permission keys from menu configuration
- Removed ACL-related sections from README.md
- Removed empty examples directory

### Changed
- Updated SupportServiceProvider to remove ACL configuration merging and middleware registration
- Updated admin routes to remove all permission middleware checks
- Updated menu configuration to remove permission-based visibility
- All admin routes now only require standard Bagisto admin authentication
- Package restored to simple contact form and mini helpdesk without role/permission management

### Migration Notes
- See [ROLLBACK_GUIDE.md](ROLLBACK_GUIDE.md) for detailed server upgrade instructions
- All database tables remain unchanged
- Existing tickets, statuses, priorities, categories, and other data are preserved
- Old ACL permissions in Bagisto's roles table will remain but are not used
- Run `composer update kevinbharris/support` and clear all Laravel caches

## [1.0.0] - 2025-01-01

### Added
- Initial release of Support package for Bagisto v2.3.5
- Complete ticket management system with CRUD operations
- Status management (new, open, resolved, closed)
- Priority management (low, medium, high, urgent)
- Category management
- Internal and public notes with email notifications
- File attachment support for tickets and notes
- Watcher system for ticket notifications
- Advanced filtering (by status, priority, category, assignee, search)
- Bulk actions on tickets (delete, update status, update priority, assign)
- Canned response system for quick replies
- SLA timestamp tracking with automatic due date calculation
- Activity log for tracking all ticket changes
- Automation rules system
- Slack webhook integration for notifications
- Token-based customer portal (no login required)
- Customer contact form for submitting tickets
- Email notifications for ticket creation, updates, and notes
- Comprehensive documentation with README and INSTALLATION guide
- MIT License

### Features
- 10 Eloquent models with full relationships
- 6 admin controllers with complete CRUD operations
- 1 portal controller for customer access
- 10 database migrations
- 3 events (TicketCreated, TicketUpdated, NoteAdded)
- 3 listeners for event handling
- 3 mail classes (TicketCreatedMail, TicketUpdatedMail, NoteAddedMail)
- 19 admin Blade views
- 2 portal Blade views
- 3 email Blade views
- SlackService for webhook integration
- Configurable SLA times per priority level
- Configurable email settings
- Configurable attachment settings

### Technical Details
- PHP 8.1+ support
- Laravel 10.x compatibility
- Bagisto 2.3.5 integration
- PSR-4 autoloading
- Service provider auto-discovery
- Publishable configuration and views
- Migration support
- Event-driven architecture

[1.0.0]: https://github.com/kevinbharris/support/releases/tag/v1.0.0
