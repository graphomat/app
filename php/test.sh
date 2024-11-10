#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

# Function to print section headers
print_header() {
    echo -e "\n${BLUE}=== $1 ===${NC}\n"
}

# Function to check if a command was successful
check_result() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓ $2 completed successfully${NC}"
        return 0
    else
        echo -e "${RED}✗ $2 failed${NC}"
        return 1
    fi
}

# Main testing sequence
echo -e "${BLUE}Starting test suite...${NC}"

# Initialize error counter
errors=0

# 1. Setup test environment
print_header "Setting up test environment"

# Create necessary directories
mkdir -p data uploads/documents uploads/images uploads/other
check_result $? "Create directories"

# Initialize database
if [ -f "data/database.sqlite" ]; then
    rm data/database.sqlite
fi

# Create database and set permissions
cat schema.sql | sqlite3 data/database.sqlite
chmod 666 data/database.sqlite
check_result $? "Initialize database"

# Make scripts executable
chmod +x api/tests/api_tests.sh
check_result $? "Make API tests executable"

# Kill any existing PHP server on port 8007
pkill -f "php -S localhost:8007" || true
sleep 1

# Start PHP development server in background
php -S localhost:8007 &
SERVER_PID=$!
sleep 2  # Give the server time to start
check_result $? "Start PHP server"

# 2. Create test user
print_header "Creating Test User"
php scripts/create_user.php --action=create --username=admin --password=admin123 --email=admin@example.com
check_result $? "Create test user"

# 3. Run API Tests
print_header "Running API Tests"
./api/tests/api_tests.sh
if ! check_result $? "API Tests"; then
    ((errors++))
fi

# 4. Run Admin Panel Tests
print_header "Running Admin Panel Tests"
if [ -f "vendor/bin/phpunit" ]; then
    ./vendor/bin/phpunit tests/Admin/AdminPanelTest.php
    if ! check_result $? "Admin Panel Tests"; then
        ((errors++))
    fi
else
    echo -e "${RED}PHPUnit not found. Please run 'composer install' first.${NC}"
    ((errors++))
fi

# Cleanup
kill $SERVER_PID
wait $SERVER_PID 2>/dev/null

# Final results
echo -e "\n${BLUE}=== Test Results ===${NC}"
if [ $errors -eq 0 ]; then
    echo -e "\n${GREEN}All tests completed successfully!${NC}"
    exit 0
else
    echo -e "\n${RED}Tests completed with $errors error(s)${NC}"
    exit 1
fi
