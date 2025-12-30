# End-to-End Testing Guide

This guide explains how to run end-to-end tests for R-WFW framework.

## Prerequisites

1. **PHP 8.4+** with extensions: curl, mysqli
2. **Composer** for dependency management
3. **Docker & Docker Compose** (recommended) or PHP built-in server
4. **MySQL database** (for full E2E testing)

## Setup

### 1. Install Dependencies
```bash
composer install
```

### 2. Start Application Server

#### Option A: Using Docker (Recommended)
```bash
# Start all services (app + database)
docker-compose up -d

# Wait for services to be ready
sleep 10

# Check if app is running
curl http://localhost:8090/
```

#### Option B: Using PHP Built-in Server
```bash
# Terminal 1: Start PHP server
cd public
php -S localhost:8090

# Terminal 2: Ensure database is running
# (Configure your local MySQL or use Docker for DB only)
docker run --name mysql-test -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=test -p 3306:3306 -d mysql:8.0
```

### 3. Configure Test Environment (Optional)
```bash
# Set custom base URL for tests
export TEST_BASE_URL=http://localhost:8090

# Or modify tests/E2E/ApiEndToEndTest.php directly
```

## Running E2E Tests

### Run All E2E Tests
```bash
./app/libraries/bin/phpunit --testsuite "E2E Tests"
```

### Run Specific E2E Test
```bash
./app/libraries/bin/phpunit tests/E2E/ApiEndToEndTest.php
```

### Run with Coverage
```bash
./app/libraries/bin/phpunit --testsuite "E2E Tests" --coverage-html coverage-e2e
```

### Run in Verbose Mode
```bash
./app/libraries/bin/phpunit --testsuite "E2E Tests" -v
```

## Test Categories

### ApiEndToEndTest
- Tests basic application availability
- Tests routing and HTTP responses
- Tests CORS and headers
- Tests error handling (404, 405)
- Tests response times

### MiddlewareEndToEndTest
- Tests middleware execution through HTTP requests
- Tests header manipulation
- Tests middleware chains

### DatabaseEndToEndTest
- Tests database connectivity through API
- Tests concurrent database access
- Tests transaction integrity
- Tests error handling when DB is unavailable

## Troubleshooting

### Application Not Running
```bash
# Check if Docker containers are running
docker ps

# Check application logs
docker logs r-wfw-web

# Test manual HTTP request
curl -I http://localhost:8090/
```

### Database Connection Issues
```bash
# Check database container
docker logs r-wfw-db

# Test database connection
docker exec -it r-wfw-db mysql -u root -p test
```

### Test Timeouts
- Increase timeout in test setup: `'timeout' => 30`
- Check server performance
- Ensure database is optimized

### Port Conflicts
- Change ports in docker-compose.yml
- Update TEST_BASE_URL accordingly

## CI/CD Integration

For automated testing in CI/CD pipelines:

```yaml
# .github/workflows/e2e.yml
name: E2E Tests
on: [push, pull_request]

jobs:
  e2e:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
      - name: Install dependencies
        run: composer install
      - name: Start services
        run: docker-compose up -d
      - name: Wait for services
        run: sleep 30
      - name: Run E2E tests
        run: ./app/libraries/bin/phpunit --testsuite "E2E Tests"
```

## Best Practices

1. **Isolate Test Data**: Use separate database/schema for E2E tests
2. **Clean Up**: Reset database state between test runs
3. **Parallel Execution**: Run E2E tests in parallel when possible
4. **Monitoring**: Monitor response times and failure rates
5. **Realistic Data**: Use realistic test data that matches production

## Performance Benchmarks

Typical E2E test execution times:
- ApiEndToEndTest: ~5-10 seconds
- MiddlewareEndToEndTest: ~3-5 seconds
- DatabaseEndToEndTest: ~10-20 seconds

Total E2E suite: ~20-40 seconds (depending on server performance)