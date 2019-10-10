<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property int $user_type 1 = Super Admin User, 2 = Admin User (Role Wise), 3 = Visitor
 * @property string|null $user_image
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $status
 * @property int $Deletable
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $AddedBy
 * @property int|null $ModifiedBy
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserType($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\UserPermission
 *
 * @property int $permission_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereRoleId($value)
 */
	class UserPermission extends \Eloquent {}
}

namespace App{
/**
 * App\UserRole
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $AddedBy
 * @property int|null $ModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereUpdatedAt($value)
 */
	class UserRole extends \Eloquent {}
}

