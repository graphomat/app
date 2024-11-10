#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

#PATHH=/var/www/html
PATHH=$(pwd)
#echo ${PATHH}
HOSTNAME=localhost
PORT=8007


echo -e "${GREEN}Starting Graphomat installation...${NC}"

# Function to check command status
check_status() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ $1 successful${NC}"
    else
        echo -e "${RED}✗ $1 failed${NC}"
        exit 1
    fi
}

# Create necessary directories
echo -e "\n${YELLOW}Creating necessary directories...${NC}"
mkdir -p data
mkdir -p uploads/documents uploads/images uploads/other
check_status "Directory creation"

# Set permissions
echo -e "\n${YELLOW}Setting permissions...${NC}"
chmod -R 755 data uploads
chmod 777 data # Ensure database directory is writable
check_status "Permission setup"

# Copy environment file if it doesn't exist
echo -e "\n${YELLOW}Setting up environment configuration...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    check_status "Environment file creation"
    
    # Generate random string for APP_KEY
    RANDOM_KEY=$(openssl rand -base64 32)
    sed -i "s/APP_KEY=.*/APP_KEY=$RANDOM_KEY/" .env
    
    # Update paths for local development
    sed -i "s|${PATHH}/${DB_PATH}|${DB_PATH}|g" .env
    sed -i "s|${PATHH}/uploads|uploads|g" .env
fi

# Load Variables
source .env

# Initialize database
echo -e "\n${YELLOW}Initializing database...${NC}"
if [ -f ${DB_SCHEMA} ]; then
    if [ ! -f ${DB_PATH} ]; then
        sqlite3 ${DB_PATH} < ${DB_SCHEMA}
        check_status "Database initialization"
        chmod 666 ${DB_PATH} # Ensure database file is writable
    else
        echo -e "${RED}Database already exists, skipping initialization${NC}"
    fi
else
    echo -e "${RED}Schema file not found. Please make sure schema.sql exists.${NC}"
    exit 1
fi


# Security reminder
echo -e "\n${YELLOW}Post-installation security steps:${NC}"
echo "1. Set secure values for SESSION_LIFETIME and COOKIE_LIFETIME in .env"
echo "2. Configure proper mail settings in .env if needed"
echo "3. Set APP_DEBUG=false in production"

# Default credentials reminder
echo -e "\n${YELLOW}Default admin credentials:${NC}"
echo "Username: admin"
echo "Password: admin123"
echo -e "${RED}IMPORTANT: Please change the default admin password immediately!${NC}"


# Check if Docker is available
if command -v docker &> /dev/null && command -v docker-compose &> /dev/null; then
    echo -e "\n${YELLOW}Docker detected. Do you want to use Docker? (y/n)${NC}"
    read -r use_docker
    
    if [[ $use_docker =~ ^[Yy]$ ]]; then
        # Docker setup
        echo -e "\n${YELLOW}Building and starting Docker containers...${NC}"
        docker-compose up -d --build
        check_status "Docker container setup"
        
        echo -e "\n${GREEN}Installation completed successfully!${NC}"
        echo -e "You can access the application at: http://${HOSTNAME}:${PORT}"
    else
        # Local PHP setup
        echo -e "\n${YELLOW}Starting PHP development server...${NC}"
        echo -e "You can access the application at: http://${HOSTNAME}:${PORT}"
        echo -e "Press Ctrl+C to stop the server"
        php -S ${HOSTNAME}:${PORT}
    fi
else
    # Local PHP setup
    echo -e "\n${YELLOW}Starting PHP development server...${NC}"
    echo -e "You can access the application at: http://${HOSTNAME}:${PORT}"
    echo -e "Press Ctrl+C to stop the server"
    php -S ${HOSTNAME}:${PORT}
fi
