#!/bin/bash

# Define TLTC logo ASCII art
logo='

--  _________  ___   _________  ________     
-- |\___   ___\\  \ |\___   ___\\   ____\ Bash Script Owner - Pnone Htut Khaung
-- \|___ \  \_\ \  \\|___ \  \_\ \  \___|    
--      \ \  \ \ \  \    \ \  \ \ \  \      Created Date - 4.14.2024
--       \ \  \ \ \  \____\ \  \ \ \  \____  
--        \ \__\ \ \_______\ \__\ \ \_______\  Company - Technology Learn
--         \|__|  \|_______|\|__|  \|_______|

'

# Welcome message
welcome_message="   Welcome to TLTC Script!

"

# Database credentials
DB_USER="root"
DB_PASS="password"
DB_NAME="school"

# Member SCript Start

# Add Member
create_member() {
    read -p "Enter name: " name
    read -p "Enter email: " email
    read -p "Enter password: " -s password
    password_md5=$(echo -n "$password" | md5sum | awk '{print $1}')
    read -p "Enter role (server_admin/social_team/developer): " role
    read -p "Enter status (active/inactive): " status
    mysql -u$DB_USER -p$DB_PASS -D$DB_NAME -e "INSERT INTO member (name, email, password, role, status) VALUES ('$name', '$email', '$password_md5', '$role', '$status');"

    # Check if insert was successful
    if [ $? -eq 0 ]; then
        echo "Record created successfully."
    else
        echo "Failed to create record."
    fi
}   


# Show member
read_member() {
    mysql -u$DB_USER -p$DB_PASS -D$DB_NAME -e "SELECT * FROM member;"
}


# Function to update a member
update_member() {
    read -p "Enter ID of the record to update: " id
    
    # Fetch current data
    current_data=$(mysql -u"$DB_USER" -p"$DB_PASS" -D"$DB_NAME" -N -B -e "SELECT * FROM member WHERE id=$id;")
    if [ -z "$current_data" ]; then
        echo "Record with ID $id not found."
        return
    fi
    
    # Display current data
    echo "Current Data:"
    echo "$current_data"
    
    # Prompt for new data
    read -p "Enter new name (or leave blank to keep current value): " name
    read -p "Enter new email (or leave blank to keep current value): " email
    read -p "Enter new password (or leave blank to keep current value): " "password"
    echo
    if [ -n "$password" ]; then
        password_md5=$(echo -n "$password" | md5sum | awk '{print $1}')
    fi
    read -p "Enter new role (or leave blank to keep current value): " role
    read -p "Enter new status (or leave blank to keep current value): " status
    
    # Prepare the update query
    set_clause=""
    if [ -n "$name" ]; then
        set_clause+="name='$name',"
    fi
    if [ -n "$email" ]; then
        set_clause+="email='$email',"
    fi
    if [ -n "$password_md5" ]; then
        set_clause+="password='$password_md5',"
    fi
    if [ -n "$role" ]; then
        set_clause+="role='$role',"
    fi
    if [ -n "$status" ]; then
        set_clause+="status='$status',"
    fi
    
    # Remove trailing comma
    set_clause=${set_clause%,}
    
    # If set_clause is empty, no changes were made, and there's no need to execute an update
    if [ -z "$set_clause" ]; then
        echo "No changes were made to the record."
        return
    fi
    
    # Construct the full query
    update_query="UPDATE member SET $set_clause WHERE id=$id;"
    
    # Execute the update query
    mysql -u"$DB_USER" -p"$DB_PASS" -D"$DB_NAME" -e "$update_query"
    
    # Check if the update was successful
    if [ $? -eq 0 ]; then
        echo "Record updated successfully."
    else
        echo "Failed to update record or no changes were made."
    fi
}

# Function to delete a member
delete_member() {
    read -p "Enter ID of the record to delete: " id

    # Fetch the member's name based on the provided ID
    member_name=$(mysql -u"$DB_USER" -p"$DB_PASS" -D"$DB_NAME" -N -B -e "SELECT name FROM member WHERE id=$id;")
    
    # Check if the member exists
    if [ -z "$member_name" ]; then
        echo "Record with ID $id not found."
        return
    fi
    
    # Prompt the user for confirmation
    echo "Are you sure you want to delete the record of $member_name? (yes/no)"
    read -p "Enter your choice: " choice
    
    # Check the user's choice
    if [ "$choice" = "yes" ]; then
        # Execute the delete query
        mysql -u"$DB_USER" -p -D"$DB_NAME" -e "DELETE FROM member WHERE id=$id;"
        
        # Check if the deletion was successful
        if [ $? -eq 0 ]; then
            echo "Record deleted successfully. $member_name"
        else
            echo "Failed to delete record."
        fi
    else
        echo "Deletion cancelled."
    fi
}


#Member Script End


# Login History Start

# Show Login History
read_login() {
    mysql -u$DB_USER -p$DB_PASS -D$DB_NAME -e "SELECT * FROM login_history;"
}

# Login History End


# Display TLTC logo and welcome message
echo "$logo"
echo "$welcome_message"

# Main menu function
main_menu() {
    while true; do
        # Display main menu
        echo ""
        echo ""
        echo "===== Main Menu =====

        "
        echo " ==== Member ====
        "
        echo "1) Create Admin"
        echo "2) Show All Admins"
        echo "3) Edit Admin"
        echo "4) Delete Admin"
        echo "
 ==== Login History ====
        "        
        echo "5) Show Login History"
        echo "q) Exit"
        echo ""
        
        # Prompt the user for their choice
        read -p "Enter your choice: " option
        echo ""
        echo ""
        
        # Handle the user's choice using a case statement
        case $option in
            1)
                create_member
                ;;
            2)
                read_member
                ;;
            3)
                update_member
                ;;
            4)
                delete_member
                ;;
            5)
                read_login
                ;;
            q)
                echo "Goodbye!"
                exit 0
                ;;
            *)
                echo "Invalid choice, please try again."
                ;;
        esac
    done
}

# Start the main menu
main_menu
