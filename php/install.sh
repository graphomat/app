#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}Starting Graphomat installation...${NC}"

# Check if running with root privileges
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root or with sudo${NC}"
    exit 1
fi

# Function to check command status
check_status() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ $1 successful${NC}"
    else
        echo -e "${RED}✗ $1 failed${NC}"
        exit 1
    fi
}

# Check requirements
echo -e "\n${YELLOW}Checking requirements...${NC}"

# Check Docker
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Docker is not installed. Installing Docker...${NC}"
    curl -fsSL https://get.docker.com -o get-docker.sh
    sh get-docker.sh
    check_status "Docker installation"
    rm get-docker.sh
fi

# Check Docker Compose
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}Docker Compose is not installed. Installing Docker Compose...${NC}"
    curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
    check_status "Docker Compose installation"
fi

# Create necessary directories
echo -e "\n${YELLOW}Creating necessary directories...${NC}"
mkdir -p data
mkdir -p uploads/documents uploads/images uploads/other
check_status "Directory creation"

# Set permissions
echo -e "\n${YELLOW}Setting permissions...${NC}"
chown -R www-data:www-data data uploads
chmod -R 755 data uploads
check_status "Permission setup"

# Copy environment file if it doesn't exist
echo -e "\n${YELLOW}Setting up environment configuration...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    check_status "Environment file creation"
    
    # Generate random string for APP_KEY
    RANDOM_KEY=$(openssl rand -base64 32)
    sed -i "s/APP_KEY=.*/APP_KEY=$RANDOM_KEY/" .env
fi

# Initialize database
echo -e "\n${YELLOW}Initializing database...${NC}"
if [ -f ../schema.sql ]; then
    mkdir -p data
    sqlite3 data/database.sqlite < ../schema.sql
    check_status "Database initialization"
else
    echo -e "${RED}Schema file not found. Please make sure schema.sql exists.${NC}"
    exit 1
fi

# Build and start Docker containers
echo -e "\n${YELLOW}Building and starting Docker containers...${NC}"
docker-compose up -d --build
check_status "Docker container setup"

# Create default admin user
echo -e "\n${YELLOW}Creating default admin user...${NC}"
docker-compose exec web php api/scripts/create_user.php --action=create --username=admin --password=admin123
check_status "Admin user creation"

# Final checks
echo -e "\n${YELLOW}Performing final checks...${NC}"
if docker-compose ps | grep -q "Up"; then
    echo -e "${GREEN}✓ Docker containers are running${NC}"
else
    echo -e "${RED}✗ Docker containers failed to start${NC}"
    exit 1
fi

# Installation complete
echo -e "\n${GREEN}Installation completed successfully!${NC}"
echo -e "\n${YELLOW}Default admin credentials:${NC}"
echo "Username: admin"
echo "Password: admin123"
echo -e "${RED}IMPORTANT: Please change the default admin password immediately!${NC}"
echo -e "\nYou can access the application at: http://localhost:8080"
echo "Admin panel: http://localhost:8080/admin"

# Security reminder
echo -e "\n${YELLOW}Post-installation security steps:${NC}"
echo "1. Change the default admin password"
echo "2. Update the APP_KEY in .env"
echo "3. Set secure values for SESSION_LIFETIME and COOKIE_LIFETIME in .env"
echo "4. Configure proper mail settings in .env if needed"
echo "5. Set APP_DEBUG=false in production"
