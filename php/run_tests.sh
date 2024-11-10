#!/bin/bash

# Make sure containers are up
docker-compose up -d

# Wait for web service to be ready
echo "Waiting for web service to be ready..."
sleep 5

# Run the tests inside the container
docker-compose exec web ./vendor/bin/phpunit --testdox

# Show the test results in a more readable format
echo "Test execution completed."
