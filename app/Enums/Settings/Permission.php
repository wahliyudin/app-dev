<?php

namespace App\Enums\Settings;

enum Permission: string 
{
    case DASHBOARD_DASHBOARD_READ = 'dashboard_dashboard_read';
    case REQUEST_CREATE = 'request_create';
    case REQUEST_READ = 'request_read';
    case REQUEST_UPDATE = 'request_update';
    case REQUEST_DELETE = 'request_delete';
    case REQUEST_APPROVE = 'request_approve';
    case REQUEST_REJECT = 'request_reject';
    case APPLICATION_TASK_CREATE = 'application_task_create';
    case APPLICATION_TASK_READ = 'application_task_read';
    case APPLICATION_TASK_UPDATE = 'application_task_update';
    case APPLICATION_TASK_DELETE = 'application_task_delete';
    case APPLICATION_FEATURE_CREATE = 'application_feature_create';
    case APPLICATION_FEATURE_READ = 'application_feature_read';
    case APPLICATION_FEATURE_UPDATE = 'application_feature_update';
    case APPLICATION_FEATURE_DELETE = 'application_feature_delete';
    case APPLICATION_FILE_READ = 'application_file_read';
    case APPLICATION_DEVELOPER_CREATE = 'application_developer_create';
    case APPLICATION_DEVELOPER_READ = 'application_developer_read';
    case APPLICATION_DEVELOPER_UPDATE = 'application_developer_update';
    case APPLICATION_DEVELOPER_DELETE = 'application_developer_delete';
    case APPLICATION_SETTING_READ = 'application_setting_read';
    case APPLICATION_SETTING_UPDATE = 'application_setting_update';
    case SETTING_APPROVAL_CREATE = 'setting_approval_create';
    case SETTING_APPROVAL_READ = 'setting_approval_read';
    case SETTING_APPROVAL_UPDATE = 'setting_approval_update';
    case SETTING_APPROVAL_DELETE = 'setting_approval_delete';
    case SETTING_ACCESS_PERMISSION_READ = 'setting_access_permission_read';
    case SETTING_ACCESS_PERMISSION_UPDATE = 'setting_access_permission_update';
}
