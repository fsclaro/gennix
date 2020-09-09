<?php

// Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push(__('gennix.breadcrumbs.dashboard'), route('home'));
});

// Dashboard > Activity
Breadcrumbs::for('activity', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('gennix.breadcrumbs.activity'), route('activity.index'));
});

// Dashboard > Activity > Details
Breadcrumbs::for('activity_show', function ($trail) {
    $trail->parent('activity');
    $trail->push(__('gennix.breadcrumbs.details'));
});

// Dashboard > Permission
Breadcrumbs::for('permission', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('gennix.breadcrumbs.permission'), route('permission.index'));
});

// Dashboard > Permission > Details
Breadcrumbs::for('permission_show', function ($trail) {
    $trail->parent('permission');
    $trail->push(__('gennix.breadcrumbs.details'));
});

// Dashboard > Permission > Create
Breadcrumbs::for('permission_create', function ($trail) {
    $trail->parent('permission');
    $trail->push(__('gennix.breadcrumbs.create'));
});

// Dashboard > Permission > Edit
Breadcrumbs::for('permission_edit', function ($trail) {
    $trail->parent('permission');
    $trail->push(__('gennix.breadcrumbs.edit'));
});


// Dashboard > Role
Breadcrumbs::for('role', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('gennix.breadcrumbs.role'), route('role.index'));
});

// Dashboard > Role > Details
Breadcrumbs::for('role_show', function ($trail) {
    $trail->parent('role');
    $trail->push(__('gennix.breadcrumbs.details'));
});

// Dashboard > Role > Create
Breadcrumbs::for('role_create', function ($trail) {
    $trail->parent('role');
    $trail->push(__('gennix.breadcrumbs.create'));
});

// Dashboard > Role > Edit
Breadcrumbs::for('role_edit', function ($trail) {
    $trail->parent('role');
    $trail->push(__('gennix.breadcrumbs.edit'));
});


// Dashboard > User
Breadcrumbs::for('user', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('gennix.breadcrumbs.user'), route('user.index'));
});

// Dashboard > User > Details
Breadcrumbs::for('user_show', function ($trail) {
    $trail->parent('user');
    $trail->push(__('gennix.breadcrumbs.details'));
});

// Dashboard > User > Create
Breadcrumbs::for('user_create', function ($trail) {
    $trail->parent('user');
    $trail->push(__('gennix.breadcrumbs.create'));
});

// Dashboard > User > Edit
Breadcrumbs::for('user_edit', function ($trail) {
    $trail->parent('user');
    $trail->push(__('gennix.breadcrumbs.edit'));
});

// Dashboard > User > Password
Breadcrumbs::for('user_password', function ($trail) {
    $trail->parent('user');
    $trail->push(__('gennix.breadcrumbs.password'));
});

// Dashboard > Contact
Breadcrumbs::for('contact', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('gennix.breadcrumbs.contact'), route('contact.index'));
});

// Dashboard > Contact > Details
Breadcrumbs::for('contact_show', function ($trail) {
    $trail->parent('contact');
    $trail->push(__('gennix.breadcrumbs.details'));
});

// Dashboard > Audit
Breadcrumbs::for('audit', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('gennix.breadcrumbs.audit'), route('audit.index'));
});

// Dashboard > Audit > Details
Breadcrumbs::for('audit_show', function ($trail) {
    $trail->parent('audit');
    $trail->push(__('gennix.breadcrumbs.details'));
});

// Dashboard > Audit > Create
Breadcrumbs::for('audit_create', function ($trail) {
    $trail->parent('audit');
    $trail->push(__('gennix.breadcrumbs.create'));
});

// Dashboard > Audit > Edit
Breadcrumbs::for('audit_edit', function ($trail) {
    $trail->parent('audit');
    $trail->push(__('gennix.breadcrumbs.edit'));
});

// Dashboard > Notification
Breadcrumbs::for('notification', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('gennix.breadcrumbs.notification'), route('notification.index'));
});

// Dashboard > Notification > Details
Breadcrumbs::for('notification_show', function ($trail) {
    $trail->parent('notification');
    $trail->push(__('gennix.breadcrumbs.details'));
});

// Dashboard > Notification > Create
Breadcrumbs::for('notification_create', function ($trail) {
    $trail->parent('notification');
    $trail->push(__('gennix.breadcrumbs.create'));
});

// Dashboard > Notification > Edit
Breadcrumbs::for('notification_edit', function ($trail) {
    $trail->parent('notification');
    $trail->push(__('gennix.breadcrumbs.edit'));
});
