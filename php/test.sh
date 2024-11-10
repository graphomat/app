#!/bin/bash

# Help function
show_help() {
    echo "Usage: $0 [option]"
    echo "Options:"
    echo "  --components  Test only components"
    echo "  --sections    Test only sections"
    echo "  --schema      Test for duplicate tables and columns in schema files"
    echo "  --help        Show this help message"
    echo "  (no option)   Test everything"
    echo ""
    echo "Description:"
    echo "  This script runs diagnostic tests on the application:"
    echo "  - Components: Checks for required files and syntax"
    echo "  - Sections: Verifies section structure and SQL validity"
    echo "  - Schema: Detects duplicate table/column definitions"
    echo ""
    echo "Examples:"
    echo "  $0              # Run all tests"
    echo "  $0 --schema     # Check for schema duplicates"
    echo "  $0 --sections   # Test only sections"
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
    --schema)
        TEST_TYPE="schema"
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
