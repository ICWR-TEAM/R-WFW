# Environment Configuration

R-WFW uses environment variables for configuration management, providing better security and flexibility across different deployment environments.

## Setup

1. Copy the example environment file:
   ```bash
   cp .env.example .env
   ```

2. Edit `.env` with your specific configuration values.

## Configuration Variables

### Application Settings
- `DEV_MODE=true|false` - Enable development mode for debugging
- `DB_USE=true|false` - Enable/disable database connections
- `ALLOW_ALL_CORS=true|false` - Allow all CORS origins (use with caution)

### Security Settings
- `ALL_SECURITY_HEADERS=true|false` - Enable comprehensive security headers
- `ANTI_XSS=true|false` - Enable XSS protection
- `SECRET_KEY_JWT=your_secret_key` - JWT signing secret (change in production)

### File Paths
- `SIGNATURE_PRIVATE_KEY=../data/signature/private_key.pem` - Private key file path
- `SIGNATURE_PUBLIC_KEY=../data/signature/public_key.pem` - Public key file path

### Database Configuration
- `BASEURL=https://yourdomain.com` - Application base URL
- `DB_HOST=localhost` - Database server hostname
- `DB_USER=username` - Database username
- `DB_PASS=password` - Database password
- `DB_NAME=database_name` - Database name

### Development Database (Optional)
- `DEV_BASEURL=http://localhost:8090` - Development base URL
- `DEV_DB_HOST=db` - Development database host
- `DEV_DB_USER=root` - Development database user
- `DEV_DB_PASS=root` - Development database password
- `DEV_DB_NAME=test` - Development database name

## Environment-Specific Configuration

### Development
```bash
DEV_MODE=true
DB_USE=false
ALLOW_ALL_CORS=true
ALL_SECURITY_HEADERS=false
ANTI_XSS=false
```

### Production
```bash
DEV_MODE=false
DB_USE=true
ALLOW_ALL_CORS=false
ALL_SECURITY_HEADERS=true
ANTI_XSS=true
SECRET_KEY_JWT=your_production_secret_key_here
```

## Security Best Practices

1. **Never commit `.env` to version control**
2. **Use strong, unique secrets for JWT**
3. **Restrict CORS in production**
4. **Enable all security features in production**
5. **Use environment-specific database credentials**
6. **Regularly rotate secrets and keys**

## Docker Integration

When using Docker, the `.env` file is automatically mounted into the container. Make sure your `docker-compose.yml` includes:

```yaml
volumes:
  - ./.env:/var/www/.env
```

## Troubleshooting

### Configuration Not Loading
- Ensure `.env` file exists in project root
- Check file permissions (readable by web server)
- Verify environment variable names match exactly
- Check PHP error logs for parsing issues

### Database Connection Issues
- Verify `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` are correct
- Ensure database server is running and accessible
- Check network connectivity in Docker environments

### Security Headers Not Working
- Confirm `ALL_SECURITY_HEADERS=true`
- Check that middleware is properly loaded
- Verify no conflicting headers from other sources