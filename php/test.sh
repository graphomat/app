#!/bin/bash

# Help function
show_help() {
    echo "Usage: $0 [option]"
    echo "Options:"
    echo "  --components  Test only components"
    echo "  --sections    Test only sections"
    echo "  --help        Show this help message"
    echo "  (no option)   Test everything"
}

# Process arguments
case "$1" in
    --help)
        show_help
        exit 0
        ;;
    --components)
        TEST_TYPE="components"
        ;;
    --sections)
        TEST_TYPE="sections"
        ;;
    "")
        TEST_TYPE=""
        ;;
    *)
        echo "Unknown option: $1"
        show_help
        exit 1
        ;;
esac

# Run the tests
if [ -n "$TEST_TYPE" ]; then
    php test.php "$TEST_TYPE"
else
    php test.php
fi

# Store exit status
STATUS=$?

# If errors were found, they've been displayed by the PHP script
exit $STATUS
