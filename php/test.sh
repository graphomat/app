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

# Function to wait for server
wait_for_server() {
    local max_attempts=30
    local attempt=1
    local url="$1"
    
    echo "Waiting for server to start..."
    while [ $attempt -le $max_attempts ]; do
        if curl -s "$url" > /dev/null; then
            echo "Server is up!"
            return 0
        fi
        echo "Attempt $attempt of $max_attempts..."
        sleep 1
        ((attempt++))
    done
    echo "Server failed to start"
    return 1
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

# Initialize main database
if [ -f "data/database.sqlite" ]; then
    rm data/database.sqlite
fi

# Create main database and set permissions
cat schema.sql | sqlite3 data/database.sqlite
chmod 666 data/database.sqlite

# Initialize admin database
if [ -f "admin/admin.sqlite" ]; then
    rm admin/admin.sqlite
fi

# Create admin database and set permissions
cat admin/schema.sql | sqlite3 admin/admin.sqlite
chmod 666 admin/admin.sqlite
check_result $? "Initialize database"

# Make scripts executable
chmod +x api/tests/api_tests.sh
check_result $? "Make API tests executable"

# Kill any existing PHP server on port 8007
pkill -f "php -S localhost:8007" || true
sleep 2

# Start PHP development server in background
php -S localhost:8007 > /dev/null 2>&1 &
SERVER_PID=$!

# Wait for server to be ready
if wait_for_server "http://localhost:8007"; then
    check_result 0 "Start PHP server"
else
    check_result 1 "Start PHP server"
    exit 1
fi

# 2. Create test user
print_header "Creating Test User"
php admin/scripts/create_user.php
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
if [ ! -z "$SERVER_PID" ]; then
    kill $SERVER_PID
    wait $SERVER_PID 2>/dev/null || true
fi

# Final results
echo -e "\n${BLUE}=== Test Results ===${NC}"
if [ $errors -eq 0 ]; then
    echo -e "\n${GREEN}All tests completed successfully!${NC}"
    exit 0
else
    echo -e "\n${RED}Tests completed with $errors error(s)${NC}"
    exit 1
fi
