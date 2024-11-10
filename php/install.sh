#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Starting installation...${NC}"

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo -e "${RED}PHP is not installed. Please install PHP and try again.${NC}"
    exit 1
fi

# Create necessary directories if they don't exist
echo "Creating necessary directories..."
mkdir -p uploads/images
mkdir -p uploads/documents
mkdir -p uploads/other

# Set proper permissions
echo "Setting permissions..."
chmod -R 755 .
chmod -R 777 uploads
find . -type f -name "*.php" -exec chmod 644 {} \;
find . -type f -name "*.sh" -exec chmod 755 {} \;

# Copy .env.example to .env if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}Created .env file${NC}"
    else
        echo -e "${RED}Failed to create .env file${NC}"
        exit 1
    fi
fi

rm database.sqlite

# Run the PHP installer
echo "Running database installation..."
INSTALL_RESULT=$(php install.php)

# Check if the installation was successful
if echo "$INSTALL_RESULT" | grep -q '"success":true'; then
    echo -e "${GREEN}Installation completed successfully!${NC}"
else
    echo -e "${RED}Installation failed with errors:${NC}"
    echo "$INSTALL_RESULT" | php -r 'echo json_decode(file_get_contents("php://stdin"), true)["errors"][0];'
    exit 1
fi

# Create admin user if it doesn't exist
echo "Checking admin user..."
php scripts/create_user.php

echo -e "${GREEN}Installation completed!${NC}"
echo -e "${YELLOW}Please ensure your web server has proper permissions to write to the uploads directory.${NC}"
echo -e "${YELLOW}You can now log in to the admin panel with the default credentials:${NC}"
echo "Username: admin"
echo "Password: admin123"
echo -e "${RED}IMPORTANT: Please change the default password after your first login!${NC}"


# Load Variables
source .env
PATHH=$(pwd)
#echo ${PATHH}



# Local PHP setup
echo -e "\n${YELLOW}Starting PHP development server...${NC}"
echo -e "You can access the application at: http://${HOSTNAME}:${PORT}"
echo -e "Press Ctrl+C to stop the server"
php -S ${HOSTNAME}:${PORT}