# Contributing to Support Package

Thank you for considering contributing to the Support package! This document provides guidelines for contributing to the project.

## Code of Conduct

Be respectful and considerate of others. We aim to foster an inclusive and welcoming community.

## How to Contribute

### Reporting Bugs

If you find a bug, please create an issue on GitHub with:

1. A clear title and description
2. Steps to reproduce the issue
3. Expected vs actual behavior
4. Your environment (PHP version, Laravel version, Bagisto version)
5. Any relevant error messages or logs

### Suggesting Features

We welcome feature suggestions! Please create an issue with:

1. A clear description of the feature
2. Why you think it would be useful
3. How it should work (if you have ideas)

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Make your changes** following our coding standards
3. **Test your changes** thoroughly
4. **Update documentation** if needed
5. **Write or update tests** if applicable
6. **Create a pull request** with a clear description

## Development Setup

1. Clone your fork:
```bash
git clone https://github.com/your-username/support.git
cd support
```

2. Install dependencies:
```bash
composer install
```

3. Create a test Bagisto application to test the package locally

## Coding Standards

- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Add comments for complex logic
- Keep methods focused and small
- Use type hints for parameters and return types

## Testing

- Test all new features and bug fixes
- Ensure existing tests still pass
- Write integration tests for new features
- Test with different PHP and Laravel versions if possible

## Documentation

- Update README.md for significant changes
- Update INSTALLATION.md if installation steps change
- Add inline code comments for complex logic
- Update CHANGELOG.md following Keep a Changelog format

## Commit Messages

Write clear commit messages:

```
Add feature: brief description

More detailed explanation of what changed and why,
if necessary.
```

Good examples:
- `Fix bug in ticket assignment logic`
- `Add support for custom email templates`
- `Update documentation for Slack integration`

## Branch Naming

Use descriptive branch names:
- `feature/add-custom-fields`
- `bugfix/fix-email-notifications`
- `docs/update-installation-guide`

## Review Process

1. A maintainer will review your pull request
2. Address any requested changes
3. Once approved, your PR will be merged

## Getting Help

If you need help or have questions:
- Open an issue on GitHub
- Check existing issues and documentation
- Email: kevin.b.harris.2015@gmail.com

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

Thank you for contributing! 🎉
