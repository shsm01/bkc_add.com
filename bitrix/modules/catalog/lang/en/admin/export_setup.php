<?
$MESS["CES_ERROR_NO_FILE"] = "Export file is not set.";
$MESS["CES_ERROR_NO_ACTION"] = "Action is not set.";
$MESS["CES_ERROR_FILE_NOT_EXIST"] = "Export file is not found:";
$MESS["CES_ERROR_NOT_AGENT"] = "This profile cannot be used for agents because it is used by default and a settings file is defined for the current exporter.";
$MESS["CES_ERROR_ADD_PROFILE"] = "Error adding profile.";
$MESS["CES_ERROR_NOT_CRON"] = "This profile cannot be used with cron because it is used by default and a settings file is defined for the current exporter.";
$MESS["CES_ERROR_ADD2CRON"] = "Error installing the configuration file with cron:";
$MESS["CES_ERROR_UNKNOWN"] = "unknown error.";
$MESS["CES_ERROR_NO_PROFILE1"] = "Profile #";
$MESS["CES_ERROR_NO_PROFILE2"] = "is not found.";
$MESS["CES_ERROR_SAVE_PROFILE"] = "Error saving export profile.";
$MESS["CES_ERROR_NO_SETUP_FILE"] = "Export setup file is not found.";
$MESS["TITLE_EXPORT_PAGE"] = "Export setup";
$MESS["CES_ERRORS"] = "Error while performing the operation:";
$MESS["CES_SUCCESS"] = "Operation successfully completed.";
$MESS["CES_EXPORT_FILE"] = "Export data file:";
$MESS["CES_EXPORTER"] = "Exporter";
$MESS["CES_ACTIONS"] = "Actions";
$MESS["CES_PROFILE"] = "Profile";
$MESS["CES_IN_MENU"] = "In menu";
$MESS["CES_IN_AGENT"] = "In agents";
$MESS["CES_IN_CRON"] = "On cron";
$MESS["CES_USED"] = "Last run";
$MESS["CES_ADD_PROFILE_DESCR"] = "Add new export profile";
$MESS["CES_ADD_PROFILE"] = "Add profile";
$MESS["CES_DEFAULT"] = "Default";
$MESS["CES_NO"] = "No";
$MESS["CES_YES"] = "Yes";
$MESS["CES_RUN_INTERVAL"] = "Period between launches (hours):";
$MESS["CES_SET"] = "Install";
$MESS["CES_DELETE"] = "Delete";
$MESS["CES_CLOSE"] = "Close";
$MESS["CES_OR"] = "or";
$MESS["CES_RUN_TIME"] = "Launch time:";
$MESS["CES_PHP_PATH"] = "Path to php:";
$MESS["CES_AUTO_CRON"] = "Set automatically:";
$MESS["CES_AUTO_CRON_DEL"] = "Delete automatically:";
$MESS["CES_RUN_EXPORT_DESCR"] = "Start data export";
$MESS["CES_RUN_EXPORT"] = "Export";
$MESS["CES_TO_LEFT_MENU_DESCR"] = "Add menu link in the left menu";
$MESS["CES_TO_LEFT_MENU_DESCR_DEL"] = "Delete menu link from the left menu";
$MESS["CES_TO_LEFT_MENU"] = "Add to menu";
$MESS["CES_TO_LEFT_MENU_DEL"] = "Delete from menu";
$MESS["CES_TO_AGENT_DESCR"] = "Create agent for automated launch";
$MESS["CES_TO_AGENT_DESCR_DEL"] = "Delete agent for automated launch";
$MESS["CES_TO_AGENT"] = "Create agent";
$MESS["CES_TO_AGENT_DEL"] = "Delete agent";
$MESS["CES_TO_CRON_DESCR"] = "Use cron for automated launch";
$MESS["CES_TO_CRON_DESCR_DEL"] = "Remove from cron";
$MESS["CES_TO_CRON"] = "Use cron";
$MESS["CES_TO_CRON_DEL"] = "Stop cron";
$MESS["CES_SHOW_VARS_LIST_DESCR"] = "Show variables list for this export profile";
$MESS["CES_SHOW_VARS_LIST"] = "Variables list";
$MESS["CES_DELETE_PROFILE_DESCR"] = "Delete this profile";
$MESS["CES_DELETE_PROFILE_CONF"] = "Are you sure you want to delete this profile?";
$MESS["CES_DELETE_PROFILE"] = "Delete profile";
$MESS["CES_NOTES1"] = "Agents are PHP functions which are run periodically at a given interval. Every time a page is requested, the system automatically checks for agents that need to be executed and runs them. It is not recommended to assign lengthy or large export jobs to agents. You should use the cron daemon for this purpose.";
$MESS["CES_NOTES2"] = "The cron daemon is only available on UNIX-based servers.";
$MESS["CES_NOTES3"] = "The cron daemon works in the background mode and runs the assigned tasks at the specified time. You need to specify the configuration file to add an export operation to the task list";
$MESS["CES_NOTES4"] = "in cron. This file contains instructions for the export operations . After you have changed the cron tasks set, you have to install the configuration file again.";
$MESS["CES_NOTES5"] = "To set the configuration file you have to connect to your site via the SSH or SSH2 or any other similar protocol that your provider supports for the shell remote operations . In command line, run the command";
$MESS["CES_NOTES6"] = "To view the list of currently installed tasks, run the command";
$MESS["CES_NOTES7"] = "To remove all tasks assigned to the cron, run the command";
$MESS["CES_NOTES8"] = "Current list of the cron tasks:";
$MESS["CES_NOTES10"] = "Attention! This will also remove any tasks not in the configuration file.";
$MESS["CES_NOTES11"] = "File that launches the export script for running the tasks with cron is";
$MESS["CES_NOTES12"] = "Please ensure this file contains correct paths to the PHP and site root";
$MESS["export_setup_cat"] = "Export scripts are located in the folder:";
$MESS["export_setup_script"] = "The export script";
$MESS["export_setup_name"] = "Name";
$MESS["export_setup_file"] = "File";
$MESS["export_setup_begin"] = "Start data export";
$MESS["CES_EDIT_PROFILE"] = "Edit";
$MESS["CES_EDIT_PROPFILE_DESCR"] = "Edit Profile";
$MESS["CES_EDIT_PROFILE_ERR_ID_ABSENT"] = "The profile ID is not specified.";
$MESS["CES_EDIT_PROFILE_ERR_DEFAULT"] = "The default profile cannot be modified.";
$MESS["CES_EDIT_PROFILE_ERR_ID_BAD"] = "Bad profile ID.";
$MESS["CES_ERROR_PROFILE_UPDATE"] = "Error updating the profile.";
$MESS["CES_COPY_PROFILE"] = "Copy";
$MESS["CES_COPY_PROPFILE_DESCR"] = "Copy Profile";
$MESS["CES_COPY_PROFILE_ERR_DEFAULT"] = "The default profile cannot be copied.";
$MESS["CES_ERROR_COPY_PROFILE"] = "Error copying the profile.";
$MESS["CES_NEED_EDIT"] = "the profile needs to be configured";
$MESS["CES_ERROR_BAD_FILENAME"] = "The import file name contains invalid characters.";
$MESS["CES_ERROR_BAD_FILENAME2"] = "The export script filename contains invalid characters.";
$MESS["CES_ERROR_BAD_EXPORT_FILENAME"] = "The export filename contains invalid characters.";
$MESS["CES_CREATED_BY"] = "Created by";
$MESS["CES_DATE_CREATE"] = "Created on";
$MESS["CES_MODIFIED_BY"] = "Modified by";
$MESS["CES_TIMESTAMP_X"] = "Modified on";
$MESS["CES_DEFAULT_PROFILE"] = "system";
$MESS["CES_CRON_AGENT_ERRORS"] = "The profiles are set to run using an agent and cron. It is not recommended to use both simultaneously.";
?>