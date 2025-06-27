<?php
$moduleTablename = "tbl_users"; // Database table name
$moduleId = 1;                // module id >>>>> tbl_modules
$moduleFoldername = "";        // Image folder name

if (isset($_GET['page']) && $_GET['page'] == "user" && isset($_GET['mode']) && $_GET['mode'] == "list"):
    ?>
    <h3>
        List Users
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="AddNewUsers();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-plus-square"></i>
    </span>
            <span class="button-content"> Add User </span>
        </a>
    </h3>
    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                <thead>
                <tr>
                    <th class="text-center">S.No.</th>
                    <th>Full Name</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Access Type</th>
                    <th class="text-center">Email</th>
                    <th class="text-center"><?php echo $GLOBALS['basic']['action']; ?></th>
                </tr>
                </thead>

                <tbody>
                <?php $records = User::find_by_sql("SELECT * FROM " . $moduleTablename . " WHERE group_id!=3 ORDER BY sortorder ASC ");
                foreach ($records as $record): ?>
                    <tr id="<?php echo $record->id; ?>">
                        <td class="text-center"><?php echo $record->sortorder; ?></td>
                        <td>
                            <div class="col-md-7">
                                <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id; ?>);"
                                   class="loadingbar-demo"
                                   title="<?php echo $record->first_name . ' ' . $record->middle_name . ' ' . $record->last_name; ?>"><?php echo $record->first_name . ' ' . $record->middle_name . ' ' . $record->last_name; ?></a>
                            </div>
                        </td>
                        <td><?php echo $record->username; ?></td>
                        <td>
                            <?php echo Usergrouptype::get_GroupTypeName_byGpId($record->group_id); ?>
                        </td>
                        <td><?php echo !empty($record->email) ? $record->email : ''; ?></td>
                        <td class="text-center">
                            <?php
                            $statusImage = ($record->status == 1) ? "bg-green" : "bg-red";
                            $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'];
                            ?>
                            <?php if ($record->group_id != 1): ?>
                                <a href="javascript:void(0);"
                                   class="btn small <?php echo $statusImage; ?> tooltip-button statusToggler"
                                   data-placement="top" title="<?php echo $statusText; ?>"
                                   status="<?php echo $record->status; ?>" id="imgHolder_<?php echo $record->id; ?>"
                                   moduleId="<?php echo $record->id; ?>">
                                    <i class="glyph-icon icon-flag"></i>
                                </a>
                            <?php endif; ?>
                            <a href="javascript:void(0);" class="loadingbar-demo btn small bg-green tooltip-button"
                               data-placement="top" title="Permissioin"
                               onclick="permission(<?php echo $record->id; ?>);">
                                <i class="glyph-icon icon-gear"></i>
                            </a>
                            <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button"
                               data-placement="top" title="Edit" onclick="editRecord(<?php echo $record->id; ?>);">
                                <i class="glyph-icon icon-edit"></i>
                            </a>
                            <?php if ($record->group_id != 1): ?>
                                <a href="javascript:void(0);" class="btn small bg-red tooltip-button"
                                   data-placement="top" title="Remove"
                                   onclick="recordDelete(<?php echo $record->id; ?>);">
                                    <i class="glyph-icon icon-remove"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php elseif (isset($_GET['mode']) && $_GET['mode'] == "addEdit"):
    if (isset($_GET['id']) && !empty($_GET['id'])):
        $userId = addslashes($_REQUEST['id']);
        $usersInfo = User::find_by_id($userId);
        $published = ($usersInfo->status == 1) ? "checked" : "";
        $unpublished = ($usersInfo->status == 0) ? "checked" : "";
    endif;
    ?>
    <h3>
        <?php echo (isset($_GET['id'])) ? 'Edit User' : 'Add User'; ?>
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewuserslist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>
    <script language="javascript">
        $(document).ready(function () {
            $('#adminusersetting_frm').passroids({
                main: '#password',
                verify: '#passwordConfirm',
                minimum: 6
            });
        });
    </script>
    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <form action="" class="col-md-10 center-margin" id="adminusersetting_frm">
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Group Type :
                        </label>
                    </div>
                    <div class="form-input col-md-4" style="padding:0px !important;">
                        <select class="validate[required,length[0,500]]" id="field_type" name="field_type">
                            <option value="">Choose</option>
                            <?php $GroupTypeRec = Usergrouptype::find_all();
                            if ($GroupTypeRec): foreach ($GroupTypeRec as $GroupTypeRow):
                                $sel = (!empty($usersInfo->group_id) && $usersInfo->group_id == $GroupTypeRow->id) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $GroupTypeRow->id; ?>" <?php echo $sel; ?>><?php echo $GroupTypeRow->group_name; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            First Name :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="First Name" class="col-md-4 validate[required,length[0,50]]" type="text"
                               name="first_name" id="first_name"
                               value="<?php echo !empty($usersInfo->first_name) ? $usersInfo->first_name : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Middle Name :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Middle Name" class="col-md-4 validate[length[0,50]]" type="text"
                               name="middle_name" id="middle_name"
                               value="<?php echo !empty($usersInfo->middle_name) ? $usersInfo->middle_name : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Last Name :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Last Name" class="col-md-4 validate[length[0,50]]" type="text"
                               name="last_name" id="last_name"
                               value="<?php echo !empty($usersInfo->last_name) ? $usersInfo->last_name : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Username :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Username"
                               class="col-md-4 validate[required,maxSize[10],custom[onlyLetterNumber]]" type="text"
                               name="username" id="username"
                               value="<?php echo !empty($usersInfo->username) ? $usersInfo->username : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Password :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Password"
                               class="col-md-4 <?php echo !empty($usersInfo) ? '' : 'validate[required,length[0,50]]'; ?>"
                               type="password" name="password" id="password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Re-password :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Re-password" class="col-md-4 validate[equals[password]]" type="password"
                               id="passwordConfirm">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Email :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Email Address" class="col-md-4 validate[required,custom[email]]" type="text"
                               id="email" name="email"
                               value="<?php echo !empty($usersInfo->email) ? $usersInfo->email : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            CC Email :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="CC Email Address" class="col-md-4" type="text" id="optional_email"
                               name="optional_email"
                               value="<?php echo !empty($usersInfo->optional_email) ? $usersInfo->optional_email : ""; ?>">
                        <br/>
                        <small>if more than one email address. e.g. email1@email.com;email2@email.com</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2"></div>
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio" name="status" id="check1"
                               value="1" <?php echo !empty($published) ? $published : "checked"; ?>>
                        <label for="">Published</label>
                        <input type="radio" class="custom-radio" name="status" id="check0"
                               value="0" <?php echo !empty($unpublished) ? $unpublished : ""; ?>>
                        <label for="">Un-published</label>
                    </div>
                </div>
                <div class="form-label col-md-2"></div>
                <button type="submit" name="submit"
                        class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                        id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
                </button>
                <input type="hidden" name="idValue" id="idValue" value="<?php echo !empty($userId) ? $userId : 0; ?>"/>
            </form>
        </div>
    </div>

