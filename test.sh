#!/bin/bash

# Define your server details
SERVER_USERNAME="technologylearn"
SERVER_IP="85.190.254.166"
SSH_KEY_PATH="/home/phk/.ssh/id_rsa"

# Function to display the admin dashboard menu
dashboard_menu() {
    echo "Admin Dashboard Management Menu:"
    echo "1. View Dashboard Stats"
    echo "2. Update User Information"
    echo "3. Generate Report"
    echo "4. Exit"
}

# Function to view dashboard stats remotely over SSH
view_dashboard_stats() {
    echo "Fetching dashboard stats remotely..."
    ssh -i $SSH_KEY_PATH $SERVER_USERNAME@$SERVER_IP "echo 'Dashboard stats:' && cat /home/technologylearn/public_html/500.php"
}

# Function to update user information on the dashboard remotely over SSH
update_user_info() {
    echo "Updating user information remotely..."
    ssh -i $SSH_KEY_PATH $SERVER_USERNAME@$SERVER_IP "sudo /path/to/update_user_info_script.sh"
    echo "User information updated."
}

# Function to generate a report on the dashboard remotely over SSH
generate_report() {
    echo "Generating report remotely..."
    ssh -i $SSH_KEY_PATH $SERVER_USERNAME@$SERVER_IP "/path/to/generate_report_script.sh"
    echo "Report generated."
}

# Main menu loop
while true; do
    dashboard_menu
    read -p "Enter your choice: " choice

    case $choice in
        1)
            view_dashboard_stats
            ;;
        2)
            update_user_info
            ;;
        3)
            generate_report
            ;;
        4)
            echo "Exiting."
            exit 0
            ;;
        *)
            echo "Invalid choice. Please enter a number between 1 and 4."
            ;;
    esac
done