<?php elseif (isset($_GET['mode']) && $_GET['mode'] == "permission"):
    if (isset($_GET['id']) && !empty($_GET['id'])):
        $userId = addslashes($_REQUEST['id']);
        $usersInfo = User::find_by_id($userId);
    endif; ?>
    <h3>
        Permission Settings
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewuserslist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>
    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <a href="javascript:;" class="check-all">Check All</a> | <a href="javascript:;" class="uncheck-all">Un-check
                All</a>
            <form action="" method="post" class="col-md-12 center-margin" id="permission_frm">
                <ul>
                    <?php $res = '';
                    $parentmenu = Module::find_all_parent();
                    foreach ($parentmenu as $key => $val) {
                        $childmenu = Module::find_child_by($val->id);
                        $res .= '<li>
                        <div class="form-checkbox-radio">
                            <input type="checkbox" class="mcheck parent" name="module_id[]" value="' . $val->id . '"/> ' . $val->name . '
                        </div>';
                        if (!empty($childmenu)) {
                            $res .= '<ul style="margin-left:40px;">';
                            foreach ($childmenu as $k => $v) {
                                $res .= '<li>
                                    <div class="form-checkbox-radio">
                                        <input type="checkbox" class="mcheck child-' . $v->parent_id . '" data-parent="' . $v->parent_id . '" name="module_id[]" value="' . $v->id . '"/> ' . $v->name . '
                                    </div>
                                </li>';
                            }
                            $res .= '</ul>';
                        }
                        $res .= '</li>';
                    }
                    echo $res; ?>
                </ul>
                <br/>
                <button type="submit" name="submit"
                        class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                        id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
                </button>
                <input type="hidden" name="idValue" id="idValue" value="<?php echo !empty($userId) ? $userId : 0; ?>"/>
            </form>
        </div>
    </div>
<?php endif; ?>